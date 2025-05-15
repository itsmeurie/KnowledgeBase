<script setup lang="ts">
import avatarOptions from "../default/config/avatarOptions";
import type { Section } from "~/types";
import aMenus from "../default/config/avatarOptions";
const aboutSection = ref<HTMLElement | null>(null);
import { useRouter } from "vue-router";
import type { Office } from "~/types";
const router = useRouter();
const offices = ref<Office>();
const officeSection = ref<Section[]>([]);
const { office } = useAuthStore();
const { $api } = useNuxtApp();

function goToSystemSection(code: string) {
  router.push({
    name: "system-sections",
    params: {
      code: office?.code?.toLowerCase(),
    },
  });
}

async function fetchOfficeSectionList() {
  if (!office?.id) return;
  try {
    const response = await $api.get(`/sections/office`);
    officeSection.value = response.data.data;
  } catch (error) {
    console.error("Error fetching sections:", error);
  }
}

useTeams(() => {
  fetchOfficeSectionList();
});
</script>

<template>
  <Layout>
    <LayoutBody>
      <TopNav fixed :avatarOptions="aMenus">
        <div class="mr-4 flex items-center">
          <img
            class="mt-6 h-20 w-20 gap-5 object-contain"
            src="@/assets/image/final-logo.png"
          />
          <p
            class="font-Inter ml-2 text-2xl font-extrabold sm:block sm:text-3xl"
          >
            Knowledge Base
          </p>
        </div>

        <div class="flex flex-auto items-center justify-end gap-2">
          <TTeamSelect />
          <TButton
            label="Home"
            icon="tabler:home"
            :to="{ name: 'home-page' }"
            class="flex sm:inline-flex"
          >
            <span class="sm:inline">Home</span>
          </TButton>
          <TButton
            label="Docs"
            icon="tabler:book-2"
            @click="goToSystemSection(office?.code!)"
            class="flex sm:inline-flex"
          >
            <span class="sm:inline">Docs</span>
          </TButton>
        </div>
      </TopNav>
      <!-- Top Bar -->
      <slot />
    </LayoutBody>
  </Layout>
</template>
