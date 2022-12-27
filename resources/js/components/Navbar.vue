<template>
    <nav>
        <div class="nav-wrapper">
            <div class="brand">
                <a href="/" class="brand-logo">
                    <span>
                        <img src="assets/navbar/logo.png" alt="LOGO">
                    </span>
                </a>
            </div>
            <div class="nav-search">
                <form action="/search" method="GET">
                    <input type="text" name="query" placeholder="Qidiring" autocomplete="off">
                    <button type="submit">
                        <span>
                            <img src="assets/navbar/search.svg" alt="search">
                        </span>
                    </button>
                </form>
            </div>
            <div class="right_nav">
                <div class="user">
                    <a href="#">
                        <span>
                            <img src="assets/navbar/user.svg" alt="user img">
                        </span>
                        Login
                    </a>
                </div>
                <div class="cart">
                    <router-link to="/cart">
                        <span>
                            <img src="assets/navbar/cart.svg" alt="cart img">
                        </span>
                        Cart {{ cartLength }}
                    </router-link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
    props: {
      cartLength: {
          type: Number,
          required: true
      }
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
