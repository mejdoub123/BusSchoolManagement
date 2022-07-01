<script setup>
import BusSchoolItem from "./BusSchoolHPItem.vue";
import { useBusSchoolsStore } from "../../stores/busschools";

import { ref, watch, watchEffect } from "vue";
import { useDriversStore } from "../../stores/drivers";

const busSchoolsStore = useBusSchoolsStore();
const driversStore = useDriversStore();
</script>
<template>
    <div
        class="list-group list-group-flush overflow-auto"
        style="max-height: 443px"
    >
        <BusSchoolItem
            :key="busschool.id"
            v-for="busschool in busSchoolsStore.busschools"
            :busSchool="busschool"
        />
    </div>
</template>
