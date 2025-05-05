<script setup lang="ts">
import type { LogData } from "~/types/models/logs";
import JsonEditorVue from "json-editor-vue";
import Badger from "~/pages/settings/roles/roleBadge.vue";

const { $dayjs } = useNuxtApp();
const colorMode = useColorMode();

const props = defineProps<{
  data: LogData;
  levelMap: Record<number, string>;
  colors: Record<number, string>;
}>();

const emit = defineEmits(["close"]);

const showOld = ref(true);

onMounted(() => {
  log(colorMode);
});
</script>

<template>
  <TCard
    :ui="{
      body: {
        base: 'flex flex-col',
      },
      footer: {
        base: 'flex items-center justify-end gap-2',
      },
    }"
  >
    <template #header>
      <div class="font-semibold">Log Info</div>
      <TButton
        icon="tabler:x"
        variant="ghost"
        color="gray"
        @click="emit('close')"
      />
    </template>
    <div class="space-y-4 overflow-y-auto pr-2">
      <div class="space-y-1">
        <h6 class="font-medium">Actor</h6>
        <div
          class="flex items-center gap-3 rounded-md border border-gray-400 p-3 dark:border-gray-500"
        >
          <div class="h-16 w-16 rounded-full bg-gray-200"></div>
          <div class="">
            <span class="font-medium"> {{ data.actor }}</span>
            <div
              class="flex items-center gap-3 *:text-gray-400 *:dark:text-gray-300"
            >
              <span>{{ data.user?.username }}</span>
              <span>|</span>
              <span>{{ data.user?.email }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="space-y-1">
        <h6 class="font-medium">Time</h6>
        <p class="rounded-md border border-gray-400 p-2 dark:border-gray-500">
          {{ $dayjs(data.date).format("YYYY-MM-DD HH:mm:ss") }}
        </p>
      </div>
      <div class="space-y-1">
        <h6 class="font-medium">Module</h6>
        <p class="rounded-md border border-gray-400 p-2 dark:border-gray-500">
          {{ data.module }}
        </p>
      </div>
      <div class="space-y-1">
        <h6 class="font-medium">Level</h6>
        <p class="rounded-md border border-gray-400 p-2 dark:border-gray-500">
          <Badger :color="colors[data.level]">
            <span class="text-base">
              {{ levelMap[data.level] }}
            </span>
          </Badger>
        </p>
      </div>

      <div class="space-y-1">
        <h6 class="font-medium">Header/Summary</h6>
        <p class="rounded-md border border-gray-400 p-2 dark:border-gray-500">
          {{ data.action }}
        </p>
      </div>
      <div class="flex flex-auto flex-col space-y-2">
        <div class="flex items-center gap-2">
          <TButton
            label="Old Data"
            :variant="showOld ? 'solid' : 'ghost'"
            @click="showOld = true"
          />
          <TButton
            label="New Data"
            :variant="!showOld ? 'solid' : 'ghost'"
            @click="showOld = false"
          />
        </div>
        <JsonEditorVue
          class="dark:jse-theme-dark-2 flex-auto"
          :modelValue="showOld ? data.old_data : data.new_data"
          readOnly
        />
      </div>
    </div>
    <template #footer>
      <TButton label="Close" variant="outline" @click="emit('close')" />
    </template>
  </TCard>
</template>
