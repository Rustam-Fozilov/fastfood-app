<template>
    <div class="container">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'App',
}
</script>

<style>
@font-face {
    font-family: 'Inter-Regular';
    src: url('assets/fonts/Inter-Regular.ttf');
}

html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    font-family: Inter-Regular;
}

a {
    text-decoration: none;
    color: black;
}

.btn {
    padding: 15px 35px;
    border: none;
    border-radius: 5px;
    background-color: #000;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    opacity: 0.7;
}

.container {
    margin: 0 auto;
    width: 1260px;
}
</style>
