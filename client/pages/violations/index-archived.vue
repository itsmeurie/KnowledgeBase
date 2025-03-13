<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import { ref } from 'vue';
const { $api } = useNuxtApp();
const router = useRouter();
const violations = ref([])


async function getViolationsList() {
    // use Search function from Searcher Composable.
    const { data } = await search();
    // assign the value to violations.
    violations.value = data.data
}

// Mount
onMounted(() => {
    getViolationsList();
})

// Searcher Component
const { search, pagination } = useSearcher({
    // List Backend Route
    api: 'violations/archived',
    // limit,
    limit: 10,
    method: 'get',
    // Callback Function to call on Page Change
    onPageChange: getViolationsList,
});

// Listen for value changes for pagination.page.
// @ts-ignore
watch(() => pagination.page, async () => await search());

// Sorting of columns to id
const sort = ref<{ column: string; direction: "asc" | "desc" }>({
    column: 'id',
    direction: 'asc'
});

// Columns
const columns = [{
    key: 'id',
    label: 'ID',
    sortable: true,
}, {
    key: 'name',
    label: 'Name',
    sortable: true
}, {
    key: 'penalty',
    label: 'Penalty',
    sortable: true
}, {
    key: 'ordinance',
    label: 'Ordinance',
    sortable: true
}, {
    key: 'fine',
    label: 'Fine',
    sortable: true
},
{
    key: 'deleted_at',
    label: 'Date Deleted',
}, {
    key: 'actions',
    label: 'Actions',
}];

// Violation Type
type Violation = {
    id: number
    name: string
    penalty: string
    ordinance: string
    fine: number
    created_at: string
    deleted_at: string
}

// Action Items
const items = (row: Violation) => [
    [{
        label: 'View',
        icon: 'i-heroicons-view-columns-20-solid',
        click: () => {
            // console.log('Pushing to Ticket View:', row.id)
            router.push({ name: 'violations-view-archived', params: { id: row.id } });
        }
    }]
]


// LIST
// function getViolationsList() {
//     $api.get('violations')
//         .then((response) => {
//             violations.value = response.data
//         })
// }



// Selected Columns(hide or show)
const selectedColumns = ref([...columns])

</script>

<template>
    <div class="w-full max-w-screen-xl mx-auto my-10">
        <TCard>
            <template #header>
                <div class="grid grid-cols-3 items-center w-full px-10">
                    <div class="flex justify-start">
                        <NuxtLink :to="{ name: 'violations-index' }">
                            <TButton icon="i-heroicons-home" class="w-28 flex justify-center" size="sm" color="primary"
                                variant="outline" label="Home" :trailing="false" />
                        </NuxtLink>

                    </div>
                    <div class="flex justify-center">
                        <h1 class="font-bold text-lg">Archived Violations</h1>
                    </div>

                    <div class="flex justify-end gap-x-4">
                        <CreateViolation @created="getViolationsList" />
                        <TSelectMenu v-model="selectedColumns" :options="columns" multiple placeholder="Columns" />
                    </div>
                </div>

            </template>

            <div class="p-2">
                <TTable :sort="sort" :rows="violations" :columns="selectedColumns" class="w-full">
                    <template #actions-data="{ row }">
                        <TDropdown :items="items(row)">
                            <TButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
                        </TDropdown>
                    </template>
                </TTable>
                <div class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700">
                    <TPagination v-model="pagination.page" :page-count="pagination.limit" :total="pagination.total">
                    </TPagination>
                </div>
            </div>


            <template #footer>

            </template>
        </TCard>
    </div>

</template>
