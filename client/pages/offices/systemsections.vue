<script setup lang="ts">
import type { Section, Office } from '~/types';

const { $api } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const office = ref<Office | null>(null);
const officeSection = ref<Section[]>([]);
const aboutSection = ref<HTMLElement | null>(null);

const goToAdd = () => {
  if (route.params.slug) {
    router.push(`/offices/${route.params.slug}/add`);
  } 
};

const goToArticlePage = (slug: string) => {
  if (office.value?.code) {
    // router.push(`/offices/${office.value.code.toLowerCase()}/articlepage/`);
    router.push({
      name: 'Article',
      params: {
        code: office.value.code.toLowerCase(),
        slug: slug
      }
    });
  } else {
    console.error("Office code is missing!");
  }
};




// Fetch Office Data
async function fetchOffice() {
  try {
    const response = await $api.get('/offices/', { params: { code: route.params.slug } });
    if (response.data.length > 0) {
      office.value = response.data[0];
      fetchOfficeSectionList(); // Ensure sections are fetched after office data is set
    }
  } catch (error) {
    console.error("Error fetching office:", error);
  }
}

// Fetch Office Sections
async function fetchOfficeSectionList() {
  if (!office.value?.id) return;
  try {
    const response = await $api.get(`/sections/${office.value.id}`);
    officeSection.value = response.data.data;
  } catch (error) {
    console.error("Error fetching sections:", error);
  }
}

onMounted(() => {
  fetchOffice();
});


const OfficeHeader = defineAsyncComponent(() => import('~/pages/header.vue'))

</script>

<template> 
  <!-- Header -->
  <OfficeHeader />

  <!-- Office Details -->
  <div class="flex flex-col items-center h-full p-4">
    <div class="flex flex-col gap-2 max-w-7xl w-full">
      <div 
        class="bg-cover bg-center bg-no-repeat rounded-md shadow-lg"
        style="background-image: url('https://static.vecteezy.com/system/resources/previews/009/302/805/non_2x/silhouette-landscape-with-fog-forest-pine-trees-mountains-illustration-of-national-park-view-mist-black-and-white-good-for-wallpaper-background-banner-cover-poster-free-vector.jpg');">
        <div class="flex flex-col gap-4 rounded-md px-6 py-6">  
          <!-- HEADER -->
          <div class="flex justify-between items-center">
            <h5 class="text-4xl font-semibold">{{ office?.name }}</h5>
          </div>
          <p class="text-sm max-w-xl">{{ office?.description }}</p>
        </div>
      </div>

      <!-- Sections -->
      <div class="flex flex-col items-center h-full p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-7xl w-full">
          <div
            v-for="section in officeSection"
            :key="section.id"
            @click="goToArticlePage(section.slug)"
            class="cursor-pointer hover:bg-gray-100 transition border border-gray-200 rounded-lg p-4 shadow-md">
            <h5 class="text-lg font-semibold text-green-800">{{ section.title }}</h5>
            <p class="text-sm text-gray-600 transition duration-300 hover:underline">{{ section.description }}</p>
          </div>

          <!-- Add New Section -->
          <div
            @click="goToAdd"
            class="flex flex-col justify-center items-center cursor-pointer hover:bg-green-100 transition border border-gray-200 rounded-lg p-4 shadow-md">
            <TIcon name="tabler:plus"></TIcon>
            <h5 class="text-lg font-semibold text-green-800">Create New Section/Manual</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>