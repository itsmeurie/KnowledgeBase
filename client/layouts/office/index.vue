<script setup lang="ts">
const aboutSection = ref<HTMLElement | null>(null);
const OfficeHeader = defineAsyncComponent(() => import('~/pages/header.vue'))

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