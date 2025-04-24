<script setup lang="ts">
import type { Section, Office } from "~/types";
import { useRouter } from "vue-router";
const office = ref<Office>();
const officeSection = ref<Section[]>([]);
const section = ref<Section>(); // Store active section

const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const isHovered = ref(false);

<<<<<<< Updated upstream

const items = ref([
  {
    label: "CEDULA",
    children: [{ label: "Why do we need Cedula", to: "/why" }],
  },
]);

// nabago
const openItems = ref([]);
=======
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

>>>>>>> Stashed changes
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
  <div class="mt-12 grid gap-2 sm:grid-cols-10">
    <!-- Accordion Navigation -->
    <div class="sm:col-span-2">
      <!-- Search Bar -->
      <div class="ml-6 rounded-md sm:col-span-2">
        <TInput
          icon="i-heroicons-magnifying-glass-20-solid"
          size="sm"
          color="white"
          :trailing="false"
          placeholder="Search here..."
        />
      </div>
      <!-- Office title -->
      <div class="ml-7 mt-3 flex flex-col justify-center font-bold">
        <h6>{{ office?.name }}</h6>
      </div>

      <!-- Accordion-->
      <div class="m-3 w-64">
        <TAccordion
          v-model:open="openItems"
          :items="
            officeSection.map((section) => ({
              label: section.slug,
              displayTitle: section.title,
              children: [
                {
                  label: 'Sample Child Item',
                  to: `/articlepage/${section.slug}/${section.id}`,
                },
              ],
            }))
          "
          multiple
        >
          <template #default="{ item }">
            <TButton
              color="gray"
              variant="ghost"
              block
              class="flex w-full items-center justify-between px-4 py-2 text-left"
              :class="{
                'text-primary font-bold': item.label === route.params.slug,
              }"
              @click="handleParentSectionClick(item.label)"
            >
              <span>{{ item.displayTitle }}</span>
              <TIcon
                :name="
                  openItems.includes(item.label)
                    ? 'i-heroicons-chevron-down'
                    : 'i-heroicons-chevron-right'
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
              </li>
            </ul>
          </template>
        </TAccordion>
      </div>
    </div>

    <div class="col-span-6 grid grid-cols-1 gap-4">
      <div
        class="flex flex-wrap items-center justify-between gap-4 px-4 py-2 sm:px-10"
      >
        <!-- Breadcrumbs Office and Sections-->
        <nav class="flex flex-wrap items-center space-x-2 text-sm sm:text-base">
          <NuxtLink
            to="/articlepage"
            external
            class="transition-colors"
            :class="{
              'text-green-600': isHovered,
              'hover:text-green-700': !isHovered,
            }"
            @mouseenter="isHovered = true"
            @mouseleave="isHovered = false"
          >
            {{ office?.name }}
          </NuxtLink>

          <span v-if="section" class="text-gray-500"> > </span>

          <NuxtLink
            v-if="section"
            :to="`/articlepage/${route.params.slug}/${section.id}`"
            class="transition-colors"
            :class="{
              'text-green-600': !isHovered,
              'hover:text-green-800': isHovered,
            }"
          >
            {{ section.title }}
          </NuxtLink>
        </nav>

        <!-- Edit Icon -->
        <div class="flex items-center space-x-4">
          <TIcon
            name="i-heroicons-pencil-square"
            class="h-5 w-5 cursor-pointer text-gray-600 transition hover:text-black"
            @click="goToEditPage"
          />
        </div>
      </div>

      <div class="ml-1 grid gap-2">
        <!-- Title of Article -->
        <div class="col-span-1 ml-5">
          <div :key="section?.id">
            <h1 class="font-Inter p-4 text-4xl font-extrabold text-black">
              {{ section?.title }}
            </h1>
          </div>
        </div>

        <!-- Last update -->
        <div class="min-h-0.625 w-200 col-span-1 ml-20">
          Last update 04/18/2025
        </div>

        <div class="col-span-1" v-html="section?.contents"></div>
      </div>
    </div>

    <!-- Documents -->
    <div class="sm:col-span-2">
      <!-- More information -->
      <div class="h-10 sm:col-span-2">
        <p class="text-center text-xl font-bold">More Information</p>
        <div class="m-4 mx-6">
          <hr class="border-gray-700" />
        </div>
      </div>
      <div class="m-4 flex items-center justify-center">
        <TIcon name="tabler:book" class="m-1.5 text-lg"></TIcon>
        <h1 class="text-black-100 font-Inter text-lg font-semibold">
          Documents
        </h1>
      </div>
    </div>
  </div>
</template>
