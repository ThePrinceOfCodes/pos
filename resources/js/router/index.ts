import { createRouter, createWebHistory, createWebHashHistory } from "vue-router";
import Login from "../Views/Pages/Login.vue";

const routes = [
  {
    path: "/",
    name: "Workspace",
    component: () => import("../Views/Pages/Workspace/Workspace.vue"),
    beforeEnter: (to: any, from: any, next: any) => {
      const token = localStorage.getItem("token");
      if (!token) next({ name: "Login" });
      else next();
    },
  },
  {
    path: "/sales",
    name: "Sales",
    component: () => import("../Views/Pages/Sales.vue"),
    beforeEnter: (to: any, from: any, next: any) => {
      const token = localStorage.getItem("token");
      if (!token) next({ name: "Login" });
      else next();
    },
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
];

const router = createRouter({
  history: createWebHistory('/cashier/'),
  routes,
});

export default router;
