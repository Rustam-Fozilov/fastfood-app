<template>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">All orders</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive o-hidden">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mt-2">
                                <form @submit.prevent="searchOrder" id="dataTable_length" class="dataTables_length">
                                    <label>
                                        <input
                                        type="search"
                                        class="form-control form-control-sm"
                                        placeholder="Search"
                                        aria-controls="dataTable"
                                        v-model="searchValue"
                                        @input="searchOrder"/>
                                    </label>
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>

                                    <button @click.stop.prevent="getAllOrders" class="btn btn-success btn-sm ml-2">
                                        <i class="fas fa fa-history fa-sm"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <div id="dataTable_filter" class="dataTables_filter" style="text-align: right;">
                                    <label>
                                        <button data-toggle="modal" data-target="#addOrderModal" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus fa-sm"></i>
                                            Add new order
                                        </button>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <p style="color: red;"> {{ this.errorText }}</p>

                        <div class="modal fade" id="addOrderModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add new order</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        User id
                                        <select class="form-control mb-3" v-model="newOrderInfo[0].user_id">
                                            <option value="">Select user</option>
                                            <option v-for="user in allUsers" :value="user.id">{{user.id + '-' +  user.name }}</option>
                                        </select>
                                        Product name
                                        <select class="form-control mb-3" v-model="newOrderInfo[0].name" @change="getSelectedProductPriceToNewOrder">
                                            <option value="">Select product</option>
                                            <option v-for="product in allProducts" :value="product.name">{{ product.name }}</option>
                                        </select>
                                        Quantity
                                        <input type="number" min="1" class="form-control mb-3" v-model="newOrderInfo[0].quantity">

                                    </div>
                                    <div class="modal-footer">
                                        <button @click="addNewOrder" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="updateOrderModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update order</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        User id
                                        <select class="form-control mb-3" v-model="updateOrderInfo[0].user_id">
                                            <option value="">Select user</option>
                                            <option v-for="user in allUsers" :value="user.id">{{user.id + '-' +  user.name }}</option>
                                        </select>
                                        Product name
                                        <select class="form-control mb-3" v-model="updateOrderInfo[0].name" @change="getSelectedProductPriceToUpdateOrder">
                                            <option value="">Select product</option>
                                            <option v-for="product in allProducts" :value="product.name">{{ product.name }}</option>
                                        </select>
                                        Quantity
                                        <input type="number" min="1" class="form-control mb-3" v-model="updateOrderInfo[0].quantity">
                                    </div>
                                    <div class="modal-footer">
                                        <button @click="updateOrder()" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table
                                    class="table table-bordered dataTable"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0"
                                    role="grid"
                                    aria-describedby="dataTable_info"
                                    style="width: 100%"
                                >
                                    <thead>
                                    <tr role="row">
                                        <th
                                            class="sorting sorting_asc"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 20px"
                                        >
                                            №
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            Customer name
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            User id
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Office: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            Email
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Age: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            Product name
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 20px"
                                        >
                                            Quantity
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 20px"
                                        >
                                            Price
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            Total price
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            Date
                                        </th>
                                        <th
                                            class="sorting"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 96px"
                                        >
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">№</th>
                                        <th rowspan="1" colspan="1">Customer name</th>
                                        <th rowspan="1" colspan="1">User id</th>
                                        <th rowspan="1" colspan="1">Email</th>
                                        <th rowspan="1" colspan="1">Product name</th>
                                        <th rowspan="1" colspan="1">Quantity</th>
                                        <th rowspan="1" colspan="1">Price</th>
                                        <th rowspan="1" colspan="1">Total price</th>
                                        <th rowspan="1" colspan="1">Data</th>
                                        <th rowspan="1" colspan="1">Action</th>

                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <tr class="odd" v-for="(order, idx) in ordersInfo">
                                        <td class="sorting_1">{{ idx + 1}}</td>
                                        <td>{{ order.name }}</td>
                                        <td>{{ order.user_id }}</td>
                                        <td>{{ order.email }}</td>
                                        <td>{{ order.product_name }}</td>
                                        <td>{{ order.product_quantity }}</td>
                                        <td>{{ order.product_price }} $</td>
                                        <td>{{ order.total_price }} $</td>
                                        <td>{{ order.created_at }}</td>
                                        <td>
                                            <button
                                                @click="updateOrderInfo[0].order_id = order.id"
                                                data-toggle="modal" data-target="#updateOrderModal"
                                                class="btn btn-circle btn-sm btn-primary mr-2"
                                            >
                                                <i class="fas fa-light fa-pen"></i>
                                            </button>

                                            <button @click="deleteOrder(order.id)" class="btn btn-circle btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" id="pagination_bootstrap" v-if="links.length > 3">
                            <div class="col-sm-12 col-md-3">
                                <div
                                    class="dataTables_paginate paging_simple_numbers"
                                    id="dataTable_paginate"
                                >
                                    <ul class="pagination">
                                        <li
                                            class="page-item" :class="link.active ? 'active' : ''"
                                            v-for="(link, idx) in links"
                                            @click="paginate(idx)"
                                        >
                                            <span
                                                style="cursor: pointer;"
                                                class="page-link"
                                                v-html="link.label"></span>
                                        </li>
                                    </ul>
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
    name: "OrdersPage",

    data() {
        return {
            allUsers: null,
            allProducts: null,
            ordersInfo: null,
            searchValue: "",

            newOrderInfo: [{
                user_id: 0,
                name: "",
                quantity: 0,
                price: 0,
            }],

            updateOrderInfo: [{
                order_id: 0,
                user_id: 0,
                name: "",
                quantity: 0,
                price: 0,
            }],

            errorText: '',
            links: [],
        }
    },

    created() {
        this.getPagination();
        this.getAllProducts();
        this.getAllUsers();
    },

    methods: {
        paginate(i) {
            axios
                .post(String(this.links[i].url), {
                    'is_admin' : JSON.parse(localStorage.getItem('admin')).is_admin,
                })
                .then(response => {
                    this.ordersInfo = response.data.orders.data;
                    this.links = response.data.orders.links;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getPagination() {
            axios
                .post("http://localhost:8000/api/orders-pagination", {
                    'is_admin' : JSON.parse(localStorage.getItem('admin')).is_admin,
                })
                .then((response) => {
                    this.ordersInfo = response.data.orders.data;
                    this.links = response.data.orders.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        addNewOrder() {
            axios.post("http://localhost:8000/api/confirm_order", {
                products: this.newOrderInfo,
                user_id: this.newOrderInfo[0].user_id
            })
                .then(response => {
                    this.errorText = '';
                    this.getAllOrders();
                })
                .catch(error => {
                    console.log(error);
                    this.errorText = 'OOPS Something went wrong!';
                });
        },

        updateOrder() {
            axios.put("http://localhost:8000/api/orders/" + this.updateOrderInfo[0].order_id, {
                'user_id': this.updateOrderInfo[0].user_id,
                'products': this.updateOrderInfo[0],
            })
                .then(response => {
                    this.errorText = '';
                    this.getAllOrders();
                })
                .catch(error => {
                    console.log(error);
                    this.errorText = 'OOPS Something went wrong!';
                });
        },

        getAllUsers() {
            axios
                .get("http://localhost:8000/api/users")
                .then((response) => {
                    this.allUsers = response.data.users;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getAllProducts() {
            axios.get("/api/products").then(response => {
                this.allProducts = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        },

        getAllOrders() {
            axios
                .post('/api/orders', {
                    'is_admin' : JSON.parse(localStorage.getItem('admin')).is_admin,
                })
                .then(response => {
                    console.log(response.data);
                    this.ordersInfo = response.data.orders;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        deleteOrder(id) {
            if(confirm('Are your sure ?')) {
                axios
                    .delete('/api/orders/' + id)
                    .then(response => {
                        console.log(response.data.message);
                        this.getAllOrders();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        searchOrder() {
            axios
                .post('/api/orders/search', {
                    'search' : this.searchValue,
                })
                .then(response => {
                    this.ordersInfo = response.data.result;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getSelectedProductPriceToNewOrder() {
            this.allProducts.forEach(product => {
                if(product.name === this.newOrderInfo[0].name) {
                    this.newOrderInfo[0].price = product.price;
                }
            });
        },

        getSelectedProductPriceToUpdateOrder() {
            this.allProducts.forEach(product => {
                if(product.name === this.updateOrderInfo[0].name) {
                    this.updateOrderInfo[0].price = product.price;
                }
            });
        },
    },
}
</script>

<style scoped>

</style>
