<script setup lang="ts">
const { $api } = useNuxtApp();
const route = useRoute();
const router = useRouter();
const { openUpdateModal } = useViolatorModal();

const ViolatorDetails = defineAsyncComponent(() => import('@/pages/violators/components/View/ViolatorDetails.vue'));
const ConfirmationDialog = defineAsyncComponent(() => import('@/pages/violators/components/Assets/ConfirmationDialog.vue'));
const ViolatorUpdateModal = defineAsyncComponent(() => import('@/pages/violators/components/View/ViolatorUpdateModal.vue'));

const deleting = ref(false);
const confirmationDialog = ref();
const violator = ref();
const violatorDetailsKey = ref(0);

async function deleteViolator() {
    if (deleting.value) return;

    const confirmed = await confirmationDialog.value.openDialog(
        'Delete Violator',
        'Are you sure you want to delete this violator?'
    );

    if (!confirmed) return;

    deleting.value = true;
    try {
        await $api.delete(`violators/${route.params.id}`);
        router.push('/violators');
    } catch (error) {
        console.error('Error deleting violator:', error);
    } finally {
        deleting.value = false;
    }
}

async function fetchViolator() {
    const response = await $api.get(`violators/${route.params.id}`);
    violator.value = response.data;
    violatorDetailsKey.value += 1;
}

onMounted(() => {
    fetchViolator();
});
</script>

<template>
    <div class="max-w-screen-sm mx-auto w-full py-6">
        <TCard class="shadow-lg border border-gray-200">
            <template #header>
                <h2 class="text-lg font-semibold text-gray-800">Violator Profile</h2>
            </template>

            <Suspense>
                <template #default>
                    <ViolatorDetails :key="violatorDetailsKey" />
                </template>
                <template #fallback>
                    <div class="flex justify-center items-center">
                        <div
                            class="animate-spin border-4 border-primary border-t-transparent rounded-full w-5 h-5 mr-2">
                        </div>
                    </div>
                </template>
            </Suspense>

            <template #footer>
                <div class="flex justify-end p-4">
                    <TButton color="gray" variant="outline" icon="i-heroicons-arrow-left"
                        :to="{ name: 'violators-index' }">
                        Back to List
                    </TButton>
                    <TButton color="primary" class="ml-2" variant="outline" icon="i-heroicons-pencil-square-20-solid"
                        @click="openUpdateModal">
                        Update
                    </TButton>
                    <TButton color="red" class="ml-2 flex items-center justify-center" icon="i-heroicons-trash"
                        :disabled="deleting" @click="deleteViolator">
                        <span v-if="deleting"
                            class="animate-spin border-4 border-white border-t-transparent rounded-full w-5 h-5 mr-2"></span>
                        {{ deleting ? 'Deleting...' : 'Delete' }}
                    </TButton>
                </div>
            </template>
        </TCard>

        <ViolatorUpdateModal v-if="violator" :violator="violator" @update="fetchViolator" />
        <ConfirmationDialog ref="confirmationDialog" />
    </div>
</template>