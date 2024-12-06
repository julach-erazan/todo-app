import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("../js/src/components/Dashboard.vue"),
    },
    {
        path: "/register",
        component: () => import("./src/components/Register.vue"),
    },
    {
        path: "/login",
        component: () => import("./src/components/Login.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});