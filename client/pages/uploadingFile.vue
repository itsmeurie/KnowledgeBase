<script setup lang="ts">
import { z } from "zod";
import type { Form, FormSubmitEvent } from "#ui/types";
import type { Section, Office } from "~/types";

const { api } = useNuxtApp();
const emit = defineEmits(["close", "upload"]);
const toast = useToast();
const loading = ref(false);
const loadingMessage = ref("");

const fileSection = defineModel<Section>();
const props = defineProps<{
  modelValue: Section;
}>();

const schema = z.object({
  files: z.array(z.string()).min(1, { message: "File is required" }),
});

type Schema = z.output<typeof schema>;
const form = ref<Form<Schema>>();

const state = ref<{
  files?: Object;
}>({
  files: [],
});

const { files, uploading, addFile, removeFile, upload, fileBrowser } =
  useUploader(
    computed(() => {
      return {
        api: fileSection.value
          ? `/sections/file/upload/${props.modelValue.id}`
          : "",
        multiple: true,
      };
    }),
  );

const browser = fileBrowser();

const saveFile = async (e: FormSubmitEvent<Schema>) => {
  return new Promise((resolve, reject) => {
    loading.value = true;
    loadingMessage.value = "Uploading File...";

    upload()
      .then((response) => {
        toast.add({
          title: "Success",
          description: "File uploaded successfully",
          color: "primary",
          icon: "tabler:check",
        });
        emit("upload", response?.[0]?.data.data);
        resolve(response);
      })
      .catch((error) => {
        reject(error);
      })
      .finally(() => {
        loading.value = false;
      });
  });
};
</script>

<template>
  <div>
    <TCard class="space-y-6 p-6">
      <!-- Close Button Top Right -->
      <div class="flex justify-end">
        <TButton
          icon="tabler:x"
          variant="ghost"
          @click="emit('close')"
          class="!p-2"
        />
      </div>

      <!-- Upload Form -->
      <TForm
        :schema
        :state
        :validateOn="['submit']"
        ref="form"
        @submit="saveFile"
        class="space-y-4"
      >
        <TFormGroup>
          <div>
            <h2 class="mb-2 text-xl font-semibold">Upload File</h2>

            <!-- File Upload Button -->
            <TButton
              label="Choose Files"
              @click="browser?.open()"
              class="mb-4"
            />

            <!-- Uploaded Files List -->
            <div class="space-y-2">
              <template v-for="file in files" :key="file.id">
                <TFileUploadItem :file="file" />
              </template>
            </div>
          </div>
        </TFormGroup>

        <!-- Loading State -->
        <TInnerLoading :active="loading" :text="loadingMessage" />

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-2">
          <TButton label="Cancel" variant="ghost" @click="emit('close')" />
          <TButton label="Save" @click="saveFile" />
        </div>
      </TForm>
    </TCard>
  </div>
</template>
