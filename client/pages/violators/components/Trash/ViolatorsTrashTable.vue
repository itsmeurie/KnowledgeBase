<script setup lang="ts">
const { $api } = useNuxtApp()

const ConfirmationDialog = defineAsyncComponent(() => import('@/pages/violators/components/Assets/ConfirmationDialog.vue'));

const violators = ref([])
const loading = ref(false);
const confirmationDialog = ref();

const columns = [
    { key: 'id', label: 'ID' },
    { key: 'first_name', label: 'First Name' },
    { key: 'middle_name', label: 'Middle Name' },
    { key: 'last_name', label: 'Last Name' },
    { key: 'gender', label: 'Gender' },
    { key: 'actions', label: 'Actions' }
];

const actions = (row: Violator) => [
    [{
        label: 'Restore',
        icon: 'i-heroicons-arrow-path-20-solid',
        click: () => restoreTrashedViolator(row)
    }]
];

type Violator = {
    id: number;
    first_name: string;
    middle_name: string;
    last_name: string;
    gender: string;
    full_name: string;
};

function fetchViolatorTrashedList() {
    loading.value = true;
    $api.get('violators/trashed')
        .then((response) => {
            violators.value = response.data
        })
        .catch((error) => {
            console.error('Error fetching violators:', error);
        })
        .finally(() => {
            loading.value = false;
        });
}

async function restoreTrashedViolator(row: Violator) {
    loading.value = true;

    const confirmed = await confirmationDialog.value.openDialog(
        'Restore Violator',
        'Are you sure you want to restore this violator?'
    );

    if (!confirmed) return;

    $api.patch(`violators/${row.id}`)
        .then(() => {
            fetchViolatorTrashedList();
        })
        .finally(() => {
            loading.value = false;
        });
}

onMounted(() => {
    fetchViolatorTrashedList()
})
</script>

<template>
    <div>
        <TTable :loading-state="{ icon: 'i-heroicons-arrow-path-20-solid', label: 'Loading...' }" :loading="loading"
            :rows="violators" :columns="columns">
            <template #actions-data="{ row }">
                <TDropdown :items="actions(row)">
                    <TButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
                </TDropdown>
            </template>
        </TTable>

        <ConfirmationDialog ref="confirmationDialog" />
    </div>
</template>