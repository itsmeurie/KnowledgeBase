<script setup lang="ts">
import type { UploadedFile } from "~/types";

const props = defineProps<{ file: UploadedFile }>();

const { $api } = useNuxtApp();
const src = {
  url: props.file.prevUrl,
  withCredentials: true,
};

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
const isPdf = props.file.name.endsWith(".pdf");
const emit = defineEmits(["close", "download"]);
</script>

<template>
  <div :class="isPdf ? 'h-screen-95' : 'h-screen-10' + ' w-full'">
    <VPdf v-if="isPdf" :src="src" smoothhJump textLayer />
    <div class="text-center" v-else>
      "This file cannot be viewed here. Download to access."
    </div>

    <div :class="isPdf ? '' : 'flex justify-center'">
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
        variant="ghost"
        color="gray"
        :padded="false"
        :ui="{ rounded: 'rounded-full' }"
        @click="downloadFile"
      />
    </div>
  </div>
</template>
