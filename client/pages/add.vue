<script setup lang="ts">
import MarkdownEditor from '@/pages/markdowneditor.vue'
const links = [{
  label: 'Home',
  to: '/playgroud'
}, {
  label: 'Docs',
  to: '/offices'
}, {
  label: 'About',
  to: '/add'
}]

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
          <div class="w-full sm:w-auto col-span-3 flex justify-center sm:justify-end">
            <THorizontalNavigation :links="links">
              <template #default="{ link }">
                <span class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative">{{ link.label }}</span>
              </template>
            </THorizontalNavigation>
          </div>
        </div>


<!-- Body -->
<div class="m-2 grid gap-4 sm:grid-cols-4">
  <!-- Input Field Information/Documents -->
  <div class="sm:grid-row-8 col-span-1 min-h-[400px] w-[300px]">
    <!-- Information -->
    <div class="row-span-1 min-h-[30px] w-[300px]">
      <p class="font-Inter font-bold ml-[40px] p-2 pt-3 text-lg text-black">INFORMATION</p>
    </div>
    <div class="row-span-1 w-[300px]">
      <div class="row-span-1 ml-[40px] min-h-[10px] w-[300px]">
        <p class="font-Inter px-2 py-2 text-black">Office</p>
      </div>
      <div class="row-span-1 ml-[40px] min-h-[20px] w-[250px] px-2">
        <TInput size="md" placeholder="Enter here..." />
      </div>
      <div class="row-span-1 ml-[40px] min-h-[10px] w-[300px]">
        <p class="font-Inter px-2 py-2 text-black">System</p>
      </div>
      <div class="row-span-1 ml-[40px] min-h-[20px] w-[250px] px-2">
        <TInput size="md" placeholder="Enter here..." />
      </div>
      <div class="row-span-1 ml-[40px] min-h-[10px] w-[250px]">
        <p class="font-Inter px-2 py-2 text-black">Feature</p>
      </div>
      <div class="row-span-1 ml-[40px] min-h-[30px] w-[250px] px-2">
        <TInput size="md" placeholder="Enter here..." />
      </div>
    </div>
    <!-- Aditional Resources -->
    <div class="row-span-1 ml-[40px] min-h-[30px] w-[300px] mt-[20px]">
      <p class="font-Inter font-bold p-2 pt-3 text-lg text-black">ADDITIONAL RESOURCES</p>
    </div>
    <div class="row-span-1 min-h-[50px] w-[300px]">
      <div class="row-span-1 ml-[40px] min-h-[20px] w-[300px]">
        <p class="font-Inter px-2 py-2 text-black">Upload File</p>
      </div>
      <div class="row-span-1 ml-[40px] min-h-[30px] w-[250px] px-2">
        <TInput type="file" size="md" icon="i-heroicons-folder" model-value="" />
      </div>
      <div class="row-span-1 ml-[40px] min-h-[20px] w-[300px]">
        <p class="font-Inter px-2 py-2 text-black">Description</p>
      </div>
      <div class="row-span-1 ml-[40px] min-h-[30px] w-[250px] px-2">
        <TInput size="md" placeholder="Enter here..." />
      </div>
    </div>
  </div>
  <div class="col-span-3 min-h-[500px] w-[1000px] border-4 rounded-lg border-black-500">
    <MarkdownEditor />
  </div>
</div>




</template>