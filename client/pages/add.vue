<script setup lang="ts">
import MarkdownEditor from '@/pages/markdowneditor.vue'
import { ref } from 'vue';
import type { Section, Office } from '~/types';
import type { FormError, FormSubmitEvent } from '#ui/types'
import { z } from 'zod'

const office = ref<Office>();
const section = ref<Section | null>(null); 

const router = useRouter();
const { $api } = useNuxtApp();
const route = useRoute();

const emit = defineEmits(['update:show'])

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
  title: undefined,
  description: undefined
})


async function onSubmit(event: FormSubmitEvent<Schema>) {
  // Do something with data
  console.log(event.data)
  $api.post('/sections', {
          office_id: office.value?.id,
          ...event.data
        })
        .then((response) => {
            if(response.status == 200)
                emit('update:show', false)
        })
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
    const sections = response.data;

    section.value = sections.length ? sections[0] : null;
  } catch (error) {
    console.error("Error fetching section:", error);
  }
}


onMounted(() => {
  fetchOffice();
});

const links = [
  { label: 'Home', to: '/playground' },
  { label: 'Docs', to: '/add' },
  { label: 'About', to: '#about-documentation' }
];

const aboutSection = ref<HTMLElement | null>(null);

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
      <label class="font-Inter text-black">Office</label>
      <TInput disabled size="md" :model-value="office?.name" />
      </div>

      <div class="mt-2">
        <TForm :schema="schema" :validate="validate" :state="state" class="space-y-4" @submit="onSubmit">
                    <TFormGroup class="font-Inter text-black mt-2" label="Section" name="title">
                        <TInput v-model="state.title" size="md"/>
                    </TFormGroup>
                    <TFormGroup label="Short Description" name="description">
                        <TInput v-model="state.description" size="md"/>
                    </TFormGroup>
                    <div></div>
                    <TButton type="submit">
                        Submit
                    </TButton>
                </TForm>
              </div>
    </div>
    
    <!-- Markdown Editor -->
    <div class="col-span-3 min-h-[500px] w-full border-4 rounded-lg border-black-500 p-4">
      <MarkdownEditor />
    </div>
  </div>
</template>
