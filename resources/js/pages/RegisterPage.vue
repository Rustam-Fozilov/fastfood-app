<template>
    <div class="login-container">
        <h1>Registration</h1>

        <p class="error-text">{{ this.error }}</p>
        <form action="" method="post" @submit.prevent="register">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" v-model="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" v-model="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" v-model="password">
            </div>
            <div class="form-group">
                <label for="retype_password">Retype password</label>
                <input type="password" name="retype_password" id="retype_password" v-model="retype_password">
            </div>
            <div class="form-group">
                <button type="submit">REGISTER</button>
            </div>
        </form>
        <p>Already have account? <router-link to="/login" style="text-decoration: underline;">login now</router-link></p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "RegisterPage",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            retype_password: "",
            error: "",
            user: null,
        }
    },

    methods: {
        register() {
            if (this.password !== this.retype_password) {
                this.error = "Password and retype password not match";
                return;
            }

            axios.post("/api/register", {
                name: this.name,
                email: this.email,
                password: this.password
            }).then(response => {
                this.user = response.data.user;
                this.$router.push("/login");
            }).catch(error => {
                this.error = error;
            });
        }
    },
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
