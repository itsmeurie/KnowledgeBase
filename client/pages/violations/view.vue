<script setup lang="ts">
import { useRouter } from 'vue-router';
const { $api } = useNuxtApp();

const route = useRoute();
const router = useRouter();
const violation = ref();
const toast = useToast()

// Show violation function
function showViolation() {
    $api.get(`violations/${route.params.id}`)
        .then((response) => {
            violation.value = response.data
        })
}
// Mount violation to showViolation
onMounted(() => {
    showViolation()
})

// Delete violation function
function deleteViolation() {
    $api.delete(`violations/${route.params.id}`)
        .then(() => {
            toast.add({
                title: 'Success',
                description: 'The ticket was deleted successfully.',
            })
            router.push({ name: 'violations-index' });
        })
}

// Restore violation function
function restoreViolation() {
    $api.patch(`violations/${route.params.id}`)
        .then(() => {
            toast.add({
                title: 'Success',
                description: 'The ticket was restored successfully.',
            })
            router.push({ name: 'violations-index' });
        })
}

const UpdateModal = defineAsyncComponent(() =>
    import('@/pages/violations/components/update-violation.vue')
)


</script>

<template>
    <div class="max-w-screen-lg mx-auto p-6 w-full">
        <TCard class="border py-3 px-2">
            <!-- Header -->
            <template #header>
                <div class="flex items-center justify-between border-b pb-4 w-full">
                    <div class="flex items-center gap-x-4">
                        <TBadge color="primary" class="text-sm">
                            ID: {{ violation?.id }}
                        </TBadge>
                        <h3 class="text-xl font-semibold">
                            Violation Record
                        </h3>
                    </div>

                    <div class="flex items-center gap-x-4">
                        <UpdateModal v-if="!violation?.deleted_at" />
                        <TButton v-if="!violation?.deleted_at" label="Delete Violation"
                            icon="i-heroicons-trash-20-solid" color="rose" variant="outline" @click="deleteViolation()"
                            class="hover:bg-rose-50 w-40 justify-center" />

                        <TButton v-else label="Restore Violation" icon="i-heroicons-arrow-uturn-left-solid"
                            color="orange" variant="outline" @click="restoreViolation()"
                            class="hover:bg-orange-50 w-40 justify-center" />

                    </div>
                </div>
            </template>

            <!-- Main Content -->
            <div class="grid grid-cols-3 gap-8 py-4">
                <!-- Left Column -->
                <div class="w-full h-full flex flex-col gap-y-4">
                    <div class="grid grid-rows-2 min-h-[60px]">
                        <span class="text-sm font-bold block">Name</span>
                        <span class="text-base">{{ violation?.name }}</span>
                    </div>
                    <div class="min-h-[60px]">
                        <span class="text-sm font-bold block">Penalty</span>
                        <span class="text-base ">{{ violation?.penalty }}</span>
                    </div>
                </div>

                <!-- Middle Column -->
                <div class="w-full h-full flex flex-col gap-y-4">
                    <div class="min-h-[60px]">
                        <span class="text-sm font-bold  block">Ordinance</span>
                        <span class="text-base">{{ violation?.ordinance }}</span>
                    </div>
                    <div class="min-h-[60px]">
                        <span class="text-sm font-bold block">Fine Amount</span>
                        <span class="text-base font-semibold text-primary">₱{{ violation?.fine }}</span>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="w-full h-full flex flex-col gap-y-4">
                    <div class="min-h-[60px]">
                        <span class="text-sm font-bold block">Created At</span>
                        <span class="text-base ">
                            {{ new Date(violation?.created_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }) }}
                        </span>
                    </div>
                    <div class="min-h-[60px]">
                        <span class="text-sm font-bold block">Status</span>
                        <TBadge class="text-sm" color="green">
                            Active
                        </TBadge>
                    </div>
                </div>
            </div>


            <!-- Footer -->
            <template #footer>
                <div class="flex items-center justify-between border-t pt-4">
                    <span class="text-sm ">Last updated: {{ new
                        Date(violation?.created_at).toLocaleDateString() }}</span>
                    <div class="flex gap-2">
                        <TButton color="gray" variant="outline" icon="i-heroicons-arrow-left"
                            :to="{ name: 'violations-index' }" class="hover:bg-gray-100">
                            Back to List
                        </TButton>
                    </div>
                </div>
            </template>
        </TCard>
    </div>
</template>