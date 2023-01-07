<template>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">All products</h1>

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
                                <form @submit.prevent="searchProduct" id="dataTable_length" class="dataTables_length">
                                    <label>
                                        <input
                                            type="search"
                                            class="form-control form-control-sm"
                                            placeholder="Search"
                                            aria-controls="dataTable"
                                            v-model="searchValue"
                                            @input="searchProduct"/>
                                    </label>
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>

                                    <button @click.stop.prevent="getAllProducts" class="btn btn-success btn-sm ml-2">
                                        <i class="fas fa fa-history fa-sm"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-2">
                                <div id="dataTable_filter" class="dataTables_filter" style="text-align: right;">
                                    <label>
                                        <button data-toggle="modal" data-target="#addProductModal" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus fa-sm"></i>
                                            Add new product
                                        </button>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <p style="color: red;"> {{ this.errorText }}</p>

                        <div class="modal fade" id="addProductModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add new product</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        Name
                                        <input type="text" autocomplete="off" required class="form-control mb-3" v-model="newProductInfo[0].name">
                                        Price
                                        <input type="number" autocomplete="off" required class="form-control mb-3" v-model="newProductInfo[0].price">
                                        description
                                        <textarea style="resize: none" type="password" autocomplete="off" required class="form-control mb-3" v-model="newProductInfo[0].description">
                                        </textarea>
                                        Image
                                        <input type="file" autocomplete="off" required class="form-control-file mb-3" @change="previewFile">
                                    </div>
                                    <div class="modal-footer">
                                        <button @click="addNewProduct" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="updateProductModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update product</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        Name
                                        <input type="text" autocomplete="off" required class="form-control mb-3" v-model="updateProductInfo[0].name">
                                        Price
                                        <input type="number" autocomplete="off" required class="form-control mb-3" v-model="updateProductInfo[0].price">
                                        description
                                        <textarea style="resize: none" type="password" autocomplete="off" required class="form-control mb-3" v-model="updateProductInfo[0].description">
                                        </textarea>
                                        Image
                                        <input type="file" autocomplete="off" required class="form-control-file mb-3" @change="updateImage">
                                    </div>
                                    <div class="modal-footer">
                                        <button @click="updateProduct" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
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
                                            class="sorting sorting_asc"
                                            tabindex="0"
                                            aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 20px"
                                        >
                                            Image
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
                                            Name
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
                                            Price
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
                                            description
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
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">№</th>
                                        <th rowspan="1" colspan="1">Image</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Price</th>
                                        <th rowspan="1" colspan="1">Description</th>
                                        <th rowspan="1" colspan="1">Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <tr class="odd" v-for="(product, idx) in allProducts">
                                        <td class="sorting_1">{{ idx }}</td>
                                        <td>
                                            <span>
                                                <img :src="'http://127.0.0.1:8000/assets/products/'+product.image_name" alt="image" style="width: 100px;">
                                            </span>
                                        </td>
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.price }}</td>
                                        <td>{{ product.description }}</td>
                                        <td>
                                            <button
                                                @click="updateProductInfo[0].id = product.id"
                                                data-toggle="modal" data-target="#updateProductModal"
                                                class="btn btn-circle btn-sm btn-primary mr-2"
                                            >
                                                <i class="fas fa-light fa-pen"></i>
                                            </button>

                                            <button @click="deleteProduct(product.name)" class="btn btn-circle btn-sm btn-danger">
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
    name: "ProductsPage",

    data() {
        return {
            allProducts: [],
            links: [],
            searchValue: '',
            errorText: '',

            newProductInfo: [{
                name: '',
                price: 0,
                description: '',
                image: [],
            }],

            updateProductInfo: [{
                id: '',
                name: '',
                price: 0,
                description: '',
                image: [],
            }],
        }
    },

    created() {
        this.getAllProducts();
        this.getPagination();
    },

    methods: {
        updateImage(event) {
            this.updateProductInfo[0].image = event.target.files[0];
            console.log(this.updateProductInfo[0].image);
        },

        updateProduct() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let formData2 = new FormData();
            formData2.append('name', this.updateProductInfo[0].name);
            formData2.append('price', this.updateProductInfo[0].price);
            formData2.append('description', this.updateProductInfo[0].description);
            formData2.append('image', this.updateProductInfo[0].image);

            axios
                .post('/api/products/' + this.updateProductInfo[0].id, formData2, config)
                .then(response => {
                    console.log(response.data.message)
                    this.getAllProducts();
                })
                .catch(error => {
                    console.log(error);
                    this.errorText = error.response.data.message;
                });
        },

        deleteProduct(name) {
            if(confirm('Are you sure?')) {
                axios
                    .delete('/api/products/' + name)
                    .then(response => {
                        console.log(response.data.message)
                        this.getAllProducts();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        previewFile(event) {
            this.newProductInfo[0].image = event.target.files[0];
            console.log(this.newProductInfo[0].image);
        },

        addNewProduct() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let formData = new FormData();
            formData.append('name', this.newProductInfo[0].name);
            formData.append('price', this.newProductInfo[0].price);
            formData.append('description', this.newProductInfo[0].description);
            formData.append('image', this.newProductInfo[0].image);

            axios
                .post('/api/products', formData, config)
                .then(response => {
                    console.log(response.data.message)
                    this.getAllProducts();
                })
                .catch(error => {
                    console.log(error);
                    this.errorText = error.response.data.message;
                });
        },

        paginate(i) {
            // axios
            //     .post(String(this.links[i].url), {
            //         'is_admin' : JSON.parse(localStorage.getItem('admin')).is_admin,
            //     })
            //     .then(response => {
            //         this.allProducts = response.data.products.data;
            //         this.links = response.data.products.links;
            //     })
            //     .catch(error => {
            //         console.log(error);
            //     });
        },

        getPagination() {
            // axios
            //     .get("http://localhost:8000/api/products-pagination", {
            //         'is_admin' : JSON.parse(localStorage.getItem('admin')).is_admin,
            //     })
            //     .then((response) => {
            //         this.allProducts = response.data.products.data;
            //         this.links = response.data.products.links;
            //     })
            //     .catch((error) => {
            //         console.log(error);
            //     });
        },

        searchProduct() {
            axios
                .post('/api/search', {
                    query: this.searchValue
                })
                .then(response => {
                    this.allProducts = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getAllProducts() {
            axios.get('/api/products')
                .then(response => {
                    this.allProducts = response.data;
                    this.errorText = '';
                })
                .catch(error => {
                    console.log(error);
                })
        },
    }
}
</script>

<style scoped>

</style>
