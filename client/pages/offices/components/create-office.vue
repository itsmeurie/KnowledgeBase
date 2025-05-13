<script setup lang="ts">
import { z } from "zod";
import type { FormError, FormSubmitEvent } from "#ui/types";

const { $api } = useNuxtApp();

const props = defineProps({
  show: Boolean,
});

const emit = defineEmits(["update:show"]);

const validate = (state: any): FormError[] => {
  const errors = [];
  if (!state.name) errors.push({ path: "name", message: "Required" });
  if (!state.code) errors.push({ path: "code", message: "Required" });
  if (!state.description)
    errors.push({ path: "description", message: "Required" });
  return errors;
};

const schema = z.object({
  name: z.string(),
  code: z.string().min(3, "Must be at least 3 characters"),
  description: z.string(),
});

type Schema = z.output<typeof schema>;

const state = reactive({
  name: undefined,
  code: undefined,
  description: undefined,
});

async function onSubmit(event: FormSubmitEvent<Schema>) {
  console.log(event.data);
  $api.post("/offices", event.data).then((response) => {
    if (response.status === 200) emit("update:show", false);
  });
}

function toggleModal(value: boolean) {
  emit("update:show", value);
}
</script>

<template>
  <TModal :modelValue="show" @update:modelValue="toggleModal">
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Create new Office</h2>
        <TButton
          icon="i-heroicons-x-mark-20-solid"
          variant="ghost"
          size="sm"
          @click="toggleModal(false)"
        />
      </div>

      <p class="text-sm text-gray-600 mb-4">
        Fill out the form below to create a new office.
      </p>

      <TForm
        :schema="schema"
        :validate="validate"
        :state="state"
        class="space-y-4"
        @submit="onSubmit"
      >
        <TFormGroup label="Office Name" name="name">
          <TInput v-model="state.name" />
        </TFormGroup>

        <TFormGroup label="Office Code" name="code">
          <TInput v-model="state.code" />
        </TFormGroup>

        <TFormGroup label="Short Description" name="description">
          <TInput v-model="state.description" />
        </TFormGroup>

        <div class="pt-4 flex justify-end">
          <TButton type="submit">Submit</TButton>
        </div>
      </TForm>
    </div>
  </TModal>
</template>
