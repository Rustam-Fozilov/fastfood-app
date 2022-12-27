import {createWebHistory, createRouter} from "vue-router";
import CartPage from "./pages/CartPage.vue";
import ProductPage from "./pages/ProductPage.vue";
import HomePage from "./pages/HomePage.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: HomePage,

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
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
