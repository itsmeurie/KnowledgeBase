<script setup lang="ts">
import type { Team } from "~/types/models/team";

const config = useAppConfig();
const { $api } = useNuxtApp();
const user = useAuthStore();

const loading = ref<boolean>(false);
const teams = ref<Array<Team>>([]);

const searchTeams = async (search: string) => {
  loading.value = true;
  const response = await $api.get("/auth/teams", { params: { search } });
  loading.value = false;
  teams.value = response.data.data;
  return response.data.data;
};

const onChange = (team: Team) => {
  loading.value = true;
  user.switchTeam(team).finally(() => {
    loading.value = false;
  });
};
</script>

<template>
  <TSelectMenu
    v-if="user.canSwitchTeam"
    :modelValue="user.team"
    :searchable="searchTeams"
    :debounce="250"
    :loading
    :options="teams"
    by="id"
    optionAttribute="name"
    searchable-placeholder="Search team..."
    placeholder="Select Team"
    class="w-full max-w-64"
    @update:modelValue="onChange"
    :uiMenu="{ option: { selected: 'bg-gray-200 dark:bg-gray-800' } }"
  >
    <template #default="{ open }">
      <TTooltip
        :text="user.team?.name"
        :openDelay="500"
        :ui="{ wrapper: 'flex-auto', width: '' }"
      >
        <TButton
          :label="user.team?.name"
          variant="outline"
          color="gray"
          truncate
          :ui="{ base: 'w-full', truncate: 'flex-auto' }"
        >
          <template #trailing>
            <TIcon
              :name="
                loading
                  ? config.ui.table.default.loadingState.icon
                  : config.ui.select.default.trailingIcon
              "
              class="min-h-5 min-w-5 transition-transform"
              :class="{ 'animate-spin': loading, '-rotate-90': !open }"
            />
          </template>
        </TButton>
      </TTooltip>
    </template>

    <template #option="{ option }">
      <TTooltip
        :text="option.name"
        :openDelay="500"
        :ui="{ wrapper: 'flex-auto', width: '' }"
      >
        <span class="truncate">
          {{ option.name }}
        </span>
      </TTooltip>
    </template>
  </TSelectMenu>
</template>
