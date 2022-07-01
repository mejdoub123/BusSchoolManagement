<script setup>
import BusSchoolCard from "./BusSchoolCard.vue";
import Spinner from "../layouts/Spinner.vue";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";
import { useTrajectStore } from "../../stores/trajects";
import EditBusSchool from "./EditBusSchool.vue";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useDriversStore } from "../../stores/drivers";
import { usePlanningStore } from "../../stores/planning";
import { useRoute } from "vue-router";
const studentsStore = useStudentsStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
const busSchoolsStore = useBusSchoolsStore();
const driversStore = useDriversStore();
const planningStore = usePlanningStore();
const route = useRoute();
</script>
<template>
    <div>
        <BusSchoolCard
            v-if="
                !studentsStore.loading &&
                !driversStore.loading &&
                !busSchoolsStore.loading &&
                !zonesStore.loading &&
                !trajectsStore.loading
            "
        />
        <Spinner
            v-else-if="
                studentsStore.loading ||
                driversStore.loading ||
                busSchoolsStore.loading ||
                zonesStore.loading ||
                trajectsStore.loading
            "
            style="margin-left: 40%"
        />
        
    </div>
</template>
