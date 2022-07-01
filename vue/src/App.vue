<script setup>
import { RouterLink, RouterView } from "vue-router";
import SignInVue from "./components/auth/SignIn.vue";
import "@tabler/core/dist/css/tabler.min.css";
import "@tabler/core/dist/js/tabler.min.js";
</script>

<template>
    <RouterView />
</template>

<style>
/*Wraperclass for the divicon*/
.map-label {
    position: absolute;
    bottom: 0;
    left: -50%;
    display: flex;
    flex-direction: column;
    text-align: center;
    color: rgb(82, 66, 155);
}
/*Wrap the content of the divicon (text) in this class*/
.map-label-content {
    order: 1;
    position: relative;
    left: -50%;
    background-color: rgb(231, 228, 255);
    border-radius: 5px;
    border-width: 2px;
    border-style: solid;
    border-color: rgb(81, 112, 23);
    padding: 3px;
    white-space: nowrap;
}
.map-label-yellow {
    position: absolute;
    bottom: 0;
    left: -50%;
    display: flex;
    flex-direction: column;
    text-align: center;
    color: rgb(173, 233, 34);
}
/*Wrap the content of the divicon (text) in this class*/
.map-label-content-yellow {
    order: 1;
    position: relative;
    left: -50%;
    background-color: rgb(244, 253, 201);
    border-radius: 5px;
    border-width: 2px;
    border-style: solid;
    color: rgb(150, 150, 58);

    border-color: rgb(178, 223, 14);
    padding: 3px;
    white-space: nowrap;
}
.map-label-content-red {
    order: 1;
    position: relative;
    left: -50%;
    background-color: rgb(241, 191, 191);
    border-radius: 5px;
    border-width: 2px;
    border-style: solid;
    color: rgb(219, 32, 32);

    border-color: rgb(236, 42, 90);
    padding: 3px;
    white-space: nowrap;
}
/*Add this arrow*/
.map-label-arrow {
    order: 2;
    width: 0px;
    height: 0px;
    left: 50%;
    border-style: solid;
    border-color: rgb(81, 112, 23) transparent transparent transparent;
    border-width: 10px 6px 0 6px; /*[first number is height, second/fourth are rigth/left width]*/
    margin-left: -6px;
}

/*Instance classes*/
.map-label.inactive {
    opacity: 0.5;
}

.map-label.blueborder > .map-label-content {
    border-color: rgb(121, 58, 238);
}
.map-label.blueborder > .map-label-arrow {
    border-top-color: rgb(121, 58, 238);
}

.map-label.yellowborder > .map-label-content {
    border-color: rgb(232, 255, 21);
}
.map-label.yellowborder > .map-label-arrow {
    border-top-color: rgb(235, 238, 58);
}

.map-label.redborder > .map-label-content {
    border-color: rgb(180, 25, 59);
}
.map-label.redborder > .map-label-arrow {
    border-top-color: rgb(207, 21, 114);
}
.map-label.greenbackground > .map-label-content {
    white-space: default;
    color: rgb(81, 112, 23);
    background-color: rgb(195, 250, 224);
}
</style>
