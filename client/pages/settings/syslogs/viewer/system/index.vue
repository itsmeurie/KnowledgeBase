<script setup lang="ts">
import { _selected } from "#tailwind-config/theme/aria";
import type { LogFileItem } from "~/types/models/logs";
import FileList from "./list.vue";
import Preview from "./preview.vue";
import DeleteLogs from "./delete.vue";
import type { AxiosProgressEvent } from "axios";

const emit = defineEmits(["close"]);
const { $api } = useNuxtApp();

const loading = ref(false);
const states = ref({
  download: {
    active: false,
    loaded: 0,
    total: 1,
  },
});
const preview = ref<LogFileItem>();
const files = ref<Array<LogFileItem>>([]);
const selected = ref<Array<LogFileItem>>([]);
const toDelete = ref<{
  show: boolean;
  files: Array<LogFileItem>;
}>({
  show: false,
  files: [],
});

const downloadState = ref({});

const viewLog = (e: LogFileItem) => {
  preview.value = e;
};

const downloadLogs = (e: Array<LogFileItem>) => {
  loading.value = true;
  states.value.download.active = true;
  const names = e.map((f) => f.name);
  let tmp: Array<LogFileItem> = [];
  if (selected.value.length > 0) {
    tmp = [...selected.value];
    selected.value = e;
  }
  $api
    .get(`log/download`, {
      params: { names },
      responseType: "blob",
      onDownloadProgress: (progressEvent: AxiosProgressEvent) => {
        if (progressEvent.lengthComputable) {
          states.value.download.total = progressEvent.total ?? 0;
          states.value.download.loaded = progressEvent.loaded ?? 0;
          console.log(
            `Downloaded ${progressEvent.loaded} of ${progressEvent.total} bytes`,
          );
        }
      },
    })
    .then((response) => {
      // create file link in browser's memory
      const href = window.URL.createObjectURL(response.data);
      const fname = `system.${names.length > 1 ? "zip" : "log"}`;

      // create "a" HTML element with href to file & click
      const link = document.createElement("a");
      link.href = href;
      link.setAttribute("download", fname); //or any other extension
      document.body.appendChild(link);
      link.click();

      // clean up "a" element & remove ObjectURL
      document.body.removeChild(link);
      URL.revokeObjectURL(href);
    })
    .finally(() => {
      loading.value = false;
      states.value.download.total = 1;
      states.value.download.loaded = 0;
      states.value.download.active = false;
      if (selected.value.length > 0) {
        selected.value = [...tmp];
        tmp = [];
      }
    });
};

const deleteLogs = (e: Array<LogFileItem>) => {
  toDelete.value.files = e;
  toDelete.value.show = true;
};

const onDelete = (e: Array<LogFileItem>) => {
  files.value = e;
  preview.value = undefined;
  selected.value = [];
  toDelete.value.show = false;
};
</script>

<template>
  <TCard
    :ui="{
      base: 'h-screen-95',
      body: {
        base: 'p-0',
        padding: '',
      },
      footer: {
        base: 'flex items-center gap-2 px-3 py-1 min-h-8 text-xs italic text-gray-500/75 font-semibold',
        padding: '',
      },
    }"
  >
    <template #header>
      <TTypography variant="h3">System Logs</TTypography>
      <TButton
        icon="tabler:x"
        variant="ghost"
        color="gray"
        size="sm"
        @click="emit('close')"
      />
    </template>
    <FileList
      v-if="!preview"
      v-model="files"
      v-model:selected="selected"
      v-model:loading="loading"
      v-bind="states"
      @download="downloadLogs"
      @delete="deleteLogs"
      @view="viewLog"
    />
    <Preview
      v-else
      :file="preview!"
      @download="downloadLogs"
      @delete="deleteLogs"
      @close="preview = undefined"
    />

    <TModal v-model="toDelete.show">
      <DeleteLogs
        :files="toDelete.files"
        @close="toDelete.show = false"
        @deleted="onDelete"
      />
    </TModal>
  </TCard>
</template>
