<script setup lang="ts">
import ProfileEditor from "~/components/userEditor/profile/index.vue";
import type { User } from "~/types/models/users";

const auth = useAuthStore();
const router = useRouter();
const route = useRoute();
const editor = ref();

const redirect = () => {
  if (auth.hasProfileName) {
    router.push((route.query.redirect as string) ?? { name: "home-page" });
  }
};

watch(
  () => auth.hasProfileName,
  (val) => {
    if (val) {
      redirect();
    }
  },
  {
    immediate: true,
  },
);

onBeforeMount(() => redirect());
</script>

<template>
  <TCard
    :ui="{
      divide: 'divide-y divide-gray-200 dark:divide-gray-600',
      header: {
        padding: 'px-3 py-2',
      },
      body: {
        base: 'flex flex-col gap-5',
        padding: 'px-3 py-2',
      },
    }"
  >
    <template #header>
      <TTypography> Your profile information needs to be updated. </TTypography>
    </template>
    <ProfileEditor
      ref="editor"
      @update:user="auth.setUser($event!)"
      api="/auth/profile-update"
    />
    <div class="flex items-center gap-2">
      <TButton
        label="Save"
        type="submit"
        @click="editor?.save()"
        :ui="{
          base: 'flex-auto justify-center',
        }"
      />
      <TButton
        label="Logout"
        icon="tabler:logout"
        variant="ghost"
        @click="auth.logout()"
      />
    </div>
  </TCard>
</template>
