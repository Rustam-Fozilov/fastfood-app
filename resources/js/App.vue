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
    border-radius: 7px;
    background-color: #000;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    transition: 0.2s;
}

.btn:hover {
    border: 1px solid black;
    background-color: transparent;
    color: black;
}

.container {
    margin: 0 auto;
    width: 1260px;
}
</style>
