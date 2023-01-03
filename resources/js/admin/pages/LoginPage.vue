<template>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <p class="text-center text-danger">{{ this.error }}</p>
                                    <form class="user" @submit.prevent="login">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address..." name="email" v-model="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Password" name="password" v-model="password">
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" type="submit" value="Login"/>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "LoginPage",
    emits: ['admin-logged'],

    data() {
        return {
            email: '',
            password: '',
            error: ''
        }
    },

    methods: {
        login() {
            axios
                .post('/api/login', {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    if(response.data.role === 'admin') {
                        localStorage.setItem('token', JSON.stringify(response.data.token));
                        localStorage.setItem('admin', JSON.stringify(response.data.user));
                        this.$emit('admin-logged');
                    } else {
                        this.error = 'This user doesn\'t exist';
                    }
                })
                .catch(error => {
                    this.error = error.response.data.message;
                });
        }
    }
}
</script>

<style scoped>

</style>
