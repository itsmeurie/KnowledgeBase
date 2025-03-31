<script setup lang="ts">
import type { Section, Office } from '~/types';

const { $api } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const office = ref<Office>();
const officeSection = ref<Section[]>([])

function fetchOffice() {
    $api.get('/offices/', { params: { code: route.params.slug } })
        .then((response) => {
            office.value = response.data[0];
        });
}

function fetchOfficeSectionList(title: string = "", description: string = ""){

}

onMounted(() => {
    fetchOffice();
    fetchOfficeSectionList();
});

const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/systemsections' },
  { label: 'About', to: '/playground#about-documentation' }
];
// const manuals = [
  
//   { "title": "HAHAHA", "subtitle": "A quick summary of everything you need to know.", "to": "/articlepage" },
//   // { "title": "Cedula", "subtitle": "Learn the Everything about cedula.", "to": "/articlepage" },
//   // { "title": "How to Get", "subtitle": "Find out how to acquire what you need.", "to": "/articlepage" },
//   // { "title": "Where to Get Cedula", "subtitle": "Discover where to get your Cedula.", "to": "/articlepage" },
//   // { "title": "How to Get Cedula", "subtitle": "Ways how to get your Cedula.", "to": "/articlepage" },
//   // { "title": "My Role and Responsibilities", "subtitle": "Understanding my role and responsibilities.", "to": "/articlepage" },
//   // { "title": "The Importance of This Place", "subtitle": "Why this place matters and what it offers.", "to": "/articlepage" },
//   // { "title": "Key Figures and Concepts", "subtitle": "A deeper look into an important figure or concept.", "to": "/articlepage" }
  
// ];

const goToArticlePage = ()=>{
  router.push('/articlepage');
};

</script>

<template> 
    <!-- Header -->
  <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
        <!-- Logo -->
        <div class="flex items-center min-w-60 ">
          <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Knowledge Base</p>
        </div>

        <!-- Spacing divs for layout balance (hidden on small screens) -->
        <div class="hidden sm:block col-span-1 h-[100px]"></div>
        <div class="hidden sm:block col-span-1 h-[100px]"></div>
        <div class="hidden sm:block col-span-1 h-[100px]"></div>
        <div class="hidden sm:block col-span-1 h-[100px]"></div>

        <!-- Navigation -->
        <div class="w-full sm:w-auto col-span-3 flex justify-center">
          <THorizontalNavigation :links="links">
            <template #default="{ link }">
                <span class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative">{{ link.label }}</span>
            </template>
          </THorizontalNavigation>
        </div>
  </div>
  <div  class="flex flex-col items-center h-full p-4">
    <div class="flex flex-col gap-2 max-w-7xl w-full">
      <div class="bg-cover bg-center bg-no-repeat rounded-md shadow-lg" style="background-image: url('https://static.vecteezy.com/system/resources/previews/009/302/805/non_2x/silhouette-landscape-with-fog-forest-pine-trees-mountains-illustration-of-national-park-view-mist-black-and-white-good-for-wallpaper-background-banner-cover-poster-free-vector.jpg');">
      <div class="flex flex-col gap-4 rounded-md px-6 py-6">  
        <!-- HEADER -->
        <div class="flex justify-between items-center">
          <h5 class="text-4xl font-semibold">{{ office?.name }}</h5>
        </div>
         <p class="text-sm max-w-xl"> {{ office?.description }}</p>

      </div>
    </div>
      <div class="flex flex-col items-center h-full p-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-7xl w-full">
      <div
        v-for="section in officeSection"
        :key="section.id"
        @click="goToArticlePage"
        class="cursor-pointer hover:bg-gray-100 transition border border-gray-200 rounded-lg p-4 shadow-md">
        <h5 class="text-lg font-semibold text-green-800">{{ section.title }}</h5>
        <p class="text-sm text-gray-600 transition duration-300 hover:underline">{{ section.description }}</p>
      </div>
      <div
        class="flex flex-col justify-center items-center cursor-pointer hover:bg-green-100 transition border border-gray-200 rounded-lg p-4 shadow-md"
      >
        <TIcon name="tabler:plus"></TIcon>
        <h5 class="text-lg font-semibold text-green-800">Create New Section/Manual</h5>
        <p class="text-sm text-gray-600 transition duration-300 hover:underline">para masaya.</p>
      </div>
    </div>
  </div>
    </div>
  </div>

</template>