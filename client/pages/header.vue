<script setup lang="ts">
const linksNav = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: '/playground#about-documentation' }
];

const aboutSection = ref<HTMLElement | null>(null);

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

</script>

<template>
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
</template>
