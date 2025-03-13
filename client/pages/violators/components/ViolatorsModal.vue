<script setup lang="ts">
import { z } from 'zod'
import { useViolatorModal } from '@/composables/useViolatorModal'

const emit = defineEmits(['create'])

const { isOpenCreateViolator, closeModal } = useViolatorModal()
const loading = ref(false)

const { $api } = useNuxtApp()

const form = ref({
    first_name: '',
    middle_name: '',
    last_name: '',
    gender_id: ''
})

const violatorSchema = z.object({
    first_name: z.string(),
    middle_name: z.string(),
    last_name: z.string(),
    gender_id: z.number(),
    status: z.string()
})

const genders = [
    { id: 1, name: 'Male' },
    { id: 2, name: 'Female' },
    { id: 3, name: 'LGBTQQIP2SAA' },
    { id: 4, name: 'Attack Helicopter' },
]

async function createViolator() {
    if (loading.value) return;
    loading.value = true;

    try {
        await $api.post('violators', form.value);
        console.log('Violator created successfully');
        emit('create');
        clearForm();
        closeModal();
    } catch (error) {
        console.error('Error creating violator:', error);
    } finally {
        loading.value = false;
    }
}

function clearForm() {
    form.value = {
        first_name: '',
        middle_name: '',
        last_name: '',
        gender_id: ''
    };
}

type ViolatorSchema = z.output<typeof violatorSchema>
</script>

<template>
    <TModal :modelValue="isOpenCreateViolator" @update:modelValue="closeModal" prevent-close>
        <TCard
            :ui="{ base: 'h-full flex flex-col', ring: '', divide: 'divide-y divide-gray-100 dark:divide-gray-800' }">
            <div class="mt-4">
                <div class="flex items-center justify-between border-b pb-2">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
                        Add New Violator
                    </h3>
                    <TButton color="gray" variant="ghost" icon="i-heroicons-x-mark-20-solid" class="-my-1"
                        @click="closeModal" />
                </div>
            </div>

            <TForm :schema="violatorSchema" :state="form" class="space-y-4z">
                <div class="flex-row">
                    <div class="flex justify-between gap-x-4 mb-6 mt-4">
                        <TFormGroup class="w-full" label="First Name" name="first_name">
                            <TInput v-model="form.first_name" class="w-full" placeholder="Irven" autocomplete="off" />
                        </TFormGroup>
                        <TFormGroup class="w-full" label="Middle Name">
                            <TInput v-model="form.middle_name" class="w-full" placeholder="Corda" autocomplete="off" />
                        </TFormGroup>
                        <TFormGroup class="w-full" label="Last Name">
                            <TInput v-model="form.last_name" class="w-full" placeholder="Langaoen" autocomplete="off" />
                        </TFormGroup>
                    </div>

                    <TSelect placeholder="Select gender" value-attribute="id" option-attribute="name"
                        v-model=form.gender_id :options="genders" :search-atttributes="['name']" />
                </div>

                <TButton type="submit" @click="createViolator" class="mt-4">
                    <span v-if="loading"
                        class="animate-spin border-4 border-white border-t-transparent rounded-full w-5 h-5 mr-2"></span>
                    {{ loading ? 'Submitting...' : 'Submit' }}
                </TButton>
            </TForm>
        </TCard>
    </TModal>
</template>