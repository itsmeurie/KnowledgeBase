<script setup lang="ts">
import { ref, computed } from 'vue'

const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/offices' },
  { label: 'About', to: '/components/table' }
]

const columns = ['Offices', 'View', 'Action']

const article = ref([
  { Article: 'City Mayors Office', Delete: 'Delete', Edit: 'Edit' },
  { Article: 'Example Office', Delete: 'Delete' , Edit: 'Edit' },
  { Article: 'Example Office', Delete: 'Delete' , Edit: 'Edit' },
  { Article: 'Example Office', Delete: 'Delete', Edit: 'Edit' },
  { Article: 'Example Office', Delete: 'Delete', Edit: 'Edit'  }
])

const q = ref('')
const showDeleteModal = ref(false)
const showViewModal = ref(false)
const selectedArticle = ref('')
const deleteIndex = ref<number | null>(null)

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

const openEditModal = (item: string, index: number) => {
  selectedArticle.value = item
  deleteIndex.value = index
  // Handle edit logic here
  alert(`Edit ${item}`)
}

const closeModals = () => {
  showDeleteModal.value = false
  showViewModal.value = false
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


  <div class="p-4">
    <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
            <!-- Logo -->
            <div class="flex items-center min-w-48 ">
              <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Dokumentaryo</p>
            </div>
  
            <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
  
            <!-- Navigation -->
            <div class="w-full sm:w-auto col-span-3 flex justify-center sm:justify-end">
              <THorizontalNavigation :links="links">
                <template #default="{ link }">
                  <span class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative">{{ link.label }}</span>
                </template>
              </THorizontalNavigation>
            </div>
      </div>

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
          <tr v-for="(article, index) in filteredRows" :key="article.Article" class="text-center">
            <td class="border px-4 py-2">{{ article.Article }}</td>
            <td class="border px-4 py-2 item">
                <div class="flex items-center justify-center gap-2">
                <TIcon name="i-heroicons-eye" 
                  class="text-black-500 cursor-pointer hover:text-green-700"
                  @click="openDeleteModal(article.Article, index)" />
                </div>
            </td>
            <td class="border px-4 py-2 gap-4">
              <div class="flex items-center justify-center gap-2">
                <TIcon name="i-heroicons-pencil-square" 
                  class="text-blue-500 cursor-pointer hover:text-blue-700"
                  @click="openEditModal(article.Article, index)" />

                <TIcon name="i-heroicons-trash" 
                  class="text-red-500 cursor-pointer hover:text-red-700"
                  @click="openDeleteModal(article.Article, index)" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- View Modal -->
    <teleport to="body">
      <div v-if="showViewModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
          <p class="text-lg font-semibold mb-4">Article Details</p>
          <p class="text-gray-600 mb-6">"{{ selectedArticle }}"</p>
          <button @click="closeModals" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">
            Close
          </button>
        </div>
      </div>
    </teleport>

    <!-- Delete Confirmation Modal -->
    <teleport to="body">
      <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
          <p class="text-lg font-semibold mb-4">Are you sure you want to delete?</p>
          <p class="text-gray-600 mb-6">"{{ selectedArticle }}"</p>
          <div class="flex justify-center gap-4">
            <button @click="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
              Delete
            </button>
            <button @click="closeModals" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>
