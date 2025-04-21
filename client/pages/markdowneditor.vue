<script setup>
import { marked } from 'marked';
import { debounce } from 'lodash-es';
import { ref, computed } from 'vue';

const input = ref('#');
const output = computed(() => marked(input.value));

const update = debounce((event) => {
  input.value = event.target.value;
}, 100);
</script>

<template>
  <div class="flex flex-col md:flex-row h-screen">
    <textarea
      class="w-full md:w-1/2 h-1/2 md:h-full resize-none outline-none border-b md:border-b-0 md:border-r border-gray-300 bg-gray-100 p-4 text-sm"
      v-model="input"
    ></textarea>
    <div
      class="w-full md:w-1/2 h-1/2 md:h-full overflow-auto p-6 max-w-4xl text-base leading-relaxed prose prose-headings:text-gray-800 prose-p:text-gray-800 prose-blockquote:border-l-4 prose-blockquote:border-gray-300 prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:text-gray-600 prose-table:border prose-table:border-gray-200 prose-th:bg-gray-100 prose-th:text-left"
      v-html="output"
    ></div>
  </div>
</template>