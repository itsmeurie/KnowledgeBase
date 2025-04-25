<script setup lang="ts">
import type { Office } from "~/types";
import { useRouter } from "vue-router";

const { $api } = useNuxtApp();
const router = useRouter();

// Import Component
const CreateOffice = defineAsyncComponent(
  () => import("./components/create-office.vue"),
);

const offices = ref<Office[]>([]);
const search_term = ref("");

const is_creating = ref(false);
const is_updating = ref(false);

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
</script>
<template>
  <div class="flex h-full flex-col items-center p-8">
    <div class="flex w-full max-w-7xl flex-col gap-4">
      <div class="flex flex-col gap-2">
        <div class="flex items-center justify-between">
          <h5 class="text-4xl font-bold">Office Documentations</h5>
          <div class="flex justify-between gap-4">
            <TTooltip @click="toggleCreate(true)" text="Add New Office">
              <TButton icon="tabler:plus" size="sm" />
            </TTooltip>
          </div>
        </div>
        <p class="text-l max-w-xl">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nemo earum,
          quibusdam saepe obcaecati repellat repudiandae officiis, ea
          exercitationem beatae nihil praesentium, magnam dolores dolorum
          veritatis explicabo. Aperiam corporis sunt dolorum!
        </p>
      </div>
      <TInput
        v-model="search_term"
        type="text"
        placeholder="Search for offices"
      />
      <div class="grid grid-cols-1 justify-center gap-4 lg:grid-cols-4">
        <div
          v-for="office in offices"
          :key="office.id"
          class="hover:text-primary text-md flex cursor-pointer items-center gap-4 rounded-lg p-4 py-8 font-bold hover:bg-gray-100"
          @click="goToSystemSection(office.code)"
        >
          <img
            class="h-20 w-20"
            src="~/assets/image/default_seal.png"
            alt="Office Logo"
          />
          <span>{{ office.name }}</span>
        </div>
      </div>
    </div>
    <CreateOffice
      :show="is_creating"
      @update:show="toggleCreate"
    ></CreateOffice>
  </div>
</template>
