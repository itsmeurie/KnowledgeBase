<script setup lang="ts">
import type { Office } from "~/types";
import { useRouter } from "vue-router";
import { watchDebounced } from "@vueuse/core";

const { $api } = useNuxtApp();
const router = useRouter();

const CreateOffice = defineAsyncComponent(
  () => import("./components/create-office.vue"),
);
// const Delete = defineAsyncComponent(
//   () => import("./components/delete.vue"),
// );

const offices = ref<Office[]>([]);
const search_term = ref("");
const is_creating = ref(false);

function fetchOfficeList(code: string) {
  $api.get("/offices", { params: { code } }).then((response) => {
    offices.value = response.data;
  });
}

function toggleCreate(state: boolean) {
  is_creating.value = state;
}

function goToSystemSection(code: string) {
  router.push({
    name: "system-sections",
    params: { code: code.toLowerCase() },
  });
}

watchDebounced(
  search_term,
  (value) => {
    fetchOfficeList(value);
  },
  { debounce: 375, maxWait: 1000 },
);

onMounted(() => {
  fetchOfficeList("");
});

const columns = ref([
  {
    key: "code",
    label: "CODE",
  },
  {
    key: "name",
    label: "Name",
  },
  // {
  //   key: "actions",
  //   label: "Actions",
  // },
]);

const { pagination, params, loading, search } = useSearcher<{ search: string }>(
  {
    api: "/offices",
    limit: 9,
    appendToUrl: true,
    onSearch: (response) => {
      offices.value = response.data.data as Array<Office>;
    },
  },
);

type ModalType = "Editor" | "Delete";
const modal = ref<{
  open: boolean;
  data: Office | null;
  type: ModalType;
}>({
  open: false,
  data: null,
  type: "Editor",
});

const openModal = (data: Office | null = null, type: ModalType = "Editor") => {
  modal.value = { open: true, data, type };
};

const onDelete = (data: Office) => {
  offices.value = offices.value.filter((p) => p.id !== data.id);
  modal.value.open = false;
};
</script>

<template>
  <TContainer class="block w-full">
    <TCard
      class="relative h-full"
      :ui="{
        divide: 'divide-y divide-gray-400/25',
        header: {
          base: 'sticky top-[calc(5rem_-_7px)] z-20 p-0 rounded-t-md bg-gray-50 dark:bg-gray-800',
        },
        footer: {
          base: 'sticky bottom-0 bg-gray-50 dark:bg-gray-800 rounded-b-md',
        },
      }"
    >
      <template #header>
        <div class="flex flex-auto items-center justify-between px-3 py-3.5">
          <div class="flex items-center gap-4">
            <TInput
              v-model="search_term"
              type="text"
              placeholder="Search for offices"
            />
          </div>
          <TButton icon="tabler:plus" @click="toggleCreate(true)">
            Add Office
          </TButton>
        </div>
      </template>

      <TTable
        :columns="columns"
        :rows="offices"
        :loading="loading"
        :ui="{
          base: 'border-none',
          th: { base: '!border-none bg-gray-50 uppercase' },
          td: { base: 'w-fit' },
        }"
      >
        <template #actions-data="{ row }">
          <div class="flex items-center space-x-2">
            <TButton
              icon="tabler:trash"
              color="gray"
              size="md"
              variant="ghost"
              @click="openModal(row, 'Delete')"
              :ui="{
                color: {
                  gray: {
                    ghost:
                      'text-coral-500 hover:text-coral-500 dark:text-coral-400 hover:bg-coral-100 dark:hover:bg-coral-400/80 rounded-full',
                  },
                },
              }"
            />
          </div>
        </template>
      </TTable>

      <TInnerLoading :active="loading" text="Fetching permissions..." />

      <template #footer>
        <div class="flex justify-end bg-gray-50 dark:bg-gray-800">
          <TPagination
            v-model="pagination.page"
            :total="pagination.total"
            :pageCount="pagination.limit"
          />
        </div>
      </template>
    </TCard>

    <!-- Create Modal -->
    <CreateOffice :show="is_creating" @update:show="toggleCreate" />

    <!-- Delete Modal -->
    <TModal
      v-model="modal.open"
      :prevent-close="loading"
      :ui="{ width: 'w-screen-95 max-w-sm sm:max-w-sm' }"
    >
      <Delete
        v-if="modal.type === 'Delete'"
        :modelValue="modal.data!"
        @delete="onDelete"
        @close="modal.open = false"
      />
    </TModal>
  </TContainer>
</template>
