<template>
    <Navbar :cart-length="this.lengthOfCart" :username="getUsername"/>
    <h1 style="text-align: center;">Natijalar</h1>
    <div class="result">
        <ProductItem :product="product" v-for="product in getSearchData" :key="getSearchData.id" @add-to-cart="addToCart"/>
    </div>
</template>

<script>
import {useRoute} from "vue-router";
import Navbar from "../components/Navbar.vue";
import ProductItem from "../components/ProductItem.vue";
import {productsInCart, setProductsInCart} from "../data/productsInCart.js";

export default {
    name: "SearchPage",
    components: {Navbar, ProductItem},
    props: ['data'],

    data() {
        return {
            lengthOfCart: productsInCart.length,
        }
    },

    computed: {
        getSearchData() {
            const route = useRoute();
            return JSON.parse(route.params.data);
        },

        getUsername() {
            if(localStorage.getItem('loggedUser')) {
                return JSON.parse(localStorage.getItem('loggedUser')).name;
            }
        }
    },

    methods: {
        addToCart(product) {
            if (!productsInCart.find(p => p.id === product.id)) {
                productsInCart.push(product);
                productsInCart.find(p => p.id === product.id).quantity = 1;
            } else {
                setProductsInCart(productsInCart.map(p => {
                    if (p.id === product.id) {
                        p.quantity++;
                    }
                    return p;
                }));
            }
            this.lengthOfCart = productsInCart.length;
        }
    }
}
</script>

<style scoped>
.result {
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
</style>
