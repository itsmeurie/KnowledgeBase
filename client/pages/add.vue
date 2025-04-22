<script setup lang="ts">
import MarkdownEditor from "@/pages/markdowneditor.vue";
import { ref } from "vue";
import type { Section, Office } from "~/types";
import type { FormError, FormSubmitEvent } from "#ui/types";
import { z } from "zod";

const open = ref(true);
const office = ref<Office>();
const section = ref<Section>();
const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const emit = defineEmits(["update:show"]);
const sections = ref<Section[]>([]);
const selectedSectionId = ref<"none" | number>("none");
const aboutSection = ref<HTMLElement | null>(null);
const toast = useToast();
const loading = ref(false);

defineShortcuts({
  o: () => (open.value = !open.value),
});

const schema = z.object({
  title: z
    .string({ message: "Title is required" })
    .min(1, { message: "Title is required" }),
  description: z
    .string({ message: "Description is required" })
    .min(1, { message: "Description is required" }),
});

type Schema = z.output<typeof schema>;

const state = ref<{
  title?: string;
  description?: string;
}>({
  title: "",
  description: "",
});

const onSubmit = (event: FormSubmitEvent<Schema>): Promise<void> => {
  return new Promise((resolve, reject) => {
    loading.value = true;
    $api
      .post("/sections", {
        office_id: office.value?.id,
        ...event.data,
      })
      .then((response) => {
        emit("update:show", false);

        state.value.title = "";
        state.value.description = "";
        selectedSectionId.value = "none"; // Reset the section selection

        toast.add({
          title:
            selectedSectionId.value === "none"
              ? "Section Added"
              : "Subsection Added",
          color: "green",
          icon: "i-heroicons-check-circle",
        });

        resolve();
      })
      .catch((error) => {
        reject(error);
      })
      .finally(() => {
        loading.value = false;
      });
  });
};

// async function onSubmit(event: FormSubmitEvent<Schema>) {
//   try {
//     const response = await $api.post("/sections", {
//       office_id: office.value?.id,
//       ...event.data,
//     });

//     if (response.status === 200) {
//       emit("update:show", false);

//       // Resetting state and selectedSectionId
//       state.title = "";
//       state.description = "";
//       selectedSectionId.value = "none"; // Reset the section selection

//       // Showing the appropriate toast
//       toast.add({
//         title:
//           selectedSectionId.value === "none"
//             ? "Section Added"
//             : "Subsection Added",
//         color: "green",
//         icon: "i-heroicons-check-circle",
//       });
//     }
//   } catch (error: unknown) {
//     if (error instanceof Error) {
//       toast.add({
//         title: "Error submitting form",
//         description: error.message,
//         color: "red",
//         icon: "i-heroicons-x-circle",
//       });
//       console.error(error);
//     } else {
//       toast.add({
//         title: "Unknown Error",
//         description: "An unknown error occurred",
//         color: "red",
//         icon: "i-heroicons-x-circle",
//       });
//       console.error("Unknown error:", error);
//     }
//   }
// }

const fetchOffice = async (): Promise<void> => {
  if (!route.params.slug) return;

  return $api
    .get("/offices/", { params: { code: route.params.slug } })
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

// async function fetchOffice() {
//   if (!route.params.slug) return;

//   try {
//     const response = await $api.get("/offices/", {
//       params: { code: route.params.slug },
//     });
//     office.value = response.data[0];

//     if (office.value?.id) {
//       fetchSection();
//     }
//   } catch (error) {
//     console.error("Error fetching office:", error);
//   }
// }

const fetchSection = (): Promise<void> => {
  return $api
    .get(`/sections/office/${office.value?.id}`)
    .then((response) => {
      sections.value = response.data.data;
      section.value = sections.value.length ? sections.value[0] : undefined;
    })
    .catch((error) => {
      console.error("Error fetching section:", error);
    });
};
// async function fetchSection() {
//   try {
//     const response = await $api.get(`/sections/${office.value?.id}`);
//     sections.value = response.data.data;
//     section.value = sections.value.length ? sections.value[0] : null;
//   } catch (error) {
//     console.error("Error fetching section:", error);
//   }
// }

const sectionOptions = computed(() => {
  const defaultOption = { label: "Select Office Section", value: "none" };

  if (sections.value.length === 0) {
    return [
      defaultOption,
      { label: "No section title yet", value: "none", disabled: true },
    ];
  }

  return [
    defaultOption,
    ...sections.value.map((s) => ({
      label: s.title,
      value: s.id,
    })),
  ];
});

const sectionLabel = computed(() => {
  return selectedSectionId.value !== "none" ? "Subsection" : "Section";
});

const showDescriptionField = computed(() => {
  return selectedSectionId.value === "none";
});

onMounted(() => {
  fetchOffice();
});

const links = [
  { label: "Home", to: "/playground" },
  { label: "Docs", to: "/add" },
  { label: "About", to: "#about-documentation" },
];

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: "smooth", block: "start" });
  }
};
</script>

<template>
  <!-- Body -->
  <div class="m-2 grid gap-4 p-4 sm:grid-cols-4">
    <!-- Input Section -->
    <div
      class="col-span-1 min-h-[400px] w-full rounded-lg border border-gray-300 p-4 sm:w-[300px]"
    >
      <p class="font-Inter text-lg font-bold">INFORMATION</p>

      <div class="mt-2">
        <label class="font-Inter mt-2">Office</label>
        <TInput disabled size="md" :model-value="office?.name" />
      </div>

      <!-- Select Menu -->
      <div class="mt-2">
        <TSelect
          v-model="selectedSectionId"
          :options="sectionOptions"
          :popper="{ placement: 'bottom-start' }"
        />
      </div>
      <div class="mt-2">
        <TForm
          :schema="schema"
          :state="state"
          class="space-y-4"
          @submit="onSubmit"
        >
          <TFormGroup
            class="font-Inter mt-2"
            :label="sectionLabel"
            name="title"
          >
            <TInput v-model="state.title" size="md" />
          </TFormGroup>
          <TFormGroup
            v-if="showDescriptionField"
            label="Short Description"
            name="description"
          >
            <TInput v-model="state.description" size="md" />
          </TFormGroup>
          <div></div>
          <!-- <p class="font-Inter text-l mt-4 font-bold">ADDITIONAL RESOURCES</p>
          <div class="mt-2">
            <label class="font-Inter">Upload File</label>
            <TInput type="file" size="md" class="mt-1 w-full" />
          </div> -->
          <TButton class="mt-4" color="primary" variant="solid">Submit</TButton>
        </TForm>
      </div>
    </div>
    <!-- Markdown Editor -->
    <div
      class="border-black-500 col-span-3 min-h-[500px] w-full rounded-lg border-4 p-4"
    >
      <MarkdownEditor />
    </div>
  </div>
</template>
