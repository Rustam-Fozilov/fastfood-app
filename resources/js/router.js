import {createWebHistory, createRouter} from "vue-router";
import CartPage from "./pages/CartPage.vue";
import ProductPage from "./pages/ProductPage.vue";
import HomePage from "./pages/HomePage.vue";
import LoginPage from "./pages/LoginPage.vue";
import RegisterPage from "./pages/RegisterPage.vue";
import ProfilePage from "./pages/ProfilePage.vue";
import SearchPage from "./pages/SearchPage.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: HomePage,
        props: true
    },
    {
        path: "/cart",
        name: "Cart",
        component: CartPage,
    },
    {
        path: "/product/:id",
        name: "Product",
        component: ProductPage,
        props: true,
    },
    {
        path: "/login",
        name: "Login",
        component: LoginPage,
    },
    {
        path: "/register",
        name: "Register",
        component: RegisterPage,
    },
    {
        path: "/profile",
        name: "Profile",
        component: ProfilePage,
    },
    {
        path: "/search/:data",
        name: "Search",
        component: SearchPage,
        props: true,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
