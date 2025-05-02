<script setup lang="ts">
import type { LogSummary } from "~/types/models";
import Badger from "~/pages/settings/roles/roleBadge.vue";

const props = defineProps<{
  data?: LogSummary;
  levels: Record<number, string>;
  monthly?: boolean;
  colors: Record<number, string>;
  loading?: boolean;
}>();

const { $dayjs } = useNuxtApp();

const columns = computed(() => {
  let cols = [
    {
      key: "date",
      label: "Date",
      class: "capitalize",
      rowClass: "!px-3 !py-3",
    },
  ];

  Object.keys(props.levels).forEach((l: string) => {
    cols.push({
      key: `${parseInt(l)}`,
      label: props.levels[parseInt(l)],
      class: "capitalize text-center",
      rowClass: "text-center !px-3 !py-3",
    });
  });

  cols.push({
    key: "total",
    label: "Total",
    class: "capitalize text-center",
    rowClass: "text-center bg-gray-100 dark:bg-gray-700 !px-3 !py-3",
  });

  return cols;
});

const rows = computed(() => {
  let r: any[] = [];
  Object.keys(props.data ?? {}).forEach((d: string) => {
    if (props.data) {
      r.push(
        Object.assign({}, props.data[d], {
          date: $dayjs(d).format(props.monthly ? "DD MMM YYYY" : "MMMM"),
        }),
      );
    }
  });
  return r;
});
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
      :rows
      :loading
      :ui="{ wrapper: '', base: 'border-0', thead: 'sticky top-0 z-10' }"
    >
      <template
        v-for="(c, index) in columns"
        v-slot:[`${index}-data`]="{ row }"
      >
        <Badger :color="row[`${index}`] > 0 ? colors[`${index}`] : '#666'">
          {{ row[`${index}`] }}
        </Badger>
      </template>
    </TTable>
  </TCard>
</template>
