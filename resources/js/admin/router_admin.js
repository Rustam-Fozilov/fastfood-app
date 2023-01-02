import {createWebHistory, createRouter} from "vue-router";
import LoginPage from "./pages/LoginPage.vue";
import AppAdmin from "./AppAdmin.vue";
import Dashboard from "./pages/DashboardPage.vue";

const routes = [
    {
      path: '/',
      name: 'Main',
      component: AppAdmin,
    },
    {
        path: "/login",
        name: "Login",
        component: LoginPage,
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
