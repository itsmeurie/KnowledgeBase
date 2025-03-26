<script setup lang="ts">
const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: '/' }
];
const manuals = [
  
  { "title": "Overview", "subtitle": "A quick summary of everything you need to know.", "to": "/articlepage" },
  { "title": "Cedula", "subtitle": "Learn the Everything about cedula.", "to": "/articlepage" },
  { "title": "How to Get", "subtitle": "Find out how to acquire what you need.", "to": "/articlepage" },
  { "title": "Where to Get Cedula", "subtitle": "Discover where to get your Cedula.", "to": "/articlepage" },
  { "title": "How to Get Cedula", "subtitle": "Ways how to get your Cedula.", "to": "/articlepage" },
  { "title": "My Role and Responsibilities", "subtitle": "Understanding my role and responsibilities.", "to": "/articlepage" },
  { "title": "The Importance of This Place", "subtitle": "Why this place matters and what it offers.", "to": "/articlepage" },
  { "title": "Key Figures and Concepts", "subtitle": "A deeper look into an important figure or concept.", "to": "/articlepage" }
  
];

</script>

<template> 
    <!-- Header -->
  <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
        <!-- Logo -->
        <div class="flex items-center min-w-48 ">
          <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Dokumentaryo</p>
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
        <div class="flex justify-between items-center">
          <h5 class="text-4xl font-semibold">City Mayor's Office</h5>
</div>
<p class="text-sm max-w-xl">
  The City Mayor's Office serves as the central hub for local governance, overseeing public services, infrastructure development, and community initiatives. It is responsible for implementing policies, addressing citizen concerns, and ensuring the city's overall progress and welfare.
</p>

      </div>
    </div>
      <div class="flex flex-col items-center h-full p-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-7xl w-full">
      <div
        v-for="manual in manuals"
        :key="manual.to"
        @click="navigateTo(manual.to)"
        class="cursor-pointer hover:bg-gray-100 transition border border-gray-200 rounded-lg p-4 shadow-md"
      >
        <h5 class="text-lg font-semibold text-green-800">{{ manual.title }}</h5>
        <p class="text-sm text-gray-600 transition duration-300 hover:underline">{{ manual.subtitle }}</p>
      </div>
    </div>
  </div>
    </div>
  </div>

</template>