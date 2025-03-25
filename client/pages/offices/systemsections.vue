<script setup lang="ts">
const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: '/systemsections' }
];
const manuals = [
  { title: "Get Started", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "Overview", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "How to Get", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "Where to Use", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "Lorem", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "Ako", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "Dito", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" },
  { title: "Madame", subtitle: "Lorem ipsum dolor, sit amet consectetur adipisicing elit.", to: "/articlepage" }
  
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
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo earum, quibusdam saepe obcaecati repellat repudiandae officiis, ea exercitationem beatae nihil praesentium, magnam dolores dolorum veritatis explicabo. Aperiam corporis sunt dolorum!
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