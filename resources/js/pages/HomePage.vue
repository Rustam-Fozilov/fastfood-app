<template>
    <div class="container">
        <Navbar :cart-length="cartLength"/>

        <div class="banner">
            <img src="assets/home/banner.png" alt="banner">
        </div>

        <ProductsList @add-to-cart="addToCart"/>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue'
import ProductsList from "../components/ProductList.vue";
import {productsInCart, setProductsInCart} from "../data/productsInCart.js";

export default {
    name: 'App',
    emits: ['add-to-cart'],
    components: {
        Navbar,
        ProductsList,
    },

    data() {
        return {
            products: [],
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
            console.log(productsInCart);
        }
    },

    computed: {
        cartLength() {
            return productsInCart.length;
        }
    },
}
</script>

<style>
@font-face {
    font-family: 'Inter-Regular';
    src: url('assets/fonts/Inter-Regular.ttf');
}

html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    font-family: Inter-Regular;
}

a {
    text-decoration: none;
    color: black;
}

.container {
    margin: 0 auto;
    width: 1260px;
}

.banner img {
    width: 100%;
    margin-top: 20px;
}
</style>
