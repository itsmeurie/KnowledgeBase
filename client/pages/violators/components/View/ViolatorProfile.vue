<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{ violator: any }>();

const avatarSeed = computed(() => {
    return props.violator?.first_name?.replaceAll(' ', '+') ?? '';
});
</script>

<template>
    <div class="flex items-center gap-4 p-4">
        <TAvatar size="xl" :src="`https://api.dicebear.com/9.x/avataaars/svg?seed=${avatarSeed}`" alt="User Avatar" />
        <div class="flex-row gap-y-10">
            <h1 class="text-2xl font-semibold text-gray-900">{{ violator?.full_name }}</h1>
            <p class="text-gray-600 text-xs">Gender: <span class="font-sm">{{ violator?.gender }}</span></p>
        </div>
    </div>
</template>