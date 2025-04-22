<script setup lang="ts">
const items = ref([
  {
    label: "CEDULA",
    children: [{ label: "Why do we need Cedula", to: "/why" }],
  },
]);

const openItems = ref([]);
</script>

<template>
  <div class="m-3 w-64">
    <TAccordion v-model:open="openItems" :items="items" multiple>
      <template #default="{ item, open }">
        <TButton
          color="gray"
          variant="ghost"
          block
          class="flex w-full items-center justify-between px-4 py-2 text-left"
        >
          <span>{{ item.label }}</span>
          <TIcon
            :name="
              open ? 'i-heroicons-chevron-down' : 'i-heroicons-chevron-right'
            "
            class="ml-2"
          />
        </TButton>
      </template>

      <template #item="{ item }">
        <ul v-if="item.children" class="pl-6 text-gray-600">
          <li v-for="child in item.children" :key="child.label">
            <router-link v-if="child.to" :to="child.to">
              <TButton
                color="gray"
                variant="link"
                block
                class="flex w-full items-center justify-between px-4 py-2 text-left"
              >
                {{ child.label }}
              </TButton>
            </router-link>
            <TButton
              v-else
              color="gray"
              variant="link"
              block
              class="flex w-full items-center justify-between px-4 py-2 text-left"
            >
              {{ child.label }}
            </TButton>
          </li>
        </ul>
      </template>
    </TAccordion>
  </div>
</template>
