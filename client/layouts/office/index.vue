<script setup lang="ts">
const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: 'playground#about-documentation' }
];
const aboutSection = ref<HTMLElement | null>(null);

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};
</script>

<template>
  <Layout>
    <LayoutBody>
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
          <THorizontalNavigation :links="links"> <!-- Inayos-->
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

        
        <!-- Top Bar -->
        <slot />
    </LayoutBody>
  </Layout>
</template>