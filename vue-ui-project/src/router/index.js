import Vue from "vue";
import VueRouter from "vue-router";
import MainLayout from "@/layouts/MainLayout";
import store from "@/store";

Vue.use(VueRouter);

const routes = [
  {
    path: "/user/:id",
    name: "main-layout",
    component: MainLayout,
    children: [
      {
        path: "profile",
        name: "profile-view",
        component: () => import("@/views/ProfileView"),
        meta: { requiresAuth: true },
      },
      {
        path: "edit",
        name: "edit-profile-view",
        component: () => import("@/views/EditProfileView"),
        meta: { requiresAuth: true },
      },
      {
        path: "news",
        name: "news-view",
        component: () => import("@/views/NewsView/NewsView"),
        meta: { requiresAuth: true },
      },
      {
        path: "members",
        name: "members-view",
        component: () => import("@/views/MemberView/MembersView"),
        meta: { requiresAuth: true },
      },
    ],
  },
  {
    path: "/",
    name: "auth-layout",
    component: () => import("@/layouts/AuthLayout"),
    children: [
      {
        path: "login",
        name: "login-view",
        alias: "/",
        component: () => import("@/views/LoginView"),
      },
      {
        path: "registration",
        name: "registration-view",
        component: () => import("@/views/RegistrationView"),
      },
      {
        path: "forgotten-password",
        name: "forgotten-pass-view",
        component: () => import("@/views/ForgottenPassView"),
      },
      {
        path: "reset-password/:token",
        name: "reset-password-view",
        component: () => import("@/views/ResetPasswordView"),
      },
    ],
  },
  {
    path: "*",
    name: "page-not-found",
    component: () => import("@/views/PageNotFoundView"),
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach(async (to, from, next) => {
  if (!to.meta.requiresAuth) {
    next();
    return;
  }

  if (!store.state.loggedUser) {
    try {
      await store.dispatch("setLoggedUser");
      next();
      return;
    } catch (error) {
      next({ name: "login-view" });
      return;
    }
  }

  next();
});

export default router;
