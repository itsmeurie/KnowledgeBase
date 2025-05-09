<template>
  <TModal
    :model-value="props.show"
    @update:model-value="emit('update:show', $event)"
    prevent-close
  >
    <template #default>
      <div class="p-8 text-center">
        <h2 class="text-xl font-semibold">
          Are you sure you want to delete this item?
        </h2>
        <div class="mt-4 flex justify-center gap-4">
          <TButton
            label="No"
            variant="ghost"
            @click="closeModal"
            class="text-gray-600"
          />
          <TButton
            label="Yes"
            variant="solid"
            @click="handleDelete"
          />
        </div>
      </div>
    </template>
  </TModal>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  show: Boolean,
  itemId: [String, Number],
});

const emit = defineEmits(["update:show", "delete"]);

const closeModal = () => {
  emit("update:show", false);
};

const handleDelete = () => {
  emit("delete", props.itemId);
  closeModal();
};
</script>
