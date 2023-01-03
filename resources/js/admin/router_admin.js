import {createWebHistory, createRouter} from "vue-router";
import LoginPage from "./pages/LoginPage.vue";
import AppAdmin from "./AppAdmin.vue";
import Dashboard from "./pages/DashboardPage.vue";
import Products from "./pages/ProductsPage.vue";
import UsersPage from "./pages/UsersPage.vue";
import OrdersPage from "./pages/OrdersPage.vue";

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
    },
    {
        path: "/products",
        name: "Products",
        component: Products,
    },
    {
        path: "/users",
        name: "Users",
        component: UsersPage,
    },
    {
        path: "/orders",
        name: "Orders",
        component: OrdersPage,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
