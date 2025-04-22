<script setup lang="ts">
import avatarOptions from "../default/config/avatarOptions";

const aboutSection = ref<HTMLElement | null>(null);

const linksNav = ref([
  { label: "Home", to: { name: "home-page" } },
  { label: "Docs", to: { name: "offices" } },
  { label: "About", to: { name: "offices" } },
]);

</script>

<template>
  <Layout>
    <LayoutBody>
      <TopNav fixed>
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
            :to="{ name: 'offices' }"
          />
        </div>
      </TopNav>
      <!-- Top Bar -->
      <slot />
    </LayoutBody>
  </Layout>
</template>
