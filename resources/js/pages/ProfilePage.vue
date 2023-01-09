<template>
    <div class="background_profile">
        <div class="profile_container">
            <h1>Profile</h1>
            <img src="http://127.0.0.1:8000/assets/profile/user.png" alt="user image">
            <h3>User Id: <span>{{ this.user.id }}</span></h3>
            <h3>Ism: <span>{{ this.user.name }}</span></h3>
            <h3 style="margin-bottom: 40px;">Email: <span>{{ this.user.email }}</span></h3>
            <button class="btn" @click="logout">CHIQISH</button>
        </div>
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
    .background_profile {
        background-color: #f2f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
    }

    .profile_container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: start;
        background-color: white;
        width: 30%;
        padding: 50px;
        border-radius: 50px;
    }

    .profile_container img {
        width: 120px;
    }
</style>
