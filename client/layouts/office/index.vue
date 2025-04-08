<script setup lang="ts">
const aboutSection = ref<HTMLElement | null>(null);
const OfficeHeader = defineAsyncComponent(() => import('~/pages/header.vue'))

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
           <OfficeHeader />
            <!-- Top Bar -->
           <slot />
    </LayoutBody>
  </Layout>
</template>