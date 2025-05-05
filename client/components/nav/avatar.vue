<script setup lang="ts">
import type { AvatarOptions } from "~/types";

const props = defineProps<{ menus?: AvatarOptions[] }>();

const $auth = useAuthStore();

const signingOut = ref(false);

const hasName = computed(
  () => $auth.profile?.first_name && $auth.profile?.last_name,
);
const profile_name = computed(() => {
  if (hasName.value) {
    let first = $auth.profile?.first_name?.split(" ")[0];
    return `${first} ${$auth.profile?.last_name}`;
  } else {
    return $auth.username;
  }
});

const profile_name_short = computed(() => {
  if (hasName.value) {
    let first = $auth.profile?.first_name?.split(" ")[0];
    return `${first?.[0]}${$auth.profile?.last_name?.[0]}`;
  } else {
    return $auth.username?.[0];
  }
});

const avatar = computed(() => $auth.profile?.images?.find((i) => i.primary));

const _menus = computed<AvatarOptions[]>(
  () => props.menus?.filter((m) => toValue(m.hidden) !== true) || [],
);

const logout = () => {
  signingOut.value = true;
  $auth.logout().finally(() => {
    signingOut.value = false;
  });
};
</script>
<template>
  <TPopover
    :popper="{ placement: 'bottom-end' }"
    :ui="{ wrapper: 'flex items-center', width: 'w-screen-95 max-w-48' }"
  >
    <TButton
      variant="ghost"
      color="gray"
      size="lg"
      square
      class="seelct-none p-0"
      :ui="{ rounded: 'rounded-full' }"
    >
      <TAvatar
        :text="profile_name_short"
        :src="avatar?.url.md"
        icon="tabler:user-filled"
        size="lg"
        class="bg-gray-200 dark:bg-gray-600"
      />
    </TButton>
    <template #panel="{ close }">
      <template v-if="$auth.isLoggedIn">
        <div class="flex items-center gap-2 p-4">
          <TAvatar
            :text="profile_name_short"
            :src="avatar?.url.md"
            icon="tabler:user-filled"
            size="lg"
            class="bg-gray-200 dark:bg-gray-600"
          />
          <span class="leading-8">
            {{ profile_name }}
          </span>
        </div>
        <TDivider
          :ui="{
            border: {
              base: 'border-gray-200 dark:border-gray-600',
            },
          }"
        />
      </template>
      <template v-if="_menus?.length! > 0">
        <div class="flex flex-col gap-2 p-2">
          <template v-for="menu in _menus" :key="menu">
            <template v-if="menu.divider">
              <TDivider
                :ui="{
                  border: {
                    base: 'border-gray-200 dark:border-gray-600',
                  },
                }"
              />
            </template>
            <TButton
              v-else-if="Object.values(menu).some((v) => !!v)"
              :icon="menu.icon"
              :label="menu.label"
              :to="menu.to"
              color="white"
              size="md"
              variant="ghost"
              @click="(menu.action?.(), close())"
            />
          </template>
        </div>
        <TDivider
          :ui="{
            border: {
              base: 'border-gray-200 dark:border-gray-600',
            },
          }"
        />
      </template>
      <div class="flex flex-col gap-2 p-2">
        <TButton
          v-if="$auth.isLoggedIn"
          icon="tabler:logout"
          color="white"
          label="Logout"
          size="md"
          variant="ghost"
          :loading="signingOut"
          @click="(logout(), close())"
        />
        <TButton
          v-else
          icon="tabler:login"
          color="white"
          label="Login"
          size="md"
          variant="ghost"
          :to="{
            name: 'login',
          }"
        />
      </div>

      <TDivider
        :ui="{
          border: {
            base: 'border-gray-200 dark:border-gray-600',
          },
        }"
      />
      <TTooltip
        v-if="$auth.hasTeam"
        :text="$auth.team?.name"
        :openDelay="500"
        class="w-full px-3 text-xs"
      >
        <span class="mx-auto truncate">
          {{ $auth.team?.name }}
        </span>
      </TTooltip>
    </template>
  </TPopover>
</template>
