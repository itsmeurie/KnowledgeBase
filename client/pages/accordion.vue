<script setup lang="ts">


const items = ref([
  { 
    label: "CEDULA", 
    children: [
      { label: "Why do we need Cedula", to: "/why" },
      { label: "Where to use", to: "/where" },
      { label: "How to get Cedula", to: "/how" }
    ] 
  },
  { 
    label: "CI Office", 
    children: [
      { label: "Campus Executive Director" },
      { label: "Secretary" },
      { label: "Administrative Aide" }
    ] 
  },
  { 
    label: "VP Office", 
    children: [
      { label: "Campus Executive Director" },
      { label: "Secretary" },
      { label: "Administrative Aide" }
    ] 
  },
]);

const openItems = ref([]);

</script>

<template>

<div class="w-64 m-3">
         <TAccordion v-model:open="openItems" :items="items" multiple>
            <template #default="{ item, open }">
              <TButton 
                color="gray" 
                variant="ghost" 
                block 
                class="flex justify-between items-center px-4 py-2 w-full text-left"
              >
                <span>{{ item.label }}</span>
                <TIcon :name="open ? 'i-heroicons-chevron-down' : 'i-heroicons-chevron-right'" class="ml-2"/>
              </TButton>
            </template>
  
            <template #item="{ item }">
              <ul v-if="item.children" class="pl-6 text-gray-600">
                <li v-for="child in item.children" :key="child.label">
                  <router-link v-if="child.to" :to="child.to">
                    <TButton color="gray" variant="link" block class="flex justify-between items-center px-4 py-2 w-full text-left">
                      {{ child.label }}
                    </TButton>
                  </router-link>
                  <TButton v-else color="gray" variant="link" block class="flex justify-between items-center px-4 py-2 w-full text-left">
                    {{ child.label }}
                  </TButton>
                </li>
              </ul>
            </template>
        </TAccordion>
    </div>
</template>