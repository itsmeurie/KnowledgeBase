<script setup lang="ts">
import { useNuxtApp } from "#app";
const emit = defineEmits(["delete", "close"]);
const props = defineProps<{ modelValue: any }>();

const { $api } = useNuxtApp();
const loading = ref(false);

async function confirmDelete() {
  loading.value = true;
  try {
    await $api.delete(`/offices/${props.modelValue.id}`);
    emit("delete", props.modelValue);
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="space-y-4 p-4">
    <h2 class="text-lg font-semibold">Confirm Deletion</h2>
    <p>
      Are you sure you want to delete <strong>{{ modelValue.name }}</strong
      >?
    </p>
    <div class="mt-4 flex justify-end space-x-2">
      <TButton @click="emit('close')" variant="ghost">Cancel</TButton>
      <TButton color="red" :loading="loading" @click="confirmDelete"
        >Delete</TButton
      >
    </div>
  </div>
</template>
