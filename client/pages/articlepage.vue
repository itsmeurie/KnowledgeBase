<script setup lang="ts">
import type { Section, Office } from "~/types";
import { useRouter } from "vue-router";

const office = ref<Office>();
const officeSection = ref<Section[]>([]);
const section = ref<Section>(); // Store active section
const OfficeHeader = defineAsyncComponent(() => import("./header.vue"));
const Accordion = defineAsyncComponent(() => import("./accordion.vue"));

const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const isHovered = ref(false);

const fetchOffice = () => {
  if (!route.params.slug) return;

  $api
    .get("/offices/", {
      params: { code: route.params.code },
    })
    .then((response) => {
      office.value = response.data[0];

      if (office.value?.id) {
        fetchSection();
      }
    })
    .catch((error) => {
      console.error("Error fetching office:", error);
    });
};

// Fetch Section Details
const fetchSection = () => {
  $api
    .get(`/sections/section/${office.value?.id}/${route.params.slug}`)
    .then((response) => {
      section.value = response.data; // Update the section ref
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
    }
  },
);

const goToEditPage = () => {
  router.push("/edit-article");
};

onMounted(() => {
  fetchOffice();
});
</script>

<template>
  <!-- Header -->
  <OfficeHeader />

  <div class="m-1 grid gap-2 sm:grid-cols-10">
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
      <Accordion />
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

        <!-- Article -->
        <div class="col-span-1">
          <h1 class="font-Inter p-6 text-2xl font-semibold text-black">
            What is a Cedula?
          </h1>
        </div>

        <div class="col-span-1">
          <p class="ml-9">
            A Cedula is an official document issued by the local government unit
            (LGU) through the City or Municipal Treasurer’s Office. It serves as
            proof that an individual or business has paid the community tax,
            which is imposed on residents, professionals, and business owners
            within a locality.
          </p>
        </div>

        <div class="col-span-1">
          <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
            Why is a Cedula Necessary?
          </h1>
        </div>
        <div class="col-span-1">
          <p class="ml-9">
            The Cedula is required for several purposes, including but not
            limited to:
          </p>
        </div>
        <div class="col-span-1">
          <div class="col-span-1">
            <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
              1. Proof of Identity and Residency
            </h1>
          </div>
          <ul class="ml-9 list-disc">
            <li>
              The Cedula serves as a supplementary identification document for
              individuals who may not have other government-issued IDs.<br />
            </li>
            <li>
              It is often required when applying for local government services
              or assistance.
            </li>
          </ul>
        </div>

        <div class="col-span-1">
          <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
            2. Requirement for Government Transactions
          </h1>
        </div>
        <div class="col-span-1">
          <ul class="ml-9 list-decimal">
            <ul class="ml-9 list-disc">
              <li>
                Various government offices require a Cedula when processing
                barangay clearance, police clearance, and business permits.
              </li>
              <li>
                It is also needed when securing certain certifications and
                official documents.
              </li>
              <li>
                Flexible learning options, including on-campus, online, and
                hybrid courses.
              </li>
            </ul>
          </ul>
        </div>

        <div class="col-span-1">
          <div class="col-span-1">
            <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
              3. Proof of Identity and Residency
            </h1>
          </div>
          <ul class="ml-9 list-disc">
            <li>
              The Cedula serves as a supplementary identification document for
              individuals who may not have other government-issued IDs.<br />
            </li>
            <li>
              It is often required when applying for local government services
              or assistance.
            </li>
          </ul>
        </div>

        <div class="col-span-1">
          <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
            4. Requirement for Government Transactions
          </h1>
        </div>
        <div class="col-span-1">
          <ul class="ml-9 list-decimal">
            <ul class="ml-9 list-disc">
              <li>
                Various government offices require a Cedula when processing
                barangay clearance, police clearance, and business permits.
              </li>
              <li>
                It is also needed when securing certain certifications and
                official documents.
              </li>
              <li>
                Flexible learning options, including on-campus, online, and
                hybrid courses.
              </li>
            </ul>
          </ul>
        </div>

        <div class="col-span-1">
          <div class="col-span-1">
            <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
              6. Proof of Identity and Residency
            </h1>
          </div>
          <ul class="ml-9 list-disc">
            <li>
              The Cedula serves as a supplementary identification document for
              individuals who may not have other government-issued IDs.<br />
            </li>
            <li>
              It is often required when applying for local government services
              or assistance.
            </li>
          </ul>
        </div>

        <!-- No.3 -->
        <div class="col-span-1">
          <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
            7. Requirement for Government Transactions
          </h1>
        </div>
        <div class="col-span-1">
          <ul class="ml-9 list-decimal">
            <ul class="ml-9 list-disc">
              <li>
                Various government offices require a Cedula when processing
                barangay clearance, police clearance, and business permits.
              </li>
              <li>
                It is also needed when securing certain certifications and
                official documents.
              </li>
              <li>
                Flexible learning options, including on-campus, online, and
                hybrid courses.
              </li>
            </ul>
          </ul>
        </div>

        <div class="col-span-1">
          <div class="col-span-1">
            <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
              8. Proof of Identity and Residency
            </h1>
          </div>
          <ul class="ml-9 list-disc">
            <li>
              The Cedula serves as a supplementary identification document for
              individuals who may not have other government-issued IDs.<br />
            </li>
            <li>
              It is often required when applying for local government services
              or assistance.
            </li>
          </ul>
        </div>

        <!-- No.3 -->
        <div class="col-span-1">
          <h1 class="font-Inter p-4 text-2xl font-semibold text-black">
            9. Requirement for Government Transactions
          </h1>
        </div>
        <div class="col-span-1">
          <ul class="ml-9 list-decimal">
            <ul class="ml-9 list-disc">
              <li>
                Various government offices require a Cedula when processing
                barangay clearance, police clearance, and business permits.
              </li>
              <li>
                It is also needed when securing certain certifications and
                official documents.
              </li>
              <li>
                Flexible learning options, including on-campus, online, and
                hybrid courses.
              </li>
            </ul>
          </ul>
        </div>
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
