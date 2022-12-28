<template>
    <Navbar/>
    <h1>Search page</h1>
</template>

<script>
import {useRoute} from "vue-router";
import Navbar from "../components/Navbar.vue";

export default {
    name: "SearchPage",
    components: {Navbar},

    data() {
        return {
            query: null,
        }
    },

    created() {
        const route = useRoute();
        this.query = route.query.query;
    },
}
</script>

<style scoped>

</style>
