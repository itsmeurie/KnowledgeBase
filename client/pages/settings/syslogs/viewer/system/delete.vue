<script setup lang="ts">
import type { LogFileItem } from "~/types/models";

const props = defineProps<{
  files: Array<LogFileItem>;
}>();
const emit = defineEmits(["close", "deleted"]);

const { $api } = useNuxtApp();
const { formatSize } = useUtils();

const loading = ref(false);

const deleteLogs = () => {
  loading.value = true;

  $api
    .delete("/log/system", {
      data: {
        names: props.files.map((f) => f.name),
      },
    })
    .then((response) => {
      emit("deleted", response.data);
    })
    .finally(() => {
      loading.value = false;
    });
};
</script>

<template>
  <TCard
    :ui="{
      ring: '',
      divide: 'divide-y divide-gray-400/25',
      base: 'overflow-hidden',
      header: {
        base: 'flex relative items-center',
        padding: 'px-4 py-3 sm:py-2',
        background: 'dark:bg-gray-900 bg-gray-100',
      },
      footer: {
        base: 'flex items-center justify-end gap-2',
        padding: 'px-4 py-3 sm:py-2',
      },
    }"
  >
    <template #header>
      <div
        class="flex flex-auto items-center gap-2 text-sunset-500 dark:text-sunset-400"
      >
        <TIcon name="tabler:alert-triangle" class="h-6 w-6" />
        <h3 class="text-base font-semibold leading-6">
          Are you sure you want to delete these logs?
        </h3>
      </div>
      <TButton
        color="gray"
        variant="ghost"
        icon="i-heroicons-x-mark-20-solid"
        size="xs"
        :disabled="loading"
        @click="emit('close')"
      />
    </template>
    <div class="flex flex-col gap-2 px-12 py-2">
      You are about to delete the following log files:
      <div
        class="flex flex-col divide-y divide-gray-200 rounded-lg border border-gray-200 bg-gray-100 px-3 py-1 dark:border-gray-600 dark:bg-gray-700"
      >
        <div v-for="file in files" :key="file.name" class="py-1">
          {{ file.name }}
          <span class="px-3 text-xs italic text-gray-400">
            ({{ formatSize(file.size) }})
          </span>
        </div>
      </div>
      This action is irreversible. Continue?
    </div>

    <TInnerLoading :active="loading" text="Deleting log file(s)..." />

    <template #footer>
      <TButton
        label="Delete"
        color="sunset"
        :disabled="loading"
        :loading
        @click="deleteLogs"
      />
      <TButton
        label="Cancel"
        variant="ghost"
        color="gray"
        :disabled="loading"
        @click="emit('close')"
      />
    </template>
  </TCard>
</template>
