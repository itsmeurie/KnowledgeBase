<script setup lang="ts">
const isOpen = ref(false);
const resolvePromise = ref<((value: boolean) => void) | null>(null);

const title = ref('Confirm Action');
const message = ref('Are you sure you want to perform this action?');

function openDialog(dialogTitle: string, dialogMessage: string): Promise<boolean> {
    title.value = dialogTitle;
    message.value = dialogMessage;
    isOpen.value = true;
    return new Promise((resolve) => {
        resolvePromise.value = resolve;
    });
}

function onConfirm() {
    if (resolvePromise.value) {
        resolvePromise.value(true);
    }
    isOpen.value = false;
}

function onCancel() {
    if (resolvePromise.value) {
        resolvePromise.value(false);
    }
    isOpen.value = false;
}

defineExpose({ openDialog });
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
            <h2 class="text-lg font-semibold mb-4">{{ title }}</h2>
            <p class="text-gray-600 mb-6">{{ message }}</p>
            <div class="flex justify-end gap-4">
                <TButton color="gray" variant="outline" @click="onCancel">Cancel</TButton>
                <TButton color="red" @click="onConfirm">Confirm</TButton>
            </div>
        </div>
    </div>
</template>