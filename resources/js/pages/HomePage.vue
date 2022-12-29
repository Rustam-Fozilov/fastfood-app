<template>
        <Navbar :cart-length="lengthOfCart"/>

        <div class="banner">
            <img src="assets/home/banner.png" alt="banner">
        </div>

        <ProductList @add-to-cart="addToCart"/>
</template>

<script>
import Navbar from '../components/Navbar.vue'
import ProductList from "../components/ProductList.vue";
import {productsInCart, setProductsInCart} from "../data/productsInCart.js";

export default {
    name: 'App',
    emits: ['add-to-cart'],
    components: {
        Navbar,
        ProductList,
    },

    data() {
        return {
            lengthOfCart: productsInCart.length,
        }
    },

    methods: {
        addToCart(product) {
            if(!productsInCart.find(p => p.id === product.id)) {
                productsInCart.push(product);
                productsInCart.find(p => p.id === product.id).quantity = 1;
            } else {
                setProductsInCart(productsInCart.map(p => {
                    if(p.id === product.id) {
                        p.quantity++;
                    }
                    return p;
                }));
            }
            this.lengthOfCart = productsInCart.length;
            console.log(productsInCart);
        }
    },
}
</script>

<style>
.banner img {
    width: 100%;
    margin-top: 20px;
}
</style>
