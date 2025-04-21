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
        path: "/playground",
        name: "playground",
        component: () => import('@/pages/playground.vue'),
         
        meta: {
          
          title: "Playground",

          layout: 'public'
          
        },
      },
      {
        path: "/offices/:slug",
        name: "systemsections",
        component: () => import('@/pages/offices/systemsections.vue'),
         
        meta: {
          
          title: "System Sections",

          layout: 'public'
          
        },
      },
      // {
      //   path: "/add",
      //   name: "add",
      //   component: () => import('@/pages/add.vue'),
      //   path: "/systemsections",
      //   name: "systemsections",
      //   component: () => import('@/pages/offices/systemsections.vue'),
         
      //   meta: {
          
      //     title: "System Sections",

      //     layout: 'public'
          
      //   },
      // },
      {
        path: "/offices/:slug/add",
        name: "add",
        component: () => import('@/pages/add.vue'),
         
        meta: {
          
          title: "Create Article",

          layout: 'public'
          
        },
      },
      
      {
        path: "/edit-article",
        name: "edit-article",
        component: () => import('~/pages/edit.vue'),
         
        meta: {
          
          title: "edit-article",

          layout: 'public'
          
        },
      },

      {
        path: "/systemsections",
        name: "systemsections1",
        component: () => import('~/pages/offices/systemsections.vue'),
         
        meta: {
          
          title: "System Sections",

          layout: 'public'
          
        },
      },

      {
        path: "/offices",
        meta: {
          title: 'office landing page',
          layout: 'office'
        },
        children: [
          {
            path: "",
            component: () => import('@/pages/offices/index.vue')
          },
          {
            path: "articles",
            component: () => import('@/pages/offices/articles.vue')
          },
          {
            path: "system/sections",
            component: () => import('@/pages/offices/systemsections.vue')
          },
          {
            path: "articles",
            component: () => import('@/pages/offices/articles.vue')
          },
          {
            path: "articles/add",
            meta: {
              title: 'Create new Article',
            },
            component: () => import('~/pages/add.vue')
          },
        ]
      },
      


      {
        path: "/why",
        name: "why",
        component: () => import('@/pages/CEDULA/why.vue'),
         
       meta: {
          
          title: "why",

         layout: 'public'
          
        },
      },

      {
        path: "/where",
        name: "where",
        component: () => import('@/pages/CEDULA/where.vue'),
        meta: {
          
          title: "where",

          layout: 'public'
          
        },
      },

      {
        path: "/how",
        name: "how",
        component: () => import('@/pages/CEDULA/how.vue'),
         
        meta: {
          
          title: "how",

          layout: 'public'
          
        },
      },


      {
        path: '/offices/:code/articlepage/:slug',
        name: "Article",
        component: () => import('@/pages/articlepage.vue'),
         
        meta: {
          
          title: "Article",

          layout: 'public'
          
        },
      },

			{
				path: "/tickets",
				name: "tickets-index",
				component: () => import("@/pages/tickets/index.vue"),
				meta: {
					title: "Tickets: Index",
				},

			},
			{
				path: "/tickets/view/:id?",
				name: "tickets-view",
				component: () => import("@/pages/tickets/view.vue"),
				meta: {
					title: "Tickets: View",
				},
			},
		],
	},
   {
				path: "/violations",
				name: "violations-index",
				component: () => import("@/pages/violations/index.vue"),
				meta: {
					title: "Violations: Index",
				},
			},

      {
				path: "/violations/view/:id?",
				name: "violations-view",
				component: () => import("~/pages/violations/view.vue"),
				meta: {
					title: "Violations: View",
				},
			},

      {
				path: "/violations/archived",
				name: "violations-archived",
				component: () => import("~/pages/violations/index-archived.vue"),
				meta: {
					title: "Violations: Index",
				},
			},

      {
				path: "/violations/archived/view/:id?",
				name: "violations-view-archived",
				component: () => import("~/pages/violations/view-archived.vue"),
				meta: {
					title: "Violations: View Archived",
				},
			},

  {
    children: [
      {
        path: "/violators",
        name: "violators-index",
        component: () => import("@/pages/violators/index.vue"),
        meta: {
          title: "Violators: Index",
        },
      },
      {
        path: "/violators/view/:id?",
        name: "violators-view",
        component: () => import("@/pages/violators/view.vue"),
        meta: {
          title: "Violators: Index",
        },
      },
      {
        path: "/violators/trashed",
        name: "violators-bin",
        component: () => import("@/pages/violators/trashed.vue"),
        meta: {
          title: "Violators: Bin",
        },
      },
    ],
  },
  {
    path: "/t",
    name: "tests",
    component: () => import("@/pages/_tests/index.vue"),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: "/",
    name: "home",
    component: () => import("@/pages/index.vue"),
    meta: {
      requiresAuth: true,
    },
    children: [],
  },
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


// <!-- <div class="mt-2">
// <label class="font-Inter text-black">Section</label>
// <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
// </div>
// <div class="mt-2">
// <label class="font-Inter text-black">Short Description</label>
// <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
// </div>

// <p class="font-Inter font-bold text-lg text-black mt-4">ADDITIONAL RESOURCES</p>
// <div class="mt-2">
// <label class="font-Inter text-black">Upload File</label>
// <TInput type="file" size="md" class="w-full mt-1" />
// </div>
// <div class="mt-2">
// <label class="font-Inter text-black">Description</label>
// <TInput size="md" placeholder="Enter here..." class="w-full mt-1" />
// </div>
// <TButton class="mt-4" color="primary" variant="solid">Submit</TButton> -->
