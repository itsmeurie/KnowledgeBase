import permissions, { settings as settingsPerms } from "./permissions";

export * from "./settings";

/**
 * Note1: You can also set layout for page using `layout` property.
 * ex.: { path: '/', component: () => import('@/pages/index.vue'), layout: 'auth' }
 */

export default computed(() => [
  // Debug
  {
    children: [
      {
        path: "/offices",
        meta: {
          title: "office landing page",
          layout: "office",
          requiresAuth: true,
        },
        children: [
          {
            path: "/",
            name: "home-page",
            component: () => import("@/pages/playground.vue"),
            meta: {
              title: "Home Page",

              layout: "office",
            },
          },

          {
            path: "/:code/systems/",
            name: "system-sections",
            component: () => import("@/pages/offices/systemsections.vue"),
            permissions: permissions["system-sections"],
            meta: {
              title: "System Sections",

              layout: "office",
            },
          },
          {
            path: "/systems/:code/create",
            name: "create-article",
            component: () => import("@/pages/add.vue"),

            meta: {
              title: "Create Article",
              requiresAuth: true,
              layout: "office",
            },
          },
          {
            path: "/:code/systems/articlepage/:slug",
            name: "Article",
            component: () => import("@/pages/articlepage.vue"),
            permissions: permissions["manage-articles"],
            meta: {
              title: "Article",

              layout: "office",
            },
          },
          {
            path: "/:code/systems/restore",
            name: "Restore",
            component: () => import("~/pages/Restore.vue"),
            meta: {
              title: "Restore",

              layout: "office",
            },
          },
        ],
      },
    ],
  },
  // {
  //   path: "/",
  //   name: "home-page",
  //   component: () => import("@/pages/playground.vue"),
  //   meta: {
  //     title: "Home Page",

  //     layout: "office",
  //   },
  // },
  {
    path: "/settings",
    name: "settings",
    component: () => import("@/pages/settings/index.vue"),
    redirect: {
      name: "404",
    },
    meta: {
      requiresAuth: true,
      requiresVerified: true,
      permissions: Object.values(settingsPerms).flat(),
      title: "Settings",
      icon: "tabler:settings",
    },
    children: [
      {
        path: "accounts",
        name: "settings-accounts",
        component: () => import("@/pages/settings/accounts/index.vue"),
        meta: {
          title: "Account Management",
          permissions: permissions["settings-accounts"],
          icon: "tabler:users",
        },
      },
      {
        path: "roles",
        name: "settings-roles",
        component: () => import("@/pages/settings/roles/index.vue"),
        meta: {
          title: "User Roles",
          permissions: permissions["settings-roles"],
          icon: "tabler:lock",
        },
      },
      {
        path: "permissions",
        name: "settings-permissions",
        component: () => import("@/pages/settings/permissions/index.vue"),
        meta: {
          title: "Permissions",
          permissions: permissions["settings-permissions"],
          icon: "tabler:lock-access",
        },
      },
      {
        path: "syslogs",
        name: "settings-logs",
        component: () => import("@/pages/settings/syslogs/index.vue"),
        meta: {
          title: "System Logs",
          permissions: permissions["settings-logs"],
          icon: "tabler:terminal-2",
        },
      },
      {
        path: "/offices",
        name: "offices",
        component: () => import("@/pages/offices/index.vue"),
        meta: {
          title: "Offices",
          icon: "tabler:building",
        },
      },
      // {
      //   path: "system",
      //   name: "system-section",
      //   component: () => import("@/pages/offices/systemsections.vue"),
      //   permissions: permissions["system-sections"],
      //   meta: {
      //     title: "System Sections",
      //     icon: "tabler:building",
      //   },
      // },
    ],
  },

  {
    meta: { layout: "profile" },
    children: [
      {
        path: "/profile",
        name: "profile",
        component: () => import("@/pages/profile/index.vue"),
        meta: {
          requiresAuth: true,
          title: "Account",
          icon: "tabler:user",
        },
      },
    ],
  },
  {
    meta: { layout: "auth" },
    children: [
      {
        path: "/login",
        name: "login",
        component: () => import("@/pages/auth/login.vue"),
        meta: {
          title: "Authentication",
          requiresAuth: false,
        },
      },
      {
        path: "/password/forgot",
        name: "forgot-password",
        component: () => import("@/pages/auth/forgotPassword.vue"),
        meta: {
          title: "Forgot Password",
          requiresAuth: false,
        },
      },

      {
        path: "/email/verify/:id/:hash",
        name: "verify",
        component: () => import("@/pages/auth/verify.vue"),
        meta: {
          title: "Verify Email",
          requiresAuth: true,
          requiresVerified: false,
        },
      },

      {
        path: "/profile/update",
        name: "update-profile",
        component: () => import("@/pages/auth/updateProfile.vue"),
        meta: {
          title: "Update Profile",
          requiresAuth: true,
        },
      },
      {
        path: "/password/reset/:token",
        name: "reset-password",
        component: () => import("@/pages/auth/resetPassword.vue"),
        meta: {
          title: "Reset Password",
          requiresAuth: false,
        },
      },

      // Error Pages

      {
        path: "/unverified",
        name: "unverified",
        component: () => import("@/pages/error/unverified.vue"),
        meta: {
          title: "Unverified Account!",
          requiresAuth: true,
          requiresVerified: false,
        },
      },
      {
        path: "/unauthorized",
        name: "401",
        component: () => import("@/pages/error/401.vue"),
        meta: {
          title: "Unauthorized",
        },
      },
      {
        path: "/forbidden",
        name: "403",
        component: () => import("@/pages/error/403.vue"),
        meta: {
          title: "Forbidden",
        },
      },
      {
        path: "/:pathMatch(.*)*",
        name: "404",
        component: () => import("@/pages/error/404.vue"),
        meta: {
          title: "Page Not Found",
        },
      },
    ],
  },
]);
