<script setup>
import BusSchoolDriverInfos from "./BusSchoolDriverInfos.vue";
import BusSchoolStudentsList from "./BusSchoolStudentsList.vue";
import MapBusSchoolInfos from "../maps/MapBusSchoolInfos.vue";
import { useBusSchoolsStore } from "../../stores/busschools";
import { onMounted } from "@vue/runtime-core";
import router from "../../router";
import BusSchoolBSPItem from "./BusSchoolBSPItem.vue";
import { useDriversStore } from "../../stores/drivers";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";
import Spinner from "../layouts/Spinner.vue";
import { useTrajectStore } from "../../stores/trajects";
const busschoolsStore = useBusSchoolsStore();
const driversStore = useDriversStore();
const studentsStore = useStudentsStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
onMounted(() => {
    if (busschoolsStore.busschools.length === 0 && !busschoolsStore.loading) {
        router.push("/admin/busschools/notfound");
    }
});
</script>
<template>
    <div
        v-if="
            busschoolsStore.busSchoolsInfos &&
            driversStore.driversData &&
            studentsStore.studentsData &&
            zonesStore.zonesData &&
            trajectsStore.trajectsData
        "
        class="col-12"
    >
        <BusSchoolBSPItem
            :key="busschool"
            v-for="busschool in busschoolsStore.busschools"
            :busSchool="busschool"
        />
    </div>

    <Spinner v-else style="margin-left: 40%" />
</template>
