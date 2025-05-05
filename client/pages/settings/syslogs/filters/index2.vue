<script setup lang="ts">
import Wrapper from "../wrapper.vue";

const { customize } = useIcon();
const dayjs = useDayjs();
// const props = defineProps<{}>();
const year = defineModel<number>("year");
const month = defineModel<number>("month");
const day = defineModel<number>("day");

const years = computed(() =>
  Array.from({ length: 100 }, (_, i) => new Date().getFullYear() - i),
);
const months = computed(() =>
  Array.from({ length: 12 }, (_, i) => {
    const m = dayjs().month(i);
    return {
      value: m.format("M"),
      label: m.format("MMMM"),
    };
  }),
);

const days = computed(() => {
  let d = 0;

  if (year.value && month.value) {
    d = dayjs().year(year.value).month(month.value).daysInMonth();
  }

  return Array.from({ length: d }, (_, i) => i + 1);
});
</script>

<template>
  <Wrapper>
    <template #header>
      <TIcon
        name="tabler:adjustments"
        :customize="(c: string) => customize(c, { strokeWidth: 2 })"
        class="h-5 w-5"
      />
      <TTypography variant="h6">Filters</TTypography>
    </template>
    <TFormGroup label="Year">
      <TSelect
        v-model.number="year"
        :options="years"
        @update:modelValue="((month = undefined), (day = undefined))"
      />
    </TFormGroup>
    <TFormGroup label="Month">
      <TSelect
        v-model.number="month"
        :options="months"
        @update:modelValue="day = undefined"
      >
        <template #trailing>
          <TIcon name="i-heroicons-arrows-up-down-20-solid" class="h-5 w-5" />
        </template>
      </TSelect>
    </TFormGroup>
    <TFormGroup v-if="false" label="Day">
      <TSelect v-model.number="day" :options="days" />
    </TFormGroup>

    <TPopover>
      <TFormGroup label="Day" class="w-full">
        <TButton
          block
          variant="ghost"
          color="gray"
          class="justify-start"
          :ui="{
            base: 'ring-1 min-h-8 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 bg-gray-50 dark:hover:!bg-gray-700 dark:bg-gray-700',
          }"
        >
          {{ day }}
        </TButton>
      </TFormGroup>
      <template #panel="{ close }">
        <div class="grid w-full grid-cols-5 gap-0.5 p-3">
          <template v-for="d in days" :key="`day_${d}`">
            <TButton
              :label="`${d}`"
              variant="ghost"
              square
              :ui="{
                base: 'text-center [&>span]:w-full',
              }"
              @click="((day = d), close())"
            />
          </template>
        </div>
      </template>
    </TPopover>

    <TDivider />
    <template #footer> </template>
  </Wrapper>
</template>
