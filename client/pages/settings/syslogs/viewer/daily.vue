<script setup lang="ts">
import type { LogData } from "~/types/models";
import Badger from "~/pages/settings/roles/roleBadge.vue";
import LogInfo from "./logInfo/index.vue";

const props = defineProps<{
  data: Array<LogData>;
  levelMap: Record<number, string>;
  colors: Record<number, string>;
  loading?: boolean;
}>();
const pagination = defineModel<{
  limit: number;
  page: number;
  total: number;
}>("pagination", {
  required: true,
});
const { $dayjs } = useNuxtApp();

const columns = ref([
  {
    key: "level",
    label: "Level",
    class: "w-24",
    rowClass: "!px-3 !py-3",
  },
  {
    key: "timestamp",
    label: "Time",
    class: "w-24",
    rowClass: "!px-3 !py-3",
  },
  {
    key: "module",
    label: "Module",
    class: "w-48",
    rowClass: "!px-3 !py-3",
  },
  {
    key: "actor",
    label: "By",
    class: "w-48",
    rowClass: "!px-3 !py-3",
  },
  {
    key: "action",
    label: "Header",
    class: "",
    rowClass: "!px-3 !py-3",
  },
  {
    key: "actions",
    label: "Actions",
    class: "w-20",
    rowClass: "!px-3 !py-3",
  },
]);

const modal = ref<{
  show: boolean;
  data?: LogData;
}>({
  show: false,
  data: undefined,
});

const openModal = (data: LogData) => {
  modal.value.data = data;
  modal.value.show = true;
};
</script>

<template>
  <TCard
    :ui="{
      body: {
        padding: '',
        base: 'overflow-auto',
      },
    }"
  >
    <template v-if="false" #header>
      <div class="flex items-center gap-2">
        <TInput placeholder="Search" />
      </div>
    </template>
    <TTable
      :columns
      :rows="data"
      :loading
      :ui="{
        wrapper: '',
        base: 'border-0 table-auto',
        thead: 'sticky top-0 z-10 capitalize',
        tr: {
          base: 'divide-x divide-gray-200 dark:divide-gray-600',
        },
      }"
    >
      <template #level-data="{ row }">
        <Badger :color="colors[row.level]">
          {{ levelMap[row.level] }}
        </Badger>
      </template>

      <template #timestamp-data="{ row }">
        {{ $dayjs(row.timestamp).format("hh:mm:ss A") }}
      </template>

      <template #action-data="{ row }">
        <div class="line-clamp-2 whitespace-break-spaces">
          {{ row.action }}
        </div>
      </template>

      <template #actions-data="{ row }">
        <TButton
          variant="outline"
          icon="tabler:eye"
          :ui="{ base: 'w-full justify-center' }"
          @click="openModal(row)"
        />
      </template>
    </TTable>

    <TModal
      v-model="modal.show"
      :ui="{
        width: 'sm:max-w-3xl',
        margin: '',
      }"
    >
      <LogInfo
        :data="modal.data!"
        :levelMap
        :colors
        @close="modal.show = false"
        class="h-screen-95"
      />
    </TModal>

    <template #footer>
      <div class="flex items-center justify-end gap-2">
        <TPagination
          v-model="pagination.page"
          :total="pagination.total"
          :pageCount="pagination.limit"
        />
      </div>
    </template>
  </TCard>
</template>
