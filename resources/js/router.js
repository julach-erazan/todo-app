import { createRouter, createWebHistory } from "vue-router";
import Login from "../js/src/components/Login.vue";
import Register from "../js/src/components/Register.vue";
import Dashboard from "../js/src/components/Dashboard.vue";

const routes = [
  { path: "/login", name: "Login", component: Login },
  { path: "/register", name: "Register", component: Register },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  { path: "/", redirect: "/login" },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem("isLoggedIn");
  if (to.matched.some((record) => record.meta.requiresAuth) && !isLoggedIn) {
    next("/login");
  } else {
    next();
  }
});

export default router;
