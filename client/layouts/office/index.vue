<script setup lang="ts">
const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: '/components/table' }
];
</script>

<template>
  <Layout>
    <LayoutBody>
      <div class="flex flex-col h-screen">
        <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
          <!-- Logo -->
          <div class="flex items-center min-w-[200px]">
            <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Dokumentaryo</p>
          </div>

          <!-- Spacing divs for layout balance (hidden on small screens) -->
          <div class="hidden sm:block col-span-1 h-[100px]"></div>
          <div class="hidden sm:block col-span-1 h-[100px]"></div>
          <div class="hidden sm:block col-span-1 h-[100px]"></div>
          <div class="hidden sm:block col-span-1 h-[100px]"></div>

          <!-- Navigation -->
          <div class="w-full sm:w-auto col-span-3 flex justify-center sm:justify-end">
            <THorizontalNavigation :links="links">
              <template #default="{ link }">
                <span class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative">{{ link.label }}</span>
              </template>
            </THorizontalNavigation>
          </div>
        </div>
        
        <!-- Top Bar -->
        <slot />
      </div>
    </LayoutBody>
  </Layout>
</template>
