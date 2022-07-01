<script setup>
import VerticalNavbar from "../components/layouts/VerticalNavbar.vue";
import ExpandNavbar from "../components/layouts/ExpandNavbar.vue";
import SchoolInfo from "../components/school/School.vue";
</script>

<template>
    <div class="page">
        <VerticalNavbar />
        <div class="page-wrapper">
            <ExpandNavbar />
            <div class="page-body">
                <div class="container-xl">
                    <router-view />
                </div>
            </div>
        </div>
    </div>
</template>
