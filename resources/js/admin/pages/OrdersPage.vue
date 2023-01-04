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

                                    <button @click.stop.prevent="getOrders" class="btn btn-success btn-sm ml-2">
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

                        <div class="modal fade" id="addOrderModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add new order</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        Username
                                        <input type="text" class="form-control mb-3" v-model="newOrderInfo.username">
                                        User id
                                        <input type="number" class="form-control mb-3" v-model="newOrderInfo.user_id">
                                        Email
                                        <input type="text" class="form-control mb-3" v-model="newOrderInfo.email">
                                        Product name
                                        <select class="form-control mb-3" v-model="newOrderInfo.name" @change="selected()">
                                            <option value="">Select product</option>
                                            <option v-for="product in allProducts" :value="product.name">{{ product.name }}</option>
                                        </select>
                                        Quantity
                                        <input type="number" class="form-control mb-3" v-model="newOrderInfo.quantity">
                                        Product price
                                        <input type="number" class="form-control mb-3" v-model="newOrderInfo.price">

                                    </div>
                                    <div class="modal-footer">
                                        <button @click="addNewOrder" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
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
                                            <button class="btn btn-circle btn-sm btn-primary mr-2">
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
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div
                                    class="dataTables_paginate paging_simple_numbers"
                                    id="dataTable_paginate"
                                >
                                    <ul class="pagination">
                                        <li
                                            class="paginate_button page-item previous disabled"
                                            id="dataTable_previous"
                                        >
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="0"
                                                tabindex="0"
                                                class="page-link"
                                            >Previous</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item active">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="1"
                                                tabindex="0"
                                                class="page-link"
                                            >1</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="2"
                                                tabindex="0"
                                                class="page-link"
                                            >2</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="3"
                                                tabindex="0"
                                                class="page-link"
                                            >3</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="4"
                                                tabindex="0"
                                                class="page-link"
                                            >4</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="5"
                                                tabindex="0"
                                                class="page-link"
                                            >5</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="6"
                                                tabindex="0"
                                                class="page-link"
                                            >6</a
                                            >
                                        </li>
                                        <li class="paginate_button page-item next" id="dataTable_next">
                                            <a
                                                href="#"
                                                aria-controls="dataTable"
                                                data-dt-idx="7"
                                                tabindex="0"
                                                class="page-link"
                                            >Next</a
                                            >
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
            allProducts: null,
            ordersInfo: null,
            searchValue: "",
            newOrderInfo: [{
                username: "",
                user_id: 0,
                email: "",
                name: "",
                quantity: 0,
                price: 0,
            }],
        }
    },

    created() {
        this.getAllOrders();
        this.getAllProducts();
    },

    methods: {
        addNewOrder() {
            axios.post("http://localhost:8000/api/confirm_order", {
                products: this.newOrderInfo[1],
                user_id: this.newOrderInfo.user_id
            })
                .then(response => {
                    console.log(response.data);
                    this.getAllOrders();
                })
                .catch(error => {
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
                        console.log(response.message);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }

            this.getAllOrders();
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

        selected() {
            console.log('selected');
        }
    }
}
</script>

<style scoped>

</style>
