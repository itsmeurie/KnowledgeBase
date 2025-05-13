<script setup lang="ts">
import type { Section, Office, UploadedFile } from "~/types";
import { useRouter } from "vue-router";
import { marked } from "marked";
import { computed, ref, onMounted, watch } from "vue";
import UploadingFile from "~/pages/uploadingFile.vue";
import PreviewFile from "./previewFile.vue";
import DeleteModal from "./DeleteModal.vue";

const $guard = useGuard();

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

const showDeleteModal = ref(false);
const itemIdToDelete = ref<number | null>(null);

const openDeleteModal = (itemId: number) => {
  itemIdToDelete.value = itemId;
  showDeleteModal.value = true;
};

// const handleDelete = (itemId: number) => {
//   console.log("Item to delete:", itemId);
// };

const onDelete = (data: Section) => {
  showDeleteModal.value = false;
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
  merge(fileSection.value, data);
  modal.value.show = false;
};

const renderedContent = computed(() =>
  marked(activeSubsection.value?.contents || section.value?.contents || ""),
);

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
</script>

<template>
  <div class="mt-12 grid gap-4 sm:grid-cols-10">
    <!-- Left Side Bar -->
    <aside class="px-4 sm:col-span-2 sm:px-6">
      <div class="mb-4">
        <TInput
          icon="i-heroicons-magnifying-glass-20-solid"
          size="sm"
          color="white"
          :trailing="false"
          placeholder="Search here..."
          class="w-full"
        />
      </div>

      <!-- Main Section -->
      <div class="mb-1">
        <h6
          class="hover:text-primary text-md cursor-pointer font-extrabold"
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
          class="cursor-pointer rounded px-2 py-1 font-semibold transition-colors hover:underline"
          :class="{ 'text-primary': sub.id === activeSubsection?.id }"
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

        <div class="flex min-w-[1rem] items-center justify-end gap-3 p-2">
          <!-- Restore  -->
          <!-- <TButton
            label="Restore"
            color="gray"
            variant="ghost"
            :to="{ name: 'Restore' }"
          /> -->
          <div>
            <!-- Your Article Content -->

            <!-- Delete Button -->
            <TIcon
              name="tabler:trash"
              class="h-6 w-6 cursor-pointer transition-colors duration-200 hover:text-black"
              @click="openDeleteModal"
            />

            <!-- Delete Modal Component -->
            <!-- <DeleteModal
              :show="showDeleteModal"
              @update:show="showDeleteModal = $event"
              @delete="handleDelete"
            /> -->
          </div>

          <!-- Edit  -->
          <TIcon
            name="tabler:pencil"
            v-if="$guard.can('update_section')"
            class="h-6 w-6 cursor-pointer transition-colors duration-200 hover:text-black"
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
  </div>
</template>
