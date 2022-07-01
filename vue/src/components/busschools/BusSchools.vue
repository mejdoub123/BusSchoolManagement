<script setup>
import { useBusSchoolsStore } from "../../stores/busschools";
import AddBusSchool from "./AddBusSchool.vue";
const busSchoolsStore = useBusSchoolsStore();
</script>
<template>
    <router-view></router-view>
</template>
