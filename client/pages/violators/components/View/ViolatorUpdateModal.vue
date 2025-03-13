<script setup lang="ts">
import { ref, watch } from 'vue';
import { useViolatorModal } from '@/composables/useViolatorModal';

const { $api } = useNuxtApp();
const route = useRoute();

const props = defineProps({
    violator: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['update']);

const { isOpenUpdateViolator, closeUpdateModal } = useViolatorModal();

const localViolator = ref({ ...props.violator });
const loading = ref(false);

watch(() => props.violator, (newValue) => {
    localViolator.value = { ...newValue };
}, { deep: true });

const genders = [
    { id: 1, name: 'Male' },
    { id: 2, name: 'Female' },
    { id: 3, name: 'LGBTQQIP2SAA' },
    { id: 4, name: 'Attack Helicopter' },
];

async function updateViolator() {
    if (loading.value) return;
    loading.value = true;
    try {
        await $api.put(`violators/${route.params.id}`, localViolator.value);
        emit('update');
        closeUpdateModal();
    } catch (error) {
        console.error("Error updating violator:", error);
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <TModal :model-value="isOpenUpdateViolator" @update:model-value="closeUpdateModal" prevent-close>
        <TCard
            :ui="{ base: 'h-full flex flex-col', ring: '', divide: 'divide-y divide-gray-100 dark:divide-gray-800' }">
            <div class="">
                <div class="flex items-center justify-between border-b pb-2">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Edit Violator</h3>
                    <TButton color="gray" variant="ghost" icon="i-heroicons-x-mark-20-solid" class="-my-1"
                        @click="closeUpdateModal" />
                </div>

                <div class="grid grid-cols-2 gap-x-4">
                    <div class="col-span py-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <TInput placeholder="Irven" v-model="localViolator.first_name" />
                    </div>
                    <div class="col-span py-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                        <TInput placeholder="Corda" v-model="localViolator.middle_name" />
                    </div>
                    <div class="col-span py-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <TInput placeholder="Langaoen" v-model="localViolator.last_name" />
                    </div>
                    <div class="col-span py-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <TSelect placeholder="Select gender" value-attribute="id" option-attribute="name"
                            v-model=localViolator.gender_id :options="genders" :search-atttributes="['name']" />
                    </div>
                </div>

                <div class="flex w-full justify-start px-4">
                    <div class="py-2">
                        <TButton label="Submit" @click="updateViolator" :disabled="loading">
                            <span v-if="loading"
                                class="animate-spin border-4 border-white border-t-transparent rounded-full w-5 h-5 mr-2"></span>
                            {{ loading ? 'Updating...' : 'Submit' }}
                        </TButton>
                    </div>
                </div>
            </div>
        </TCard>
    </TModal>
</template>