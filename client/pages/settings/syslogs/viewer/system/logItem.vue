<script setup lang="ts">
const props = defineProps<{
  ln: number;
  lnWidth: number;
  noWrap: boolean;
  length: number;
}>();
</script>

<template>
  <div
    class="group flex items-center border-b border-gray-500/10 font-mono text-sm"
  >
    <div
      class="sticky left-0 select-none bg-gray-50 pr-2 text-end font-bold text-gray-500/40 group-hover:text-gray-500/75 dark:bg-gray-800"
      :style="{
        minWidth: `${lnWidth + 8}px`,
      }"
    >
      {{ ln }}
    </div>
    <div
      :class="{ 'whitespace-nowrap': noWrap }"
      class="px-3"
      :style="{ minWidth: `${length * 7.7 + 24}px` }"
    >
      <slot></slot>
    </div>
  </div>
</template>
