<script setup lang="ts">
import type { Section, Office, UploadedFile } from "~/types";
import { useRouter } from "vue-router";
import { marked } from "marked";
import { computed, ref, onMounted, watch } from "vue";
import UploadingFile from "~/pages/uploadingFile.vue";
import PreviewFile from "./previewFile.vue";
import DeleteModal from "./DeleteModal.vue";
import Restore from "./Restore.vue";

const $guard = useGuard();
const searchResults = ref<Section[]>([]);
const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const { office } = useAuthStore();
const showFileModal = ref(false);
const { merge } = useModels();

const offices = ref<Office>();
const officeSection = ref<Section[]>([]);
const section = ref<Section>();
const fileSection = ref<Array<Section>>([]);
const activeSubsection = ref<Section | null>(null);

const isHovered = ref(false);
const openItems = ref<string[]>([]);
const searchTerm = ref("");
const filteredSubsections = computed(() => {
  if (!section.value?.subsections) return [];
  if (!searchTerm.value.trim()) return section.value.subsections;

  const lower = searchTerm.value.toLowerCase();
  return section.value.subsections.filter(
    (sub) =>
      sub.title.toLowerCase().includes(lower) ||
      sub.contents?.toLowerCase().includes(lower),
  );
});

const selectSearchResult = (result: Section) => {
  if (result.id === section.value?.id) {
    clearSubsection();
  } else {
    activeSubsection.value = result;
  }
  searchResults.value = [];
  searchTerm.value = "";
};

const deleteModal = ref<{
  show: boolean;
  data?: Section;
  type: string;
}>({
  show: false,
  data: undefined,
  type: "DeleteModal",
});

const openDeleteModal = (data?: Section, type: string = "DeleteModal") => {
  deleteModal.value.data = data;
  deleteModal.value.type = type;
  deleteModal.value.show = true;
};

const toggleModal = (data: Section) => {
  const target = officeSection.value.find((s) => s.id === data.id);

  if (target) {
    target.active = !target.active; // Toggle active status

    if (target.subsections) {
      target.subsections = target.subsections.map((sub) => ({
        ...sub,
        active: target.active,
      }));
    }
  }

  if (section.value?.id === data.id) {
    section.value.active = !section.value.active;
    section.value.subsections?.forEach(
      (sub) => (sub.active = section.value!.active),
    );
  }

  if (activeSubsection.value?.id === data.id) {
    activeSubsection.value.active = !activeSubsection.value.active;
  }

  modal.value.show = false;
};

const modal = ref<{
  show: boolean;
  data?: Section | UploadedFile;
  type: string;
}>({
  show: false,
  data: undefined,
  type: "UploadingFile",
});

const openModal = (
  data?: Section | UploadedFile,
  type: string = "UploadingFile",
) => {
  modal.value.data = data;
  modal.value.type = type;
  modal.value.show = true;
};

const showEditModal = ref(false);
const editForm = ref<{
  id: number | null;
  title: string;
  contents: string;
}>({
  id: null,
  title: "",
  contents: "",
});

const onUpload = (data: Section) => {
  log(data);
  merge(officeSection.value, data);
  section.value = { ...data };
  modal.value.show = false;
};

const renderedContent = computed(() => {
  if (activeSubsection.value) {
    return marked(activeSubsection.value.contents ?? "");
  }
  return marked(section.value?.contents ?? "");
});

const formattedUpdatedAt = computed(() => {
  const dateStr =
    activeSubsection.value?.updated_at || section.value?.updated_at;
  if (!dateStr) return "Unknown";

  const date = new Date(dateStr);
  return date.toLocaleDateString("en-US", {
    month: "numeric",
    day: "numeric",
    year: "numeric",
  });
});

const fetchOffice = () => {
  if (!route.params.slug) return;

  $api
    .get("/offices/", {
      params: { code: route.params.code },
    })
    .then((response) => {
      offices.value = response.data[0];
      if (office?.id) {
        fetchSection();
      }
    })
    .catch((error) => {
      console.error("Error fetching office:", error);
    });
};

const fetchSection = () => {
  if (!route.params.slug) return;

  $api
    .get(`/sections/slug/${route.params.slug}`)
    .then((response) => {
      section.value = response.data;
      officeSection.value = [response.data];
      if (section.value?.title) {
        openItems.value = [section.value.title];
      }
    })
    .catch((error) => {
      console.error("Error fetching section:", error);
    });
};
const selectSubsection = (subsection: Section) => {
  activeSubsection.value = subsection;
};

const clearSubsection = () => {
  activeSubsection.value = null;
};

const openEditModal = () => {
  const target = activeSubsection.value || section.value;
  if (!target) return;

  editForm.value = {
    id: target.id,
    title: target.title,
    contents: target.contents,
  };

  showEditModal.value = true;
};

const submitEdit = async () => {
  try {
    if (!editForm.value.id) return;

    const response = await $api.put(`/sections/${editForm.value.id}`, {
      title: editForm.value.title,
      contents: editForm.value.contents,
    });

    const updated = response.data.section;

    // Update activeSubsection
    if (activeSubsection.value && activeSubsection.value.id === updated.id) {
      activeSubsection.value.title = updated.title;
      activeSubsection.value.contents = updated.contents;
    }

    // Update subsection
    if (section.value?.subsections) {
      const index = section.value.subsections.findIndex(
        (s) => s.id === updated.id,
      );
      if (index !== -1) {
        section.value.subsections[index] = {
          ...section.value.subsections[index],
          ...updated,
        };
      }
    }

    // Update main section
    if (section.value && section.value.id === updated.id) {
      section.value.title = updated.title;
      section.value.contents = updated.contents;
    }

    showEditModal.value = false;
  } catch (error) {
    console.error("Failed to update section:", error);
  }
};

onMounted(() => {
  fetchOffice();
});

watch(
  () => route.params.slug,
  () => {
    if (office) {
      fetchSection();
      const matchedSection = officeSection.value.find(
        (s) => s.slug === route.params.slug,
      );
      if (matchedSection) {
        openItems.value = [matchedSection.title];
      }
    }
  },
);
let debounceTimer: ReturnType<typeof setTimeout>;

const performSearch = async (term: string) => {
  if (!term.trim()) {
    searchResults.value = [];
    return;
  }

  try {
    const response = await $api.get(`/sections/slug/${route.params.slug}`, {
      params: { search: term },
    });

    const sectionData = response.data;
    const results: Section[] = [];
    const lower = term.toLowerCase();

    if (
      sectionData.title.toLowerCase().includes(lower) ||
      sectionData.contents?.toLowerCase().includes(lower)
    ) {
      results.push({
        ...sectionData,
        title: sectionData.title + " (Main Section)",
      });
    }

    const matchingSubs = (sectionData.subsections || []).filter(
      (sub: Section) =>
        sub.title.toLowerCase().includes(lower) ||
        sub.contents?.toLowerCase().includes(lower),
    );

    results.push(...matchingSubs);
    searchResults.value = results;
  } catch (error) {
    console.error("Search error:", error);
    searchResults.value = [];
  }
};

// Watch with Debounce
watch(searchTerm, (term) => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => performSearch(term), 300);
});
</script>

<template>
  <div class="mt-12 grid gap-4 sm:grid-cols-10">
    <!-- Main Sidebar with Search -->
    <aside class="relative px-4 sm:col-span-2 sm:px-6">
      <div class="mb-4">
        <!-- Search Engine -->
        <div class="relative">
          <TInput
            v-model="searchTerm"
            icon="i-heroicons-magnifying-glass-20-solid"
            size="sm"
            color="white"
            :trailing="false"
            placeholder="Search here..."
            class="w-full"
          />

          <div
            v-if="searchResults.length > 0"
            class="absolute left-0 top-full z-50 mt-2 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-lg dark:bg-gray-800"
          >
            <div
              v-for="result in searchResults"
              :key="result.id"
              class="hover:bg-primary cursor-pointer px-3 py-2 text-sm"
              @click="selectSearchResult(result)"
            >
              <div class="font-semibold">{{ result.title }}</div>
              <div class="truncate" v-if="result.contents">
                {{ result.contents }}
              </div>
            </div>
          </div>

          <div
            v-if="searchResults.length === 0 && searchTerm"
            class="absolute left-0 top-full z-50 mt-2 w-full rounded-md border bg-white p-3 text-sm text-gray-500 shadow-lg"
          >
            No search results found.
          </div>
        </div>
      </div>

      <!-- Main Section -->
      <div class="mb-1">
        <h6
          class="text-md cursor-pointer font-extrabold"
          @click="clearSubsection"
        >
          {{ section?.title }}
        </h6>
      </div>

      <!-- Subsections List -->
      <div class="ml-1 max-h-96 overflow-y-auto pr-2 text-sm scrollbar-thin">
        <div
          v-for="sub in section?.subsections || []"
          :key="sub.id"
          @click="selectSubsection(sub)"
          class="cursor-pointer rounded px-2 py-1 font-semibold transition-colors"
          :class="{
            'underline hover:underline': sub.id === activeSubsection?.id,
            'hover:underline': sub.id !== activeSubsection?.id,
          }"
        >
          {{ sub.title }}
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="col-span-full mx-4 flex flex-col gap-2 sm:col-span-6">
      <!-- Breadcrumbs -->
      <div class="flex flex-wrap items-center justify-between text-sm">
        <nav class="flex flex-wrap items-center space-x-2 text-sm sm:text-base">
          <NuxtLink
            :to="{
              name: 'system-sections',
              params: { code: office?.code?.toLowerCase() },
            }"
            class="transition-colors"
            :class="{
              'text-primary': isHovered,
              'hover:text-primary': !isHovered,
            }"
            @mouseenter="isHovered = true"
            @mouseleave="isHovered = false"
          >
            {{ office?.name }}
          </NuxtLink>

          <span v-if="section" class="mx-2">></span>
          <button
            v-if="section"
            @click="clearSubsection"
            class="hover:text-primary transition-colors"
          >
            {{ section?.title }}
          </button>

          <span v-if="activeSubsection" class="mx-2">></span>

          <!-- Subsection Title -->
          <span v-if="activeSubsection" class="text-sm font-semibold">
            {{ activeSubsection?.title }}
          </span>
        </nav>

        <div class="flex min-w-1 items-center justify-end gap-3 p-2">
          <div v-for="section in officeSection" :key="section.id">
            <!-- Your Article Content -->

            <!-- Delete Button -->
            <TButton
              :icon="
                (activeSubsection?.active ?? section.active)
                  ? 'tabler:trash'
                  : 'tabler:restore'
              "
              variant="ghost"
              v-if="$guard.can('delete_article')"
              :class="[
                'cursor-pointer items-center justify-end',
                (activeSubsection?.active ?? section.active)
                  ? '!text-red-500'
                  : 'text-green-500',
                'hover:text-black',
              ]"
              @click="
                openDeleteModal(
                  activeSubsection || section,
                  (activeSubsection?.active ?? section.active)
                    ? 'DeleteModal'
                    : 'Restore',
                )
              "
            />
          </div>

          <!-- Edit  -->
          <TIcon
            name="tabler:pencil"
            v-if="$guard.can('update_section')"
            class="h-6 w-6 cursor-pointer text-blue-500 transition-colors duration-200 hover:text-black"
            @click="openEditModal"
          />
        </div>

        <TModal
          v-model="showEditModal"
          prevent-close
          :ui="{ width: 'w-screen-500 max-w-sm sm:max-w-sm' }"
        >
          <template #default>
            <!-- Close Icon (upper-right) -->
            <button
              @click="showEditModal = false"
              class="absolute right-4 top-4 text-gray-500 hover:text-black"
              aria-label="Close"
            >
              <TIcon name="i-heroicons-x-mark" class="h-6 w-6" />
            </button>

            <form @submit.prevent="submitEdit" class="pt-10">
              <div class="m-4 mb-4">
                <label class="block text-sm font-bold">Title</label>
                <input
                  v-model="editForm.title"
                  class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm"
                  required
                />
              </div>

              <div class="m-4">
                <label class="block text-sm font-bold">Contents</label>
                <textarea
                  v-model="editForm.contents"
                  rows="8"
                  class="mt-1 block w-full rounded-md border border-gray-300 p-2 shadow-sm"
                  required
                ></textarea>
              </div>

              <div class="m-4 flex justify-end gap-2">
                <button
                  type="button"
                  @click="showEditModal = false"
                  class="rounded border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  class="bg-primary hover:bg-primary-dark rounded px-4 py-2 text-white"
                >
                  Update
                </button>
              </div>
            </form>
          </template>
        </TModal>
      </div>
      <div>
        <TModal v-model="modal.show" :prevent-close="true">
          <UploadingFile
            v-if="modal.type === 'UploadingFile'"
            :modelValue="modal.data! as Section"
            @upload="onUpload($event)"
            @close="modal.show = false"
          />

          <PreviewFile
            v-if="modal.type === 'PreviewFile'"
            :file="modal.data as UploadedFile"
            @close="modal.show = false"
          />
        </TModal>
      </div>

      <!-- Article Content -->
      <section class="space-y-6">
        <div>
          <h1 class="text-4xl font-extrabold">
            {{ activeSubsection?.title || section?.title }}
          </h1>
        </div>
        <!-- Update Date-->
        <div class="text-sm">Last update: {{ formattedUpdatedAt }}</div>

        <!-- Markdown -->
        <div
          v-html="renderedContent"
          class="prose dark:prose-invert max-w-full"
        ></div>
      </section>
    </main>

    <!-- Documents Sidebar -->
    <aside class="col-span-full mt-8 px-4 sm:col-span-2 sm:mt-0 sm:px-6">
      <div class="text-center">
        <p class="mb-2 text-xl font-bold">More Information</p>
        <hr class="mb-4 border-gray-300" />
      </div>

      <div class="flex items-center justify-center gap-2">
        <TIcon name="tabler:book" class="text-lg" />
        <h2 class="text-lg font-semibold">Documents</h2>
      </div>

      <!-- Button for Uploading Files -->
      <div
        class="size-sm item-center text-gray hover:text-primary flex cursor-pointer items-center justify-center"
        @click="openModal(section, 'UploadingFile')"
        v-if="$guard.can('upload_files')"
        variant="solid"
      >
        <TIcon name="tabler:circle-plus" class="text-lg" />
        <h2 class="text-sm font-semibold">Add File</h2>
      </div>
      <!-- file fetching -->
      <div class="spce-y-1 mt-2">
        <template v-for="file in section?.files" :key="file.id">
          <TButton
            variant="link"
            :label="file.name"
            @click="openModal(file, 'PreviewFile')"
            class="block w-full text-left"
          />
        </template>
      </div>
    </aside>
    <TModal v-model="deleteModal.show" :prevent-close="true">
      <DeleteModal
        v-if="deleteModal.type === 'DeleteModal'"
        :modelValue="deleteModal.data!"
        @delete="toggleModal"
        @close="deleteModal.show = false"
      />
      <Restore
        v-if="deleteModal.type === 'Restore'"
        :modelValue="deleteModal.data!"
        @restore="toggleModal"
        @close="deleteModal.show = false"
      />
    </TModal>
  </div>
</template>
