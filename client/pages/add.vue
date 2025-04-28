<script setup lang="ts">
import MarkdownEditor from "@/pages/markdowneditor.vue";
import { ref } from "vue";
import type { Section } from "~/types";
import type { FormError, FormSubmitEvent } from "#ui/types";
import { z } from "zod";
import { content } from "#tailwind-config";

const open = ref(true);
const section = ref<Section>();
const { $api } = useNuxtApp();
const route = useRoute();
const emit = defineEmits(["update:show"]);
const sections = ref<Section[]>([]);
// const selectedSectionId = ref<"none" | number>("none");
const aboutSection = ref<HTMLElement | null>(null);
const toast = useToast();
const loading = ref(false);

const { office } = useAuthStore();

defineShortcuts({
  o: () => (open.value = !open.value),
});

const schema = z.object({
  title: z
    .string({ message: "Title is required" })
    .min(1, { message: "Title is required" }),
  description: z.string().optional().nullable(),
  contents: z.string().optional().nullable(),
  parent_id: z.string().optional().nullable(),
});

type Schema = z.output<typeof schema>;

const state = ref<{
  title?: string;
  description?: string;
  contents?: string;
  parent_id?: string;
}>({
  title: "",
  description: "",
  contents: "",
  parent_id: "none",
});

const onSubmit = (event: FormSubmitEvent<Schema>): Promise<void> => {
  return new Promise((resolve, reject) => {
    loading.value = true;
    $api
      .post("/sections", {
        ...event.data,
      })
      .then((response) => {
        emit("update:show", false);

        state.value.contents = "";
        state.value.title = "";
        state.value.description = "";
        state.value.parent_id = "none"; // Also reset dropdown properly

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

// const fetchOffice = async (): Promise<void> => {
//   if (!route.params.slug) return;

//   return $api
//     .get("/offices/", { params: { code: route.params.slug } })
//     .then((response) => {
//       response.data[0];
//       if (office?.id) {
//         fetchSection();
//       }
//     })
//     .catch((error) => {
//       console.error("Error fetching office:", error);
//     });
// };
const fetchSection = (): void => {
  $api
    .get(`sections/section`)
    .then((response) => {
      sections.value = response.data;
      section.value = sections.value.length ? sections.value[0] : undefined;
    })
    .catch((error) => {
      console.error("Error fetching section:", error);
    });
};

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
  return state.value.parent_id !== "none" ? "Subsection" : "Section";
});

const showDescriptionField = computed(() => {
  return state.value.parent_id === "none";
});

onMounted(() => {
  fetchSection();
});

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
          v-model="state.parent_id"
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
          <TButton type="submit" class="mt-4" color="primary" variant="solid"
            >Submit</TButton
          >
        </TForm>
      </div>
    </div>
    <!-- Markdown Editor -->
    <div
      class="border-black-500 col-span-3 min-h-[500px] w-full rounded-lg border-4 p-4"
    >
      <MarkdownEditor v-model="state.contents" />
    </div>
  </div>
</template>
