<script setup lang="ts">
import type { Section, Office } from "~/types";
const $guard = useGuard();

const { $api } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const { office } = useAuthStore();

// const office = ref<Office | null>(null);
const officeSection = ref<Section[]>([]);
const aboutSection = ref<HTMLElement | null>(null);

const goToAdd = (code: string) => {
  router.push(`/systems/${office?.code.toLowerCase()}/create`);
};

const goToArticlePage = (slug: string) => {
  if (office?.code) {
    router.push({
      name: "Article",
      params: {
        code: office.code.toLowerCase(),
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
  if (!office?.id) return;
  try {
    const response = await $api.get(`/sections/office`);
    officeSection.value = response.data.data;
  } catch (error) {
    console.error("Error fetching sections:", error);
  }
}

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
            <h5 class="text-4xl font-semibold">{{ office?.name }}</h5>
          </div>
          <p class="max-w-xl text-sm">{{ office?.description }}</p>
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
            @click="goToArticlePage(section.slug)"
            class="cursor-pointer rounded-lg border border-gray-200 p-4 shadow-md transition"
          >
            <h5 class="text-primary text-lg font-semibold">
              {{ section.title }}
            </h5>
            <p class="text-sm transition duration-300 hover:underline">
              {{ section.description }}
            </p>
          </div>

          <!-- Add New Section -->
          <div
            @click="goToAdd(office?.code!)"
            v-if="$guard.can('create_section')"
            class="flex cursor-pointer flex-col items-center justify-center rounded-lg border border-gray-200 p-4 shadow-md transition hover:bg-green-100"
          >
            <TIcon name="tabler:plus"></TIcon>
            <h5 class="text-primary text-lg font-semibold">
              Create New Section/Manual
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
