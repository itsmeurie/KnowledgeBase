export default defineNuxtPlugin(async () => {
  const tart = [
    " █████╗  ██████╗  █████╗ ██████╗ ",
    "██╔══██╗██╔════╝ ██╔══██╗██╔══██╗",
    "██║  ╚═╝██║  ██╗ ██║  ██║██████╦╝",
    "██║  ██╗██║  ╚██╗██║  ██║██╔══██╗",
    "╚█████╔╝╚██████╔╝╚█████╔╝██████╦╝",
    " ╚════╝  ╚═════╝  ╚════╝ ╚═════╝ ",
    "    City Government Of Baguio",
  ];
  console.log(tart.join("\n"));

  const auth = useAuthStore();
  const { $router } = useNuxtApp();

  if (auth.isLoggedIn) {
    await auth.getPermissions().catch((e) => e);
  }

  watch(
    () => auth.isLoggedIn,
    (val) => {
      let to = {};
      if (!val) {
        to = {
          name: "login",
          query: { redirect: $router.currentRoute.value.fullPath },
        };
      } else {
        to = $router.currentRoute.value.query?.redirect || {
          name: "home-page",
        };
      }
      $router.push(to);
    },
  );
});
