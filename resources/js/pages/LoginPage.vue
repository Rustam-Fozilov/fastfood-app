<template>
    <div class="login-container">
        <h1>Login</h1>

        <p class="error-text">{{ this.error }}</p>
        <form action="" method="post" @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" v-model="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" v-model="password">
            </div>
            <div class="form-group">
                <button type="submit">LOGIN</button>
            </div>
        </form>
        <p>Don't have account ? <router-link to="/register" style="text-decoration: underline;">register now</router-link></p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "LoginPage",
    data() {
        return {
            email: null,
            password: null,
            error: "",
        }
    },

    methods: {
        login() {
            axios
                .post('/api/login', {email: this.email, password: this.password})
                .then(response => {
                    if (response.data.status === 'success') {
                        localStorage.setItem('loggedUser', JSON.stringify(response.data.user));
                        localStorage.setItem('token', JSON.stringify(response.data.access_token.plainTextToken));
                        this.$router.push({
                            name: 'Home',
                        })
                    } else {
                        this.error = response.data.message;
                    }
                })
                .catch(error => {
                    this.error = error.response.data.message;
                })
        },
    }
}
</script>

<style scoped>
.login-container {
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.login-container h1 {
    font-size: 40px;
}

.error-text {
    color: red;
}

.login-container form {
    width: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.login-container form .form-group {
    width: 100%;
    margin-bottom: 20px;
}

.login-container form .form-group label {
    display: block;
    margin-bottom: 5px;
}

.login-container form .form-group input {
    width: 100%;
    height: 50px;
    font-size: 18px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    padding: 0 10px;
}

.login-container form .form-group button {
    width: 425px;
    height: 50px;
    border: none;
    outline: none;
    font-size: 18px;
    background-color: #151515;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 20px;
    transition: 0.2s;
}

.login-container form .form-group button:hover {
    opacity: 0.8;
}


</style>
