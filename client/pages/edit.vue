<script setup lang="ts">
import { ref, computed, reactive } from 'vue'
import { useRoute } from 'vue-router';

const route = useRoute();
const officeName = ref(route.query.office as string || '');  // Get office name

// Set the form name when the page loads
const formState = reactive({
  name: officeName.value,
  code: ''
});


const OfficeHeader = defineAsyncComponent(() => import('@/pages/header.vue'))


const columns = ['Offices', 'View', 'Action']

const article = ref([
  { Office_name: 'City Mayors Office', Code: 'CMO123', Delete: 'Delete', Edit: 'Edit' },
])

const q = ref('')
const showDeleteModal = ref(false)
const showViewModal = ref(false)
const showEditModal = ref(false)
const selectedArticle = ref('')
const deleteIndex = ref<number | null>(null)

// const formState = reactive({
//   name: '',
//   code: ''
// })

const filteredRows = computed(() => {
  if (!q.value) return article.value
  return article.value.filter((article) =>
    Object.values(article).some((value) =>
      String(value).toLowerCase().includes(q.value.toLowerCase())
    )
  )
})

const openViewModal = (item: string) => {
  selectedArticle.value = item
  showViewModal.value = true
}

const openDeleteModal = (item: string, index: number) => {
  selectedArticle.value = item
  deleteIndex.value = index
  showDeleteModal.value = true
}

const openEditModal = (item: any, index: number) => {
  selectedArticle.value = item.Office_name;  // Update selected article
  deleteIndex.value = index;
  formState.name = item.Office_name;  // Set office name in form
  formState.code = item.Code;
  showEditModal.value = true;
};


const closeModals = () => {
  showDeleteModal.value = false
  showViewModal.value = false
  showEditModal.value = false
  selectedArticle.value = ''
  deleteIndex.value = null
}

const confirmDelete = () => {
  if (deleteIndex.value !== null) {
    article.value.splice(deleteIndex.value, 1)
  }
  closeModals()
}
</script>

<template>
  <!-- HEader-->
    <OfficeHeader />
  <div class="p-4">
    <div class="max-w-4xl mx-auto p-4">
      <input
        v-model="q"
        placeholder="Filter articles..."
        class="border border-gray-300 rounded p-2 w-full mb-4"
      />

      <table class="w-full border-collapse border border-gray-200">
        <thead>
          <tr class="bg-gray-100">
            <th v-for="column in columns" :key="column" class="border px-4 py-2">
              {{ column }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(article, index) in filteredRows" :key="article.Office_name" class="text-center">
            <td class="border px-4 py-2">{{ article.Office_name }}</td>
            <td class="border px-4 py-2 item">
                <div class="flex items-center justify-center gap-2">
                <TIcon name="i-heroicons-eye" 
                  class="text-black-500 cursor-pointer hover:text-green-700"
                  @click="openViewModal(article.Office_name)" />
                </div>
            </td>
            <td class="border px-4 py-2 gap-4">
              <div class="flex items-center justify-center gap-2">
                <TIcon name="i-heroicons-pencil-square" 
                  class="text-blue-500 cursor-pointer hover:text-blue-700"
                  @click="openEditModal(article, index)" />

                <TIcon name="i-heroicons-trash" 
                  class="text-red-500 cursor-pointer hover:text-red-700"
                  @click="openDeleteModal(article.Office_name, index)" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Edit Slideover -->
    <TSlideover :modelValue="showEditModal" @update:modelValue="showEditModal = $event">
        <div class="p-4 flex-1">
            <TButton
            color="gray"
            variant="ghost"
            size="sm"
            icon="i-heroicons-x-mark-20-solid"
            class="flex sm:hidden absolute end-5 top-5 z-10"
            square
            padded
            @click="showEditModal = false"
            />
            <h2 class="text-xl">Edit Office</h2>
            <p class="text-sm">Modify the office details as needed.</p>
            <TForm :state="formState" class="space-y-4">
                <TFormGroup label="Office Name">
                  <TInput v-model="formState.name"/>
                </TFormGroup>
                <TFormGroup label="Office Code">
                    <TInput v-model="formState.code" />
                </TFormGroup>
                <TButton type="button" @click="showEditModal = false">
                    Save Changes
                </TButton>
            </TForm>
        </div>
    </TSlideover>
  </div>
</template>
