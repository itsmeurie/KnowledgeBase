<script setup lang="ts">
import type { Section } from "~/types";
import { defineProps, defineEmits } from "vue";

const { $api } = useNuxtApp();
const loading = ref(false);
const toast = useToast();

const emit = defineEmits(["close", "delete"]);

const props = defineProps<{
  modelValue: Section;
}>();

const handleDelete = () => {
  loading.value = true;
  $api
    .delete(`/sections/${props.modelValue.id}`)
    .then((response) => {
      toast.add({
        title: "Success",
        description: response.data.message ?? "Section deleted successfully!",
        color: "primary",
        icon: "tabler:circle-check",
      });
      emit("delete", props.modelValue);
    })
    .catch((error) => {
      console.error(error);
    })
    .finally(() => {
      loading.value = false;
    });
};
</script>

<template>
  <TCard>
    <template #header>
      <div>Delete Section</div>
      <TButton
        icon="tabler:x"
        variant="ghost"
        color="gray"
        @click="emit('close')"
      />
    </template>
    Are you sure you want to delete this?
    <h3>{{ modelValue.title }}</h3>
    <TInnerLoading :active="loading" text="Deleting section..." />
    <template #footer>
      <TButton label="Delete" color="red" @click="handleDelete" />
      <TButton
        label="Cancel"
        variant="ghost"
        color="gray"
        @click="emit('close')"
      />
    </template>
  </TCard>
</template>
