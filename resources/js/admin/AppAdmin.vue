<template>
    <div id="wrapper">
        <ul v-if="isLogged" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <!--            <div class="sidebar-brand-icon rotate-n-15">-->
    <!--                <i class="fas fa-laugh-wink"></i>-->
    <!--            </div>-->
                <div class="sidebar-brand-text mx-3">Admin panel</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <router-link class="nav-link" to="/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <router-link to="/products" class="nav-link">
                    <i class="fas fa fa-fw fa-th-large"></i>
                    <span> Products</span>
                </router-link>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <router-link to="/users" class="nav-link">
                    <i class="fas fa fa-fw fa-users"></i>
                    <span> Users</span>
                </router-link>
            </li>

            <li class="nav-item">
                <router-link to="/orders" class="nav-link">
                    <i class="fas fa fa-fw fa-shopping-basket"></i>
                    <span> Orders</span>
                </router-link>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Logout -->

            <li class="nav-item">
                <router-link to="/" @click="logout" class="nav-link">
                    <i class="fa-fw fa fa-reply-all"></i>
                    <span> Log out</span>
                </router-link>
            </li>

        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav v-if="isLogged" class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ this.username }}</span>
                                <img class="img-profile rounded-circle" src="http://admin.localhost:8000/assets_admin/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <router-link to="/" @click="logout" class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </router-link>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <router-view @admin-logged="access"></router-view>
                <!-- End Page Content -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
</template>

<script>
export default {
    name: "AppAdmin",

    data() {
        return {
            isLogged: false,
            username: '',
        }
    },

    created() {
        if(localStorage.getItem('token') == null) {
            this.$router.push({name: 'Login'});
        } else {
            this.isLogged = true;
            this.$router.push({name: 'Dashboard'});

            this.username = JSON.parse(localStorage.getItem('admin')).name;
        }
    },

    methods: {
        access() {
            this.isLogged = true;
            this.$router.push({name: 'Dashboard'});
        },

        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('admin');
            this.isLogged = false;
            // this.$router.push({name: 'Main'});
        }
    },
}
</script>

<style scoped>
/*@font-face {*/
/*    font-family: 'Inter-Regular';*/
/*    src: url('assets/fonts/Inter-Regular.ttf');*/
/*}*/

/*html, body {*/
/*    margin: 0;*/
/*    padding: 0;*/
/*    width: 100%;*/
/*    height: 100%;*/
/*    font-family: Inter-Regular;*/
/*}*/

/*a {*/
/*    text-decoration: none;*/
/*    color: black;*/
/*}*/

/*.btn {*/
/*    padding: 15px 35px;*/
/*    border: none;*/
/*    border-radius: 5px;*/
/*    background-color: #000;*/
/*    color: #fff;*/
/*    font-size: 18px;*/
/*    cursor: pointer;*/
/*    transition: 0.2s;*/
/*}*/

/*.btn:hover {*/
/*    opacity: 0.7;*/
/*}*/

/*.container {*/
/*    margin: 0 auto;*/
/*    width: 1260px;*/
/*}*/
</style>
