<template>
    <nav>
        <div class="nav-wrapper">
            <div class="brand">
                <router-link to="/" class="brand-logo">
                    <span>
                        <img src="http://127.0.0.1:8000/assets/navbar/logo.png" alt="LOGO">
                    </span>
                </router-link>
            </div>
            <div class="nav-search">
                <form method="GET" @submit.prevent="search">
                    <input type="text" name="query" placeholder="Search" autocomplete="off" v-model="query">
                    <button type="submit">
                        <span>
                            <img src="http://127.0.0.1:8000/assets/navbar/search.svg" alt="search">
                        </span>
                    </button>
                </form>
            </div>
            <div class="right_nav">
                <div class="user">
                    <router-link :to="isLogged ? '/login' : '/profile'">
                        <span>
                            <img src="http://127.0.0.1:8000/assets/navbar/user.svg" alt="user img">
                        </span>
                        {{ this.isLogged ? 'Login' : 'Rustam' }}
                    </router-link>
                </div>
                <div class="cart">
                    <router-link to="/cart">
                        <span>
                            <img src="http://127.0.0.1:8000/assets/navbar/cart.svg" alt="cart img">
                        </span>
                        Cart {{ cartLength }}
                    </router-link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from "axios";

export default {
    name: "Navbar",
    props: {
        cartLength: {
            type: Number,
        }
    },

    created() {
        axios
            .get('/api/isLogged')
            .then(response => {
                this.isLogged = response.data;
            })
            .catch(error => {
                console.log(error);
            })
    },

    data() {
        return {
            isLogged: false,
            query: null,
            searchData: null,
        }
    },

    methods: {
        search() {
            axios
                .post('/api/search', {query: this.query})
                .then(response => {
                    this.searchData = response.data;
                    this.$router.push({
                        name: 'Search',
                        params: {
                            data: JSON.stringify(this.searchData),
                        }
                    });
                })
                .catch(error => {
                    console.log(error);
                })
        },
    }
}
</script>

<style scoped>
    nav {
        height: 100px;
    }

    .nav-wrapper {
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand-logo img {
        width: 120px;
    }

    .nav-search {
        border: 1px solid #ccc;
        height: 40px;
        border-radius: 5px;
    }

    .nav-search form {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .nav-search input {
        width: 400px;
        border: none;
        outline: none;
        font-size: 18px;
        padding: 0 10px;
    }

    .nav-search button {
        width: 100px;
        height: 100%;
        border: none;
        outline: none;
        background-color: #f8f8f8;
        cursor: pointer;
        border-radius: 5px;
    }

    .right_nav {
        display: flex;
    }

    .user {
        margin-right: 25px;
        padding: 10px;
    }

    .user img {
        width: 20px;
    }

    .user a {
        display: flex;
        align-items: center;
    }

    .user a span {
        margin-right: 10px;
    }

    .cart img {
        width: 20px;
    }

    .cart {
        padding: 10px;
    }

    .cart a {
        display: flex;
        align-items: center;
    }

    .cart a span {
        margin-right: 10px;
    }

    .user:hover {
        background-color: #f1f1f2;
        border-radius: 5px;
    }

    .cart:hover {
        background-color: #f1f1f2;
        border-radius: 5px;
    }
</style>
