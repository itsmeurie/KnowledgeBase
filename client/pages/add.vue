<script setup lang="ts">
import MarkdownEditor from '@/pages/markdowneditor.vue'
import { ref } from 'vue';
import type { Section, Office } from '~/types';
import type { FormError, FormSubmitEvent } from '#ui/types'
import { z } from 'zod'

const open = ref(true)
const office = ref<Office>();
const section = ref<Section | null>(null); 
const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();
const emit = defineEmits(['update:show'])
const sections = ref<Section[]>([]);
const selectedSectionId = ref<'none' | number>('none');
const aboutSection = ref<HTMLElement | null>(null);
const toast = useToast();


defineShortcuts({
  o: () => open.value = !open.value
})

const validate = (state: any): FormError[] => {
  const errors = []
  if (!state.title) errors.push({ path: 'title', message: 'Required' })
  if (!state.description) errors.push({ path: 'description', message: 'Required' })
  return errors
}

const schema = z.object({
  title: z.string(),
  description: z.string(),
})

type Schema = z.output<typeof schema>

  const state = reactive({
  title: undefined as string | undefined,
  description: undefined as string | undefined
});

async function onSubmit(event: FormSubmitEvent<Schema>) {
  try {
    const response = await $api.post('/sections', {
      office_id: office.value?.id,
      ...event.data
    });

    if (response.status === 200) {
      emit('update:show', false);

      // Resetting state and selectedSectionId
      state.title = '';
      state.description = '';
      selectedSectionId.value = 'none';  // Reset the section selection

      // Showing the appropriate toast
      toast.add({
        title: selectedSectionId.value === 'none' ? 'Section Added' : 'Subsection Added',
        color: 'green',
        icon: 'i-heroicons-check-circle',
      });
    }
  } catch (error: unknown) {
    if (error instanceof Error) {
      toast.add({
        title: 'Error submitting form',
        description: error.message,
        color: 'red',
        icon: 'i-heroicons-x-circle',
      });
      console.error(error);
    } else {
      toast.add({
        title: 'Unknown Error',
        description: 'An unknown error occurred',
        color: 'red',
        icon: 'i-heroicons-x-circle',
      });
      console.error('Unknown error:', error);
    }
  }
}

async function fetchOffice() {
  if (!route.params.slug) return;

  try {
    const response = await $api.get('/offices/', { params: { code: route.params.slug } });
    office.value = response.data[0];

    if (office.value?.id) {
      fetchSection();
    }
  } catch (error) {
    console.error("Error fetching office:", error);
  }
}

async function fetchSection() {
  try {
    const response = await $api.get(`/sections/${office.value?.id}`);
    sections.value = response.data.data;
    section.value = sections.value.length ? sections.value[0] : null;
  } catch (error) {
    console.error("Error fetching section:", error);
  }
}

const sectionOptions = computed(() => {
  const defaultOption = { label: 'Select Office Section', value: 'none' };

  if (sections.value.length === 0) {
    return [defaultOption, { label: 'No section title yet', value: 'none', disabled: true}];
  }

  return [
    defaultOption,
    ...sections.value.map(s => ({
      label: s.title,
      value: s.id
    }))
  ];
});

const sectionLabel = computed(() => {
  return selectedSectionId.value !== 'none' ? 'Subsection' : 'Section';
});

const showDescriptionField = computed(() => {
  return selectedSectionId.value === 'none';
});

onMounted(() => {
  fetchOffice();
});

const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/add' },
  { label: 'About', to: '#about-documentation' }
];

const scrollToAbout = () => {
  if (aboutSection.value) {
    aboutSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

</script>

<template>
  <!-- Header -->
  <div class="flex flex-wrap items-center justify-between px-4 sm:grid sm:grid-cols-8 gap-4">
          <!-- Logo -->
          <div class="flex items-center min-w-60 ">
          <p class="text-2xl sm:text-3xl font-extrabold text-black font-Inter">Knowledge Base</p>
        </div>

           <!-- Spacing divs for layout balance (hidden on small screens) -->
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>
            <div class="hidden sm:block col-span-1 h-6.25"></div>

          <!-- Navigation -->
          <div class="w-full sm:w-auto col-span-3 flex justify-center sm:justify-end">
            <THorizontalNavigation :links="links"> <!-- Inayos-->
                <template #default="{ link }">
                  <a 
                    :href="link.to" 
                    @click.prevent="link.label === 'About' ? scrollToAbout() : null" 
                    class="text-lg mx-4 sm:mx-8 text-black font-Inter font-bold group-hover:text-primary relative"
                  >
                    {{ link.label }}
                  </a>
                </template>
            </THorizontalNavigation>
          </div>
        </div>

        <!-- Body -->
        <div class="m-2 grid gap-4 sm:grid-cols-4 p-4">
          <!-- Input Section -->
          <div class="col-span-1 min-h-[400px] w-full sm:w-[300px] p-4 border border-gray-300 rounded-lg">
            <p class="font-Inter font-bold text-lg text-black">INFORMATION</p>

          <div class="mt-2">
          <label class="font-Inter text-black mt-2">Office</label>
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
          <TForm :schema="schema" :validate="validate" :state="state" class="space-y-4" @submit="onSubmit">
          <TFormGroup class="font-Inter text-black mt-2" :label="sectionLabel" name="title">
            <TInput v-model="state.title" size="md" />
          </TFormGroup>
          <TFormGroup
            v-if="showDescriptionField"
            label="Short Description"
            name="description">
            <TInput v-model="state.description" size="md" />
          </TFormGroup>
            <div></div>
            <p class="font-Inter font-bold text-lg text-black mt-4">ADDITIONAL RESOURCES</p>
<div class="mt-2">
<label class="font-Inter text-black">Upload File</label>
<TInput type="file" size="md" class="w-full mt-1" />
</div>
<TButton class="mt-4" color="primary" variant="solid">Submit</TButton>
          </TForm>
              </div></div>
          <!-- Markdown Editor -->
          <div class="col-span-3 min-h-[500px] w-full border-4 rounded-lg border-black-500 p-4">
            <MarkdownEditor />
          </div>
      </div>
</template>
