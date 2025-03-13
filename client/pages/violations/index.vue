<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { ref, onMounted, watch } from 'vue';
const { $api } = useNuxtApp();
const router = useRouter();
const violations = ref([]);

type Violation = {
    id: number
    name: string
    penalty: string
    ordinance: string
    fine: number
    created_at: string
}
// Importing CreateViolation Component
const CreateViolation = defineAsyncComponent(() => import('@/pages/violations/components/create-violation.vue'));

async function getViolationsList() {
    const { data } = await search();
    violations.value = data.data;
}

onMounted(() => {
    getViolationsList();
});

const { search, pagination } = useSearcher({
    api: 'violations',
    limit: 10,
    method: 'get',
    onPageChange: getViolationsList,
});

// @ts-ignore
watch(() => pagination.page, async () => await search());

const columns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'name', label: 'Name', sortable: true },
    { key: 'penalty', label: 'Penalty', sortable: true },
    { key: 'ordinance', label: 'Ordinance', sortable: true },
    { key: 'fine', label: 'Fine', sortable: true },
    { key: 'actions', label: 'Actions' },
];

const selectedColumns = ref([...columns]);

const items = (row: Violation) => [
    [{
        label: 'View',
        icon: 'i-heroicons-view-columns-20-solid',
        click: () => router.push({ name: 'violations-view', params: { id: row.id } }),
    }]
];



</script>

<template>
    <div class="w-full max-w-screen-xl mx-auto my-10">
        <TCard>
            <template #header>
                <div class="grid grid-cols-3 items-center w-full px-10">
                    <div class="flex justify-start">
                        <NuxtLink :to="{ name: 'violations-archived' }">
                            <TButton icon="i-heroicons-archive-box" class="w-28 flex justify-center hover:bg-red-50"
                                size="sm" color="red" variant="outline" label="Archive" :trailing="false" />
                        </NuxtLink>
                    </div>
                    <div class="flex justify-center">
                        <h1 class="font-bold text-lg">Violations</h1>
                    </div>

                    <div class="flex justify-end gap-x-4">
                        <CreateViolation @created="getViolationsList" />
                        <TSelectMenu v-model="selectedColumns" :options="columns" multiple placeholder="Columns" />
                    </div>
                </div>
            </template>

            <div class="p-2">
                <TTable :rows="violations" :columns="selectedColumns" class="w-full">
                    <template #actions-data="{ row }">
                        <TDropdown :items="items(row)">
                            <TButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
                        </TDropdown>
                    </template>
                </TTable>
                <div class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700">
                    <TPagination v-model="pagination.page" :page-count="pagination.limit" :total="pagination.total" />
                </div>
            </div>
        </TCard>
    </div>
</template>
