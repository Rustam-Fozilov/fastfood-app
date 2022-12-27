<template>
    <h1>Cart page</h1>
    <ul>
        <li v-for="product in products">{{ product }}</li>
    </ul>
</template>

<script>
import {productsInCart} from "../data/productsInCart.js";
export default {
    name: "CartPage",
    data() {
        return {
            products: [],
        }
    },

    created() {
        this.products = productsInCart;
    }
}
</script>

<style scoped>

</style>
