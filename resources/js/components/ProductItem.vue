<template>
    <div class="product_item">
        <router-link :to="'/product/' + product.id">
            <span>
                <div class="product_image">
                    <img src="http://127.0.0.1:8000/assets/products/burger.png" alt="product_image">
                </div>
                <div class="product_info">
                    <h3>{{ product.name }}</h3>
                    <p>{{ product.price }} so'm</p>
                </div>
            </span>
        </router-link>
        <button class="btn" @click="addToCart">SAVATGA</button>
    </div>
</template>

<script>
export default {
    name: "ProductItem",
    emits: ['add-to-cart'],
    props: {
        product: {
            type: Object,
            required: true
        }
    },

    methods: {
        addToCart() {
            this.$emit('add-to-cart', this.product);
        }
    }
}
</script>

<style scoped>
    .product_item {
        width: 280px;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 40px;
    }

    .product_image {
        width: 100%;
        height: 310px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .product_image img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        object-fit: cover;
    }

    .product_info h3 {
        font-size: 18px;
        text-align: center;
        margin-bottom: 0px;
    }

    .product_info p {
        font-size: 16px;
        text-align: center;
        margin-top: 5px;
    }
</style>
