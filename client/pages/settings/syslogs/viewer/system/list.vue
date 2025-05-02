<script setup lang="ts">
import type { LogFileItem } from "~/types/models";

const props = defineProps<{
  download: {
    active: boolean;
    loaded: number;
    total: number;
  };
  selected: Array<LogFileItem>;
}>();
const emit = defineEmits(["view", "download", "delete", "update:selected"]);

const { formatSize } = useUtils();
const { $api } = useNuxtApp();

const files = defineModel<Array<LogFileItem>>();
const selected = defineModel<Array<LogFileItem>>("selected", {
  required: true,
});
const loading = defineModel<boolean>("loading");
const downloading = ref<LogFileItem>();

const loadFileList = () => {
  loading.value = true;
  $api
    .get("log/files")
    .then((response) => {
      files.value = response.data;
    })
    .finally(() => {
      loading.value = false;
    });
};

const columns = ref([
  {
    key: "name",
    label: "Name",
    class: "",
    rowClass: "",
  },
  {
    key: "modified",
    label: "Modified",
    class: "w-48",
    rowClass: "",
  },
  {
    key: "size",
    label: "Size",
    class: "w-28",
    rowClass: "text-right",
  },
  {
    key: "actions",
    label: "",
    class: "w-28",
    rowClass: "",
  },
]);

const selectFile = (file: LogFileItem) => {
  if (isSelected(file)) {
    selected.value = selected.value?.filter((f) => f.name !== file.name) ?? [];
  } else {
    selected.value = [...(selected.value ?? []), file];
  }
};

const isSelected = (file: LogFileItem) => {
  return !!selected.value?.find((f) => f.name === file.name);
};

const dl = (file: LogFileItem) => {
  emit("download", [file]);
};

onMounted(() => {
  loadFileList();
});
</script>

<template>
  <div class="">
    <div class="flex items-center gap-2 px-3 py-1">
      <div class="flex flex-auto items-center gap-2 py-2">
        <TButton
          icon="tabler:download"
          label="Download Selected"
          variant="outline"
          color="primary"
          size="xs"
          :disabled="selected?.length <= 0"
          @click="emit('download', selected)"
        />
        <TButton
          icon="tabler:download"
          label="Delete Selected"
          variant="outline"
          color="red"
          size="xs"
          :disabled="selected?.length <= 0"
          @click="emit('delete', selected)"
        />
      </div>
      <TButton
        icon="tabler:refresh"
        variant="ghost"
        color="gray"
        size="sm"
        @click="loadFileList"
      />
    </div>

    <TTable
      :columns
      :rows="files"
      :ui="{
        thead:
          '[&>tr]:divide-x [&>tr]:divide-gray-300 [&>tr]:dark:divide-gray-600',
        tr: {
          base: 'hover:bg-gray-100 dark:hover:bg-gray-700/50',
        },
        th: {
          padding: 'py-2',
        },
        td: {
          padding: 'py-2',
        },
      }"
    >
      <template #name-data="{ row }">
        <div class="flex items-center gap-1.5">
          <TCheckbox
            :modelValue="isSelected(row)"
            @update:modelValue="selectFile(row)"
          />
          <TIcon name="tabler:file-text-filled" class="h-5 w-5" />
          <div>{{ row.name }}</div>
        </div>
      </template>
      <template #size-data="{ row }">
        {{ formatSize(row.size) }}
      </template>

      <template #actions-data="{ row }">
        <div class="flex items-center gap-1">
          <TButton
            icon="tabler:eye"
            variant="ghost"
            color="gray"
            size="xs"
            :disabled="download.active"
            @click="emit('view', row)"
          />
          <TButton
            icon="tabler:download"
            variant="ghost"
            color="gray"
            size="xs"
            :loading="download.active && isSelected(row)"
            :disabled="download.active"
            @click="dl(row)"
          />
          <TButton
            icon="tabler:trash"
            variant="ghost"
            color="red"
            size="xs"
            :disabled="download.active"
            @click="emit('delete', [row])"
          />
        </div>
      </template>
    </TTable>
  </div>
</template>
