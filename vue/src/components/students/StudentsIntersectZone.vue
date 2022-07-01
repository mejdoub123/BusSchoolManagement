<script setup>
import { useStudentsStore } from "../../stores/students";
import StudentIntersectZoneItem from "./StudentIntersectZoneItem.vue";
import PlaceHolderBusSchoolsList from "../busschools/PlaceHolderBusSchoolsList.vue";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useDriversStore } from "../../stores/drivers";
import { useZoneStore } from "../../stores/zones";
const studentsStore = useStudentsStore();
const buschoolsStore = useBusSchoolsStore();
const driversStore = useDriversStore();
const zonesStore = useZoneStore();
</script>
<template>
    <div class="col-lg-6">
        <div
            v-if="
                !studentsStore.loading &&
                !buschoolsStore.loading &&
                !driversStore.loading &&
                !zonesStore.loading &&
                studentsStore.studentsIntZone.length > 0
            "
            class="card"
        >
            <div class="card-header">
                <h3 class="card-title">
                    Students that exist in this zone and doesn't have a bus
                    school
                </h3>
            </div>
            <div
                class="list-group list-group-flush overflow-auto"
                style="max-height: 350px"
            >
                <StudentIntersectZoneItem
                    :key="student"
                    v-for="student in studentsStore.studentsIntZone"
                    :student="student"
                />
            </div>
        </div>
        <PlaceHolderBusSchoolsList
            v-if="
                studentsStore.loading ||
                buschoolsStore.loading ||
                driversStore.loading ||
                zonesStore.loading ||
                studentsStore.studentsIntZone.length === 0
            "
        />
    </div>
</template>
