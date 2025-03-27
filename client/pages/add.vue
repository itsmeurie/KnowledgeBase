<script setup lang="ts">
import MarkdownEditor from '@/pages/markdowneditor.vue'
import { ref } from 'vue';

const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/add' },
  { label: 'About', to: '#about-documentation' }
];

const aboutSection = ref<HTMLElement | null>(null);

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};
</script>

<template>
  <!-- Header -->
  <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
          <!-- Logo -->
          <div class="flex items-center min-w-48 ">
            <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Dokumentaryo</p>
          </div>

           <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>

          <!-- Navigation -->
          <div class="w-full sm:w-auto col-span-3 flex justify-center sm:justify-end">
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

  <!-- Body -->
  <div class="m-2 grid gap-4 sm:grid-cols-4 p-4">
    <!-- Input Section -->
    <div class="col-span-1 min-h-[400px] w-full sm:w-[300px] p-4 border border-gray-300 rounded-lg">
      <p class="font-Inter font-bold text-lg text-black">INFORMATION</p>
      
      <div class="mt-2">
        <label class="font-Inter text-black">Office</label>
        <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
      </div>
      <div class="mt-2">
        <label class="font-Inter text-black">System</label>
        <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
      </div>
      <div class="mt-2">
        <label class="font-Inter text-black">Feature</label>
        <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
      </div>
      
      <p class="font-Inter font-bold text-lg text-black mt-4">ADDITIONAL RESOURCES</p>
      <div class="mt-2">
        <label class="font-Inter text-black">Upload File</label>
        <TInput type="file" size="md" class="w-full mt-1" />
      </div>
      <div class="mt-2">
        <label class="font-Inter text-black">Description</label>
        <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
      </div>
    </div>
    
    <!-- Markdown Editor -->
    <div class="col-span-3 min-h-[500px] w-full border-4 rounded-lg border-black-500 p-4">
      <MarkdownEditor />
    </div>
  </div>
</template>
