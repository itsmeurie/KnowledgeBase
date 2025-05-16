<script setup lang="ts">
import type { Section, Office } from "~/types";
import DeleteModal from "../DeleteModal.vue";
import Restore from "./Restore.vue";
const $guard = useGuard();

const { $api } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const user = useAuthStore();

// const office = ref<Office | null>(null);
const officeSection = ref<Section[]>([]);
const aboutSection = ref<HTMLElement | null>(null);

const goToAdd = (code: string) => {
  router.push(`/systems/${user.office?.code.toLowerCase()}/create`);
};
const modal = ref<{
  show: boolean;
  data?: Section;
  type: string;
}>({
  show: false,
  data: undefined,
  type: "DeleteModal",
});

const openModal = (data?: Section, type: string = "DeleteModal") => {
  modal.value.data = data;
  modal.value.type = type;
  modal.value.show = true;
};

const toggleModal = async (data: Section) => {
  const section = officeSection.value.find((s) => s.id === data.id);
  if (section) {
    section.active = !section.active;
  }
  modal.value.show = false;

  // Refresh sections after delete/restore
  await fetchOfficeSectionList();
};

const goToArticlePage = (slug: string) => {
  if (user.office?.code) {
    router.push({
      name: "Article",
      params: {
        code: user.office.code.toLowerCase(),
        slug: slug,
      },
    });
  } else {
    console.error("Office code is missing!");
  }
};

// // Fetch Office Data
// async function fetchOffice() {
//   try {
//     const response = await $api.get("/offices/", {
//       params: { code: route.params.slug },
//     });
//     if (response.data.length > 0) {
//       // office.value = response.data[0];
//       fetchOfficeSectionList(); // Ensure sections are fetched after office data is set
//     }
//   } catch (error) {
//     console.error("Error fetching office:", error);
//   }
// }

// Fetch Office Sections
async function fetchOfficeSectionList() {
  if (!user.office?.id) return;
  try {
    const response = await $api.get(`/sections/office`);
    officeSection.value = response.data.data;
  } catch (error) {
    console.error("Error fetching sections:", error);
  }
}

useTeams(() => {
  fetchOfficeSectionList();
  user.office;
});

onMounted(() => {
  fetchOfficeSectionList();
});
</script>

<template>
  <!-- Office Details -->
  <div class="flex h-full flex-col items-center p-4">
    <div class="flex w-full max-w-7xl flex-col gap-2">
      <div
        class="rounded-md bg-[url('https://static.vecteezy.com/system/resources/previews/009/302/805/non_2x/silhouette-landscape-with-fog-forest-pine-trees-mountains-illustration-of-national-park-view-mist-black-and-white-good-for-wallpaper-background-banner-cover-poster-free-vector.jpg')] bg-cover bg-center bg-no-repeat shadow-lg dark:bg-[url('https://nighteye.app/wp-content/uploads/2020/04/claudio-testa-fb_CZ4hZXWo-unsplash.jpg')]"
      >
        <div class="flex flex-col gap-4 rounded-md px-6 py-6">
          <!-- HEADER -->
          <div class="flex items-center justify-between">
            <h5 class="text-4xl font-semibold">{{ user.office?.name }}</h5>
          </div>
          <p class="max-w-xl text-sm">{{ user.office?.description }}</p>
        </div>
      </div>

      <!-- Sections -->
      <div class="flex h-full flex-col items-center p-4">
        <div
          class="grid w-full max-w-7xl grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
        >
          <div
            v-for="section in officeSection"
            :key="section.id"
            class="cursor-pointer rounded-lg border border-gray-200 p-4 shadow-md transition"
          >
            <div class="flex flex-auto items-center justify-end gap-2">
              <TButton
                :icon="section.active ? 'tabler:trash' : 'tabler:restore'"
                v-if="$guard.canAny('delete_article', 'restore_article')"
                variant="ghost"
                :class="[
                  'h-6 w-6 cursor-pointer items-center justify-end transition-colors duration-200',
                  section.active ? 'text-red-500' : 'text-green-500',
                  'hover:text-black',
                ]"
                @click="
                  openModal(section, section.active ? 'DeleteModal' : 'Restore')
                "
              />
            </div>
            <div @click="goToArticlePage(section.slug)">
              <h5 class="text-lg font-bold">
                {{ section.title }}
              </h5>
              <p class="text-sm transition duration-300 hover:underline">
                {{ section.description }}
              </p>
            </div>
          </div>

          <!-- Add New Section -->
          <div
            @click="goToAdd(user.office?.code!)"
            v-if="$guard.can('create_section')"
            class="hover:bg-primary flex cursor-pointer flex-col items-center justify-center rounded-lg border border-gray-200 p-4 shadow-md"
          >
            <TIcon name="tabler:plus"></TIcon>
            <h5 class="text-lg font-semibold">Create New Section/Manual</h5>
          </div>
        </div>
      </div>
    </div>
    <TModal v-model="modal.show" :prevent-close="true">
      <DeleteModal
        v-if="modal.type === 'DeleteModal'"
        :modelValue="modal.data!"
        @delete="toggleModal"
        @close="modal.show = false"
      />
      <Restore
        v-if="modal.type === 'Restore'"
        :modelValue="modal.data!"
        @restore="toggleModal"
        @close="modal.show = false"
      />
    </TModal>
  </div>
</template>
