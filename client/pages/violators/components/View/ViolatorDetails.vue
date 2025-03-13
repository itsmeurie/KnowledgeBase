<script setup lang="ts">
const { $api } = useNuxtApp();
const route = useRoute();

const violator = ref();

async function fetchViolatorDetails() {
    const response = await $api.get(`violators/${route.params.id}`);
    violator.value = response.data;
}

await fetchViolatorDetails();
</script>

<template>
    <div class="flex items-center gap-4 p-4">
        <TAvatar size="xl" :src="`https://api.dicebear.com/9.x/avataaars/svg?seed=${violator?.full_name}`"
            alt="User Avatar" />
        <div class="flex-row gap-y-10">
            <h1 class="text-2xl font-semibold text-gray-900">{{ violator?.full_name }}</h1>
            <p class="text-gray-600 text-xs">Gender: <span class="font-sm">{{ violator?.gender }}</span>
            </p>
        </div>
    </div>
</template>