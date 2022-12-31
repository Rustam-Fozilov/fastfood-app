<template>
    <Navbar :cart-length="lengthOfCart" :username="getUsername"/>
    <div class="product-container">
        <div class="product-container__image">
            <img src="http://127.0.0.1:8000/assets/products/burger.png" alt="product image">
        </div>
        <div class="product-container__info">
            <p class="product-container__title">{{product.name}}</p>
            <p class="product-container__description">Izoh: {{product.description}}</p>
            <p class="product-container__price">{{product.price}} so'm</p>
            <button class="btn" @click="addToCart">SAVATGA</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
import {productsInCart, setProductsInCart} from "../data/productsInCart.js";

export default {
    name: "ProductPage",
    props: ['id'],
    components: {
        Navbar
    },

    data() {
        return {
            product: [],
            lengthOfCart: productsInCart.length,
        }
    },

    created() {
        axios
            .get('http://localhost:8000/api/products/' + this.id)
            .then(response => (this.product = response.data))
            .catch(error => console.log(error));
    },

    methods: {
        addToCart() {
            if(!productsInCart.find(p => p.id === this.product.id)) {
                productsInCart.push(this.product);
                productsInCart.find(p => p.id === this.product.id).quantity = 1;
            } else {
                setProductsInCart(productsInCart.map(p => {
                    if(p.id === this.product.id) {
                        p.quantity++;
                    }
                    return p;
                }));
            }
            this.lengthOfCart = productsInCart.length;
        }
    },

    computed: {
        getUsername() {
            if(localStorage.getItem('loggedUser')) {
                return JSON.parse(localStorage.getItem('loggedUser')).name;
            }
        }
    }
}
</script>

<style scoped>
.product-container {
    display: flex;
    justify-content: space-evenly;
    margin-top: 50px;
}

.product-container__image {
    width: 380px;
    border-radius: 15px;
}

.product-container__image img {
    width: 100%;
    object-fit: cover;
    border-radius: 15px;
}

.product-container__info {
    width: 380px;
    display: flex;
    flex-direction: column;
    justify-content: start;
}

.product-container__title {
    font-size: 36px;
    font-weight: bold;
    margin: 10px 0;
}

.product-container__description {
    font-size: 18px;
    margin-top: 10px;
}

.product-container__price {
    font-size: 20px;
    font-weight: bold;
    margin-top: 10px;
}
</style>
