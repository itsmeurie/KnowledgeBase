<script setup lang="ts">
import { z } from 'zod'
import type { FormError, FormSubmitEvent } from '#ui/types'

const { $api } = useNuxtApp();

const props = defineProps({
    show: Boolean,
})



const emit = defineEmits(['update:show'])

const validate = (state: any): FormError[] => {
  const errors = []
  if (!state.name) errors.push({ path: 'name', message: 'Required' })
  if (!state.code) errors.push({ path: 'code', message: 'Required' })
  return errors
}

//hahahaha

const schema = z.object({
  name: z.string(),
  code: z.string().min(3, 'Must be at least 3 characters')
})

type Schema = z.output<typeof schema>

const state = reactive({
  name: undefined,
  code: undefined
})

async function onSubmit(event: FormSubmitEvent<Schema>) {
  // Do something with data
  console.log(event.data)
  $api.post('/offices', event.data)
        .then((response) => {
            if(response.status == 200)
                emit('update:show', false)
        })
}

function toggleModal(state : boolean | undefined){
    emit("update:show", state)
}

</script>

<!-- VALIDATION -->
<template>
    <TSlideover :modelValue="show" @update:modelValue="toggleModal">
        <div class="p-4 flex-1">
            <TButton
            color="gray"
            variant="ghost"
            size="sm"
            icon="i-heroicons-x-mark-20-solid"
            class="flex sm:hidden absolute end-5 top-5 z-10"
            square
            padded
            @click= "toggleModal(false)"
            />
                <h2 class="text-xl">Create new Office </h2>
                <p class="text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Explicabo officia culpa eveniet voluptas atque mollitia corrupti magnam vel possimus labore. Quaerat animi eaque officiis nemo impedit natus cum debitis minima?</p>
                <TForm :schema="schema" :validate="validate" :state="state" class="space-y-4" @submit="onSubmit">
                    <TFormGroup label="Office Name" name="name">
                        <TInput v-model="state.name" />
                    </TFormGroup>

                    <TFormGroup label="Office Code" name="code">
                        <TInput v-model="state.code" />
                    </TFormGroup>
                    <div></div>
                    <TButton type="submit">
                        Submit
                    </TButton>
                </TForm>
        </div>
    </TSlideover>
</template>