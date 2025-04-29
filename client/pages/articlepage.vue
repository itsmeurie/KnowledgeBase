<script setup lang="ts">
import type { Section, Office } from "~/types";
import { useRouter } from "vue-router";
import { marked } from "marked";
import { computed } from "vue";

const renderedContent = computed(() =>
  marked(activeSubsection.value?.contents || section.value?.contents || ""),
);

const offices = ref<Office>();
const { office } = useAuthStore();
const officeSection = ref<Section[]>([]); // List of office sections
const section = ref<Section>(); // Store active section
const activeSubsection = ref<Section | null>(null); // Currently active subsection

const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const isHovered = ref(false);
const openItems = ref<string[]>([]);

// Fetch Office Sections
const fetchOffice = () => {
  if (!route.params.slug) return;

  $api
    .get("/offices/", {
      params: { code: route.params.code },
    })
    .then((response) => {
      offices.value = response.data[0];
      if (office?.id) {
        fetchSection();
      }
    })
    .catch((error) => {
      console.error("Error fetching office:", error);
    });
};

const fetchSection = () => {
  if (!route.params.slug) return;

  $api
    .get(`/sections/slug/${route.params.slug}`)
    .then((response) => {
      section.value = response.data;
      if (section.value?.title) {
        openItems.value = [section.value.title];
      }
    })
    .catch((error) => {
      console.error("Error fetching section:", error);
    });
};

onMounted(() => {
  fetchOffice();
});

watch(
  () => route.params.slug,
  () => {
    if (office) {
      fetchSection();
      const matchedSection = officeSection.value.find(
        (s) => s.slug === route.params.slug,
      );
      if (matchedSection) {
        openItems.value = [matchedSection.title];
      }
    }
  },
);

const formattedUpdatedAt = computed(() => {
  const dateStr =
    activeSubsection.value?.updated_at || section.value?.updated_at;
  if (!dateStr) return "Unknown";

  const date = new Date(dateStr);
  return date.toLocaleDateString("en-US", {
    month: "numeric",
    day: "numeric",
    year: "numeric",
  });
});

const selectSubsection = (subsection: Section) => {
  activeSubsection.value = subsection;
};

const clearSubsection = () => {
  activeSubsection.value = null;
};

const goToEditPage = () => {
  router.push("/systems/:code/create");
};
</script>

<template>
  <div class="mt-12 grid gap-4 sm:grid-cols-10">
    <!-- Left Side Bar -->
    <aside class="px-4 sm:col-span-2 sm:px-6">
      <div class="mb-4">
        <TInput
          icon="i-heroicons-magnifying-glass-20-solid"
          size="sm"
          color="white"
          :trailing="false"
          placeholder="Search here..."
          class="w-full"
        />
      </div>

      <!-- Section title (clickable to reset subsection) -->
      <div class="mb-6">
        <h6
          class="hover:text-primary cursor-pointer text-lg font-bold"
          @click="clearSubsection"
        >
          {{ section?.title }}
        </h6>
      </div>

      <!-- Subsections List -->
      <div class="max-h-96 space-y-2 overflow-y-auto pr-2 scrollbar-thin">
        <div
          v-for="sub in section?.subsections || []"
          :key="sub.id"
          @click="selectSubsection(sub)"
          class="hover:text-primary cursor-pointer rounded px-2 py-1 transition-colors"
          :class="{ 'text-primary': sub.id === activeSubsection?.id }"
        >
          {{ sub.title }}
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="col-span-full mx-4 flex flex-col gap-6 sm:col-span-6">
      <!-- Breadcrumbs -->
      <div
        class="flex flex-wrap items-center justify-between gap-2 px-2 sm:px-6"
      >
        <nav class="flex flex-wrap items-center space-x-2 text-sm sm:text-base">
          <NuxtLink
            :to="{
              name: 'system-sections',
              params: { code: office?.code?.toLowerCase() },
            }"
            class="transition-colors"
            :class="{
              'text-primary': isHovered,
              'hover:text-primary': !isHovered,
            }"
            @mouseenter="isHovered = true"
            @mouseleave="isHovered = false"
          >
            {{ office?.name }}
          </NuxtLink>

          <span v-if="section" class="mx-2 text-gray-500">></span>
          <button
            v-if="section"
            @click="clearSubsection"
            class="hover:text-primary transition-colors"
          >
            {{ section?.title }}
          </button>

          <span v-if="activeSubsection" class="mx-2 text-gray-500">></span>

          <!-- Subsection Title -->
          <span v-if="activeSubsection" class="font-semibold">
            {{ activeSubsection?.title }}
          </span>
        </nav>

        <!-- Edit Icon -->
        <TIcon
          name="i-heroicons-pencil-square"
          class="h-6 w-6 cursor-pointer hover:text-black"
          @click="goToEditPage"
        />
      </div>

      <!-- Article Content -->
      <section class="space-y-6">
        <div>
          <h1 class="text-2xl font-extrabold sm:text-4xl">
            {{ activeSubsection?.title || section?.title }}
          </h1>
        </div>
        <!-- Update Date-->
        <div class="text-sm">Last update: {{ formattedUpdatedAt }}</div>

        <!-- Markdown -->
        <div v-html="renderedContent" class="prose max-w-full"></div>
      </section>
    </main>

    <!-- Documents Sidebar -->
    <aside class="col-span-full mt-8 px-4 sm:col-span-2 sm:mt-0 sm:px-6">
      <div class="text-center">
        <p class="mb-2 text-xl font-bold">More Information</p>
        <hr class="mb-4 border-gray-300" />
      </div>

      <div class="flex items-center justify-center gap-2">
        <TIcon name="tabler:book" class="text-lg" />
        <h2 class="text-lg font-semibold">Documents</h2>
      </div>
    </aside>
  </div>
</template>
