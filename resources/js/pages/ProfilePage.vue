<template>
    <div class="profile_container">
        <h1>Profile page</h1>
        <img src="http://127.0.0.1:8000/assets/profile/user.png" alt="user image">
        <h3>Id: <span>{{ this.user.id }}</span></h3>
        <h3>Name: <span>{{ this.user.name }}</span></h3>
        <h3>Email: <span>{{ this.user.email }}</span></h3>

        <button class="btn" @click="logout">LOGOUT</button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ProfilePage",

    data() {
        return {
            user: JSON.parse(localStorage.getItem('loggedUser')),
        }
    },

    methods: {
        logout() {
            axios
                .post('/api/logout')
                .then(response => {
                    if (response.data.status === 'success') {
                        localStorage.removeItem('loggedUser');
                        localStorage.removeItem('token');
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
    .profile_container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile_container img {
        width: 150px;
    }
</style>
