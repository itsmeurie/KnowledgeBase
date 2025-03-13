<script setup lang="ts">
const ViolatorsTrashTable = defineAsyncComponent(() => import('@/pages/violators/components/Trash/ViolatorsTrashTable.vue'))
</script>

<template>
    <div class="max-w-screen-xl mx-auto w-full py-5">
        <header class="flex justify-between items-center py-2 px-8">
            <span>
                <h1 class="font-bold">Violators Bin</h1>
            </span>

            <div class="flex space-x-2">
                <TButton color="gray" variant="outline" icon="i-heroicons-arrow-left"
                    :to="{ name: 'violators-index' }">
                    Back to List
                </TButton>
            </div>
        </header>

        <ViolatorsTrashTable />
    </div>
</template>