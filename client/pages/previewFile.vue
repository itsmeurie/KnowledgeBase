<script setup lang="ts">
import { useNuxtApp } from "nuxt/app";
import type { UploadedFile } from "~/types";

const props = defineProps<{ file: UploadedFile }>();

const { $api } = useNuxtApp();
const src = {
  url: props.file.prevUrl,
  withCredentials: true,
};

const isPdf = props.file.name.toLowerCase().endsWith(".pdf");
const isImage = /\.(jpe?g|png|gif|bmp|webp|svg)$/i.test(props.file.name);

const downloadFile = () => {
  $api.get(props.file.downUrl, { responseType: "blob" }).then((response) => {
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", props.file.name);
    document.body.appendChild(link);
    link.click();
    window.URL.revokeObjectURL(url);
    link.remove();
  });
};

const emit = defineEmits(["close", "download"]);
</script>

<template>
  <div :class="isPdf || isImage ? 'h-screen-95' : 'h-screen-10' + ' w-full'">
    <VPdf v-if="isPdf" :src="src" smoothJump textLayer />

    <div v-else-if="isImage" class="flex h-full items-center justify-center">
      <img
        :src="src.url"
        alt="Image preview"
        class="max-h-full max-w-full object-contain"
      />
    </div>

    <div v-else class="mt-4 text-center text-gray-600">
      This file cannot be viewed here. Download to access.
    </div>

    <div :class="isPdf || isImage ? '' : 'flex justify-center'">
      <TButton
        icon="tabler:x"
        variant="ghost"
        color="gray"
        :padded="false"
        :ui="{ rounded: 'rounded-full' }"
        @click="emit('close')"
      />

      <TButton
        icon="tabler:download"
        label="Download"
        variant="ghost"
        color="gray"
        :padded="false"
        :ui="{ rounded: 'rounded-full' }"
        @click="downloadFile"
      />
    </div>
  </div>
</template>
