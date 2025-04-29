<script setup lang="ts">
import avatarOptions from "../default/config/avatarOptions";
import aMenus from "../default/config/avatarOptions";
const aboutSection = ref<HTMLElement | null>(null);
import { useRouter } from "vue-router";
import type { Office } from "~/types";
const router = useRouter();
const offices = ref<Office>();

const { office } = useAuthStore();

function goToSystemSection(code: string) {
  router.push({
    name: "system-sections",
    params: {
      code: office?.code?.toLowerCase(),
      slug: code.toLowerCase(),
    },
  });
}
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
            class="font-Inter ml-2 hidden text-2xl font-extrabold sm:block sm:text-3xl"
          >
            Knowledge Base
          </p>
        </div>

        <div class="flex flex-auto items-center justify-end gap-2">
          <TButton
            label="Home"
            icon="tabler:home"
            :to="{ name: 'home-page' }"
            class="flex sm:inline-flex"
          >
            <span class="hidden sm:inline">Home</span>
          </TButton>
          <TButton
            label="Docs"
            icon="tabler:book-2"
            @click="goToSystemSection(office?.code!)"
            class="flex sm:inline-flex"
          >
            <span class="hidden sm:inline">Docs</span>
          </TButton>
        </div>
      </TopNav>
      <!-- Top Bar -->
      <slot />
    </LayoutBody>
  </Layout>
</template>
