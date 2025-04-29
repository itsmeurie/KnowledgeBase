<script setup lang="ts">
import type { Section, Office } from "~/types";
import { useRouter } from "vue-router";
const office = ref<Office>();
const officeSection = ref<Section[]>([]); // List of office sections
const section = ref<Section>(); // Store active section

const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const isHovered = ref(false);

const openItems = ref<string[]>([]);

// Fetch Office Sections
const fetchOfficeSectionList = () => {
  if (!office.value?.id) return Promise.resolve();
  return $api
    .get(`/sections/office/${office.value.id}`)
    .then((response) => {
      officeSection.value = response.data.data;
    })
    .catch((error) => {
      console.error("Error fetching sections:", error);
    });
};

const handleParentSectionClick = (slug: string) => {
  const matched = officeSection.value.find((s) => s.slug === slug);
  if (!matched) return;

  const isOpen = openItems.value.includes(slug);

  if (isOpen) {
    openItems.value = openItems.value.filter((item) => item !== slug);
    return;
  }
  openItems.value = [slug];

  Promise.resolve()
    .then(() => {
      return router.push({ params: { slug: matched.slug } });
    })
    .then(() => {
      return $api.get(`/sections/section/${office.value?.id}/${matched.slug}`);
    })
    .then((response) => {
      section.value = response.data;
    })
    .catch((error) => {
      console.error(error);
    })
    .finally(() => {});
};

const fetchOffice = () => {
  if (!route.params.slug) return;

  $api
    .get("/offices/", {
      params: { code: route.params.code },
    })
    .then((response) => {
      office.value = response.data[0];
      fetchOfficeSectionList();

      if (office.value?.id) {
        fetchSection();
      }
    })
    .catch((error) => {
      console.error("Error fetching office:", error);
    });
};

const fetchSection = () => {
  $api
    .get(`/sections/section/${office.value?.id}/${route.params.slug}`)
    .then((response) => {
      section.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching section:", error);
    });
};

watch(
  () => route.params.slug,
  () => {
    if (office.value) {
      fetchSection();

      // Update openItems when slug changes
      const matchedSection = officeSection.value.find(
        (s) => s.slug === route.params.slug,
      );
      if (matchedSection) {
        openItems.value = [matchedSection.title];
      }
    }
  },
);

onMounted(() => {
  fetchOffice();
});

const goToEditPage = () => {
  router.push("/offices/systems/:slug/create");
};
</script>

<template>
  <div class="mt-12 grid gap-4 sm:grid-cols-10">
    <!-- Accordion Navigation -->
    <aside class="px-4 sm:col-span-2 sm:px-6">
      <!-- Search Bar -->
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

      <!-- Office title -->
      <div class="mb-6">
        <h6 class="text-lg font-bold">Main Section</h6>
      </div>

      <!-- Sub-sections List with Scrollbar -->
      <div class="h-auto overflow-y-auto space-y-2 pr-2 scrollbar-thin"> <!-- added h-[400px] and overflow-y-auto -->
        <div
          v-for="sub in officeSection"
          :key="sub.id"
          @click="handleParentSectionClick(sub.slug)"
          class="hover:text-primary cursor-pointer rounded-md px-3 py-2"
        >
          {{ sub.title }}
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="col-span-full flex flex-col gap-6 mx-4 sm:col-span-6">
      <!-- Breadcrumbs and Edit Icon -->
      <div class="flex flex-wrap items-center justify-between gap-2 px-2 sm:px-6">
        <nav class="flex flex-wrap items-center space-x-2 text-sm sm:text-base">
          <NuxtLink
            to="/articlepage"
            external
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

          <NuxtLink
            v-if="section"
            :to="`/articlepage/${route.params.slug}/${section.id}`"
            class="hover:text-primary text-primary transition-colors"
          >
            <!-- {{ section.title }} -->
            Main Section
          </NuxtLink>
        </nav>

        <!-- Edit Icon -->
        <TIcon
          name="i-heroicons-pencil-square"
          class="h-6 w-6 cursor-pointer text-gray-600 hover:text-black"
          @click="goToEditPage"
        />
      </div>

      <!-- Article Content -->
      <section class="space-y-6">
        <div>
          <h1 class="text-2xl font-extrabold sm:text-4xl">Main Section</h1>
        </div>

        <div class="text-sm text-gray-500 sm:text-base">
          Last update 04/18/2025
        </div>

        <div v-html="section?.contents" class="max-w-full"></div>
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
