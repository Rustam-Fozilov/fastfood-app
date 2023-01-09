<template>
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
<!--            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
<!--                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
        </div>

        <!-- Content Row -->
        <div class="row" style="justify-content: start">

            <!-- All products Card Example -->
            <router-link to="/products" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Barcha mahsulotlar
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.products.length }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </router-link>

            <!-- Users Card Example -->
            <router-link to="/users" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Barcha foydalanuvchilar
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.users.length }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </router-link>

            <!-- Orders Card Example -->
            <router-link to="/orders" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Barcha buyurtmalar
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ this.orders.length }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                 style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>

    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "DashboardPage",

    data() {
        return {
            products: [],
            users: [],
            orders: [],
        }
    },

    created() {
        this.getProducts();
        this.getUsers();
        this.getOrders();
    },

    methods: {
        getProducts() {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getUsers() {
            axios.get('/api/users')
                .then(response => {
                    this.users = response.data.users;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getOrders() {
            axios.post('/api/orders', {
                is_admin: JSON.parse(localStorage.getItem('admin')).is_admin,
            })
            .then(response => {
                this.orders = response.data.orders;
            })
            .catch(error => {
                console.log(error);
            });
        },
    }
}
</script>

<style scoped>

</style>
