<template>
    <Navbar :cart-length="products.length" :username="getUsername"/>
    <h1 style="text-align: center">Buyurmalaringiz {{products.length}}</h1>
    <div class="cart">
        <div class="cart-container">
            <div class="cart-item" v-for="product in products" :key="product.id">
                <div class="cart-item-image">
                    <img :src="'assets/products/' + product.image_name" alt="product image">
                </div>
                <div class="cart-item-info">
                    <p>{{ product.name }}</p>
                </div>
                <div class="cart-item-quantity">
                    <button @click="decrementQuantity(product)" class="btn-counter">-</button>
                    <span>{{ product.quantity }}</span>
                    <button @click="incrementQuantity(product)" class="btn-counter">+</button>
                </div>
                <div class="cart-item-total">
                    <p>{{ product.quantity * product.price }} so'm</p>
                </div>
                <div class="cart-item-remove">
                    <button class="btn-counter" @click="removeFromCart(product)">X</button>
                </div>
            </div>
        </div>
        <p>Jami: {{totalPrice}} so'm</p>
        <button class="btn" @click="confirm">BUYURTMA QILISH</button>
    </div>
</template>

<script>
import {productsInCart, setProductsInCart, setProductsInCartQuantity} from "../data/productsInCart.js";
import Navbar from "../components/Navbar.vue";
import axios from "axios";

export default {
    name: "CartPage",
    components: {Navbar},
    data() {
        return {
            products: productsInCart,
        }
    },

    methods: {
        incrementQuantity(product) {
            setProductsInCartQuantity(product.id, product.quantity + 1);
            this.products = productsInCart;
        },

        decrementQuantity(product) {
            if(product.quantity > 1) {
                setProductsInCartQuantity(product.id, product.quantity - 1);
            }
            this.products = productsInCart;
        },

        removeFromCart(product) {
            setProductsInCart(productsInCart.filter(p => p.id !== product.id));
            this.products = productsInCart;
        },

        confirm() {
            if(this.products.length > 0) {
                if(localStorage.getItem('loggedUser')) {
                    axios
                        .post('/api/confirm_order', {
                            products: this.products,
                            user_id: JSON.parse(localStorage.getItem('loggedUser')).id,
                        })
                        .then(response => {
                            setProductsInCart([]);
                            this.products = productsInCart;
                            alert(response.data.message)
                            this.$router.push('/');
                        })
                        .catch(error => {
                            console.log(error);
                        });
                } else {
                    this.$router.push({
                        name: 'Login',
                    })
                }
            }
        }
    },

    computed: {
        totalPrice() {
            return this.products.reduce((acc, product) => {
                return acc + product.quantity * product.price;
            }, 0);
        },

        getUsername() {
            if(localStorage.getItem('loggedUser')) {
                return JSON.parse(localStorage.getItem('loggedUser')).name;
            }
        }
    }
}
</script>

<style scoped>
.cart-container {
    border: 1px solid black;
    margin: 20px 0;
}

.cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 20px;
}

.cart-item-image {
    width: 150px;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-quantity {
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-counter {
    border: none;
    background-color: transparent;
    font-size: 24px;
    cursor: pointer;
    margin: 5px 15px;
}

</style>
