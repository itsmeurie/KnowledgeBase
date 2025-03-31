<script setup lang="ts">
import type { Section, Office } from '~/types';

const { $api } = useNuxtApp();
const route = useRoute();
const router = useRouter();

const office = ref<Office>();
<<<<<<< Updated upstream
const officeSection = ref<Section[]>([])
const aboutSection = ref<HTMLElement | null>(null);

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};
=======
const officeSection = ref<Section[]>([]);
>>>>>>> Stashed changes

function fetchOffice() {
    $api.get('/offices/', { params: { code: route.params.slug } })
        .then((response) => {
            office.value = response.data[0];
        });
}

function fetchOfficeSectionList() {
  console.log("Fetching sections for office_id:", office.value?.id);
if (!office.value?.id) return; 
$api.get(`/sections/${office.value.id}`)
    .then(response => {
        officeSection.value = response.data;
    })
    .catch(error => {
        console.error("Error fetching sections:", error);
    });

}

onMounted(() => {
    fetchOffice();
    watch(() => office.value, (newOffice) => {
        if (newOffice) fetchOfficeSectionList();
    });
});

const linksNav = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/systemsections' },
  { label: 'About', to: '/playground#about-documentation' }
];

const goToArticlePage = () => {
  router.push('/articlepage');
};
</script>

<template> 
    <!-- Header -->
  <div class="flex flex-wrap items-center justify-between px-4  gap-4 m-1">
        <!-- Logo -->
        <div class="flex items-center">
            <img class="h-20 w-20 object-contain mt-6" src="@/assets/image/final-logo.png"/>
              <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Knowledge Base</p>
        </div>


        <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>

        <!-- Navigation -->
        <div class="w-full sm:w-auto col-span-3 flex justify-center">
          <THorizontalNavigation :links="linksNav"> <!-- Inayos-->
                <template #default="{ link }">
                  <a 
                    :href="link.to" 
                    @click.prevent="link.label === 'About' ? scrollToAbout() : null" 
                    class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative"
                  >
                    {{ link.label }}
                  </a>
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
            class="flex flex-col justify-center items-center cursor-pointer hover:bg-green-100 transition border border-gray-200 rounded-lg p-4 shadow-md">
            <TIcon name="tabler:plus"></TIcon>
            <h5 class="text-lg font-semibold text-green-800">Create New Section/Manual</h5>
            <p class="text-sm text-gray-600 transition duration-300 hover:underline">para masaya.</p>
          </div>
    </div>
  </div>
    </div>
  </div>

</template>