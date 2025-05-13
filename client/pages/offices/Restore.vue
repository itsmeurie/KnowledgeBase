<script setup lang="ts">
import type { Section } from "~/types";
import { defineProps, defineEmits } from "vue";

const { $api } = useNuxtApp();
const loading = ref(false);
const toast = useToast();

const emit = defineEmits(["close", "restore"]);

const props = defineProps<{
  modelValue: Section;
}>();

const handleRestore = () => {
  loading.value = true;
  $api
    .patch(`/sections/${props.modelValue.id}`)
    .then((response) => {
      toast.add({
        title: "Success",
        description: response.data.message ?? "Section restored successfully!",
        color: "primary",
        icon: "tabler:circle-check",
      });
      emit("restore", props.modelValue);
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
      <div>Restore Section</div>
      <TButton
        icon="tabler:x"
        variant="ghost"
        color="gray"
        @click="emit('close')"
      />
    </template>
    Are you sure you want to restore this?
    <h3>{{ modelValue.title }}</h3>
    <TInnerLoading :active="loading" text="Restore section..." />
    <template #footer>
      <TButton label="Restore" color="red" @click="handleRestore" />
      <TButton
        label="Cancel"
        variant="ghost"
        color="gray"
        @click="emit('close')"
      />
    </template>
  </TCard>
</template>
