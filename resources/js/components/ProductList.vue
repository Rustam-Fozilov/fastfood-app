<template>
    <p class="product-list__title">Burgers</p>
    <div class="product-list">
        <ProductItem v-for="product in products" :key="product.id" :product="product" @add-to-cart="addToCart"/>
    </div>
</template>

<script>
import axios from "axios";
import ProductItem from "./ProductItem.vue";

export default {
    name: "ProductList",
    components: {
        ProductItem
    },
    emits: ['add-to-cart'],
    data() {
        return {
            products: [],
        }
    },

    created() {
        axios
            .get('http://localhost:8000/api/products/')
            .then(response => (this.products = response.data))
            .catch(error => console.log(error));

    },

    methods: {
        addToCart(product) {
            this.$emit('add-to-cart', product);
        }
    }
}
</script>

<style scoped>
    .product-list {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .product-list__title {
        font-size: 24px;
        font-weight: bold;
        margin-top: 50px;
    }
</style>
