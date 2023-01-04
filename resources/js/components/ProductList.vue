<template>
    <p class="product-list__title">Burgers</p>
    <div class="product-list">
        <ProductItem v-for="product in products" :key="product.id" :product="product" @add-to-cart="addToCart"/>
    </div>

    <div v-if="links.length > 3" id="pagination_bootstrap" style="display: flex; justify-content: center; margin: 50px auto">
        <nav>
            <ul class="pagination">
                <li v-for="(link, idx) in links" class="page-item" :class="link.active ? 'active' : ''" @click="paginate(idx)">
                    <span class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </div>

    <hr>

</template>

<script>
import axios from "axios";
import ProductItem from "./ProductItem.vue";

export default {
    name: "ProductList",
    components: {
        ProductItem
    },

    emits: ['add-to-cart'],

    data() {
        return {
            products: [],
            links: [],
        }
    },

    created() {
        axios
            .get('http://localhost:8000/api/products/')
            .then(response => {
                this.products = response.data.data
                this.links = response.data.links
            })
            .catch(error => console.log(error));

    },

    methods: {
        addToCart(product) {
            this.$emit('add-to-cart', product);
        },

        paginate(i) {
            axios
                .get(String(this.links[i].url))
                .then(response => {
                    this.products = response.data.data
                    this.links = response.data.links
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>
    .product-list {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .product-list__title {
        font-size: 24px;
        font-weight: bold;
        margin-top: 50px;
    }

    /*!
 * Bootstrap v4.0.0 (https://getbootstrap.com) for pagination
 */

    a {
        text-decoration: none;
    }

    ol, ul, dl {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    .pagination {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
        font-family: 'Inter-Regular';
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.65rem 1rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #151515;
        background-color: #fff;
        border: 1px solid #dee2e6;
        font-family: "Inter-Regular";
    }

    .page-link:hover {
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .page-link:focus {
        z-index: 2;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(15, 100, 190, 0.25);
    }

    .page-link:not(:disabled):not(.disabled) {
        cursor: pointer;
    }

    .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #151515;
        border-color: #151515;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6;
    }

    .pagination-lg .page-link {
        padding: 0.75rem 1.5rem;
        font-size: 1.25rem;
        line-height: 1.5;
    }

    .pagination-lg .page-item:first-child .page-link {
        border-top-left-radius: 0.3rem;
        border-bottom-left-radius: 0.3rem;
    }

    .pagination-lg .page-item:last-child .page-link {
        border-top-right-radius: 0.3rem;
        border-bottom-right-radius: 0.3rem;
    }

    .pagination-sm .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .pagination-sm .page-item:first-child .page-link {
        border-top-left-radius: 0.2rem;
        border-bottom-left-radius: 0.2rem;
    }

    .pagination-sm .page-item:last-child .page-link {
        border-top-right-radius: 0.2rem;
        border-bottom-right-radius: 0.2rem;
    }

</style>
