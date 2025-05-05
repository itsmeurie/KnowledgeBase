import axios, { type AxiosInstance } from "axios";

export default defineNuxtPlugin(async (nuxtApp) => {
  const config = useRuntimeConfig();
  const csrfRetryCtr = ref(0);

  const shouldRetry = (error: any) => {
    return [419].includes(error.response.status) && csrfRetryCtr.value < 3;
  };

  const getCsrfToken = async (api: AxiosInstance) => {
    return new Promise((resolve, reject) => {
      api
        .get("/csrf-cookie")
        .then((res) => {
          resolve(res);
        })
        .catch((error) => {
          reject(error);
        });
    });
  };

  const api = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    headers: {
      Accept: "application/json",
      Authorization: null,
    },
    baseURL: config.public.baseUrl,
  });

  api.interceptors.request.use(
    async (config) => {
      // if (config.url == "/auth/login") {
      //   await getCsrfToken(api).catch((e) => e);
      // }
      return config;
    },
    (error) => Promise.reject(error),
  );

  api.interceptors.response.use(
    (response) => {
      csrfRetryCtr.value < 0;
      return Promise.resolve(response);
    },
    async (error) => {
      if (shouldRetry(error)) {
        await getCsrfToken(api);
        csrfRetryCtr.value++;
        return new Promise((resolve) => {
          resolve(axios(error.config));
        });
      }
      if (error.response.status === 401) {
        const $auth = useAuthStore();
        const { $router } = useNuxtApp();
        if ($auth.isLoggedIn) {
          $auth.reset();
        }

        if ($router.currentRoute.value.name !== "login") {
          $router.push({
            name: "login",
            query: { redirect: $router.currentRoute.value.fullPath },
          });
        }
      }

      if (!error.response?.data?.error_code) {
        const toast = useToast();
        toast.add({
          title: error.response?.data?.message ?? error.message,
          description: error.response ? error.message : null,
          color: "red",
          icon: "tabler:exclamation-circle",
        });
      }
      return Promise.reject(error);
    },
  );

  await getCsrfToken(api).catch((e) => e);

  return { provide: { api } };
});
