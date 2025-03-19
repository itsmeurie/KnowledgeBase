<template>
  <Layout>
    <LayoutBody>
      <div class="flex flex-col h-screen ">
        <TSkeleton class="flex w-full h-24"></TSkeleton>
        <!-- Top Bar -->
        <slot />
      </div>
    </LayoutBody>
  </Layout>
</template>
