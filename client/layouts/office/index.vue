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
// const linksNav = ref([
//   { label: "Home", to: { name: "home-page" } },
//   { label: "Docs", to: { name: "offices" } },
//   { label: "About", to: { name: "offices" } },
// ]);
</script>

<template>
  <Layout>
    <LayoutBody>
      <TopNav fixed :avatarOptions="aMenus">
        <div class="flex items-center">
          <img
            class="mt-6 h-20 w-20 object-contain"
            src="@/assets/image/final-logo.png"
          />
          <p class="font-Inter text-2xl font-extrabold sm:text-3xl">
            Knowledge Base
          </p>
        </div>

        <div class="flex flex-auto items-center justify-end gap-2">
          <TButton
            label="Home"
            icon="tabler:home"
            :to="{ name: 'home-page' }"
          />
          <TButton
            label="Docs"
            icon="tabler:book-2"
            @click="goToSystemSection(office?.code!)"
          />
        </div>
      </TopNav>
      <!-- Top Bar -->
      <slot />
    </LayoutBody>
  </Layout>
</template>
