<script setup lang="ts">
import { z } from "zod";
import type { FormSubmitEvent } from "#ui/types";

const { $router } = useNuxtApp();
const $route = useRoute();
const auth = useAuthStore();
const { passwordRules, strength } = usePassword();

const passwordError = "Invalid password format";
const schema = z.object({
  email: z
    .string({
      message: "Username/Email is required",
    })
    .min(1, { message: "Username/Email is required" }),
  password: passwordRules({
    min: "Password is Required",
    max: passwordError,
    numbers: passwordError,
    symbols: passwordError,
    letters: passwordError,
    mixedCase: passwordError,
  }),
});

type Schema = z.output<typeof schema>;

const state = reactive({
  email: "",
  password: "",
  remember: false,
});
const showPassword = ref(false);
const loading = ref(false);
const loadingMessage = ref("");

const login = async (e: FormSubmitEvent<Schema>) => {
  return new Promise((resolve, reject) => {
    loading.value = true;
    showPassword.value = false;
    loadingMessage.value = "Logging in...";
    auth
      .login(e.data)
      .then((res) => {
        $router.push(($route.query.redirect as string) || { name: "home" });
        resolve(res);
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
  <TCard
    class="w-screen-95 max-w-md select-none shadow-lg"
    :ui="{
      body: {
        base: 'flex flex-col gap-5 ',
        padding: 'sm:px-8 sm:py-12',
      },
    }"
  >
    <div class="flex flex-col items-center gap-4">
      <div class="relative aspect-square h-20 w-20">
        <img
          src="/favicons/baguioseal.svg"
          class="absolute inset-0"
          :class="{ 'animate-ping': loading }"
        />
        <img src="/favicons/baguioseal.svg" class="absolute inset-0" />
      </div>
      <span class="text-2xl">{{ $config.public.product_name }}</span>
    </div>
    <TForm
      :schema="schema"
      :state="state"
      :validateOn="['submit']"
      class="flex flex-col gap-5"
      @submit="login"
    >
      <TFormGroup label="Username / Email" name="email" required>
        <TInput
          v-model="state.email"
          placeholder="example@email.com"
          color="gray"
          size="md"
          :disabled="loading"
        />
      </TFormGroup>

      <TFormGroup label="Password" name="password" required>
        <template #hint>
          <div
            v-if="
              strength(state.password).score > 0 || state.password.length > 0
            "
            class="flex items-center gap-1 text-xs"
          >
            <TIcon
              name="tabler:circle-filled"
              :style="{
                color: strength(state.password).color,
              }"
            />
            {{ strength(state.password).complexity }}
          </div>
        </template>
        <TInput
          v-model="state.password"
          color="gray"
          size="md"
          :disabled="loading"
          :type="showPassword ? 'text' : 'password'"
          :ui="{ icon: { trailing: { pointer: '' } } }"
        >
          <template #trailing>
            <TButton
              square
              icon="tabler:eye"
              variant="link"
              color="primary"
              :disabled="loading"
              :class="{
                'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200':
                  !showPassword,
              }"
              @click="showPassword = !showPassword"
            />
          </template>
        </TInput>
      </TFormGroup>

      <div class="flex items-center justify-between gap-2">
        <TCheckbox
          label="Remember me"
          name="remember"
          :disabled="loading"
          v-model="state.remember"
        />
        <TButton
          variant="link"
          :disabled="loading"
          :to="{ name: 'forgot-password' }"
        >
          Forgot Password?
        </TButton>
      </div>
      <TButton label="Sign in" block type="submit" :loading="loading" />
    </TForm>
  </TCard>
</template>
