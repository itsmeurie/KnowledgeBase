<script setup lang="ts">
import { useViolatorModal } from '@/composables/useViolatorModal'

const ViolatorsTable = defineAsyncComponent(() => import('@/pages/violators/components/ViolatorsTable.vue'))
const ViolatorsModal = defineAsyncComponent(() => import('@/pages/violators/components/ViolatorsModal.vue'))

const { $api } = useNuxtApp()
const violators = ref([])
const router = useRouter();
const { openModal } = useViolatorModal()

const navigateToViolatorsBin = () => {
    router.push({ name: 'violators-bin' });
};

function fetchViolatorList() {
    $api.get('violators')
        .then((response) => {
            violators.value = response.data
        })
}

onMounted(() => {
    fetchViolatorList()
})
</script>

<template>
    <div class="max-w-screen-xl mx-auto w-full py-5">
        <header class="flex justify-between items-center py-2 px-8">
            <span>
                <h1 class="font-bold">Violators</h1>
            </span>

            <div class="flex space-x-2">
                <TButton icon="i-heroicons-pencil-square" size="sm" color="primary" variant="outline"
                    label="Add New Violator" :trailing="false" @click="openModal" />

                <TButton icon="i-heroicons-trash" size="sm" color="primary" variant="outline" label="Violators Bin"
                    :trailing="false" @click="navigateToViolatorsBin" />
            </div>
        </header>

        <ViolatorsTable />

        <ViolatorsModal @create="fetchViolatorList" />
    </div>
</template>