<script setup>
import { marked } from "marked";
import { debounce } from "lodash-es";
// import { ref, computed } from 'vue';

const input = defineModel({
  default: "#",
});
// const input = ref('#');
const output = computed(() => marked(input.value));

const update = debounce((event) => {
  input.value = event.target.value;
}, 100);
</script>

<template>
  <div class="flex h-screen flex-col md:flex-row">
    <textarea
      class="h-1/2 w-full resize-none border-b border-gray-300 p-4 text-sm outline-none md:h-full md:w-1/2 md:border-b-0 md:border-r"
      v-model="input"
    ></textarea>
    <div
      class="prose dark:prose-invert prose-blockquote:border-l-4 prose-blockquote:border-gray-300 prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:text-gray-600 prose-table:border prose-table:border-gray-200 prose-th:bg-gray-100 prose-th:text-left h-1/2 w-full max-w-4xl overflow-auto p-6 text-base leading-relaxed md:h-full md:w-1/2"
      v-html="output"
    ></div>
  </div>
</template>
