<template>
    <h1>Profile page</h1>
    <button class="btn" @click="logout">LOGOUT</button>
</template>

<script>
import axios from "axios";

export default {
    name: "ProfilePage",

    methods: {
        logout() {
            axios
                .post('/api/logout', JSON.parse(localStorage.getItem('loggedUser')))
                .then(response => {
                    if (response.data.status === 'success') {
                        localStorage.removeItem('loggedUser');
                        this.$router.push({
                            name: 'Home',
                        })
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
