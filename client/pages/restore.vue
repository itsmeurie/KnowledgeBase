<script setup lang="ts">
import { ref, computed } from "vue";

// Sample Section Data
const section = [
  {
    section_title: "Lindsay Walton",
    subsection_title: "Front-end Developer",
  },
  {
    section_title: "Courtney Henry",
    subsection_title: "Designer",
  },
  {
    section_title: "Tom Cook",
    subsection_title: "Director of Product",
  },
  {
    section_title: "Whitney Francis",
    subsection_title: "Copywriter",
  },
  {
    section_title: "Lindsay Walton",
    subsection_title: "Front-end Developer",
  },
];

const selected = ref<any[]>([]);

const allSelected = computed({
  get: () => selected.value.length === section.length,
  set: (value: boolean) => {
    selected.value = value ? [...section] : [];
  },
});

const isChecked = (item: any) => {
  return selected.value.includes(item);
};
</script>

<template>
  <div class="flex h-[500px] flex-col">
    <!-- Scrollable Table Container -->
    <div class="flex-1 overflow-auto">
      <table class="w-full table-auto">
        <!-- Sticky Header -->
        <thead class="sticky top-0 z-10 bg-gray-100">
          <tr>
            <th class="p-2 text-left">Section Name</th>
            <th class="p-2 text-left">Subsection Name</th>
            <th class="w-2 p-2 text-center">
              <input type="checkbox" v-model="allSelected" />
            </th>
          </tr>
        </thead>
        <!-- Scrollable Body -->
        <tbody>
          <tr
            v-for="(item, index) in section"
            :key="index"
            class="odd:bg-white even:bg-gray-50"
          >
            <td class="p-2">{{ item.section_title }}</td>
            <td class="p-2">{{ item.subsection_title }}</td>
            <td class="w-2 p-2 text-center">
              <input
                type="checkbox"
                :checked="isChecked(item)"
                @change="
                  (event) => {
                    const target = event.target as HTMLInputElement;
                    if (target.checked) {
                      if (!isChecked(item)) selected.push(item);
                    } else {
                      selected = selected.filter((i) => i !== item);
                    }
                  }
                "
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Fixed Button -->
    <div class="flex items-center justify-end border-t p-2">
      <TButton
        icon="tabler:restore"
        size="sm"
        color="primary"
        variant="solid"
        label="Restore"
        :trailing="false"
      />
    </div>
  </div>
</template>
