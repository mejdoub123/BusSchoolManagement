<script setup>
import { useBusSchoolsStore } from "../../stores/busschools";
import { useRoute } from "vue-router";
import { onMounted } from "@vue/runtime-core";
import { ref } from "vue";
import { useStudentsStore } from "../../stores/students";
import { useDriversStore } from "../../stores/drivers";
import Spinner from "../layouts/Spinner.vue";
import MapBusSchoolInfos from "../maps/MapBusSchoolInfos.vue";
import BusSchoolStudentsList from "./BusSchoolStudentsList.vue";
import { useZoneStore } from "../../stores/zones";
import { useTrajectStore } from "../../stores/trajects";
import BusSchoolPlanning from "./BusSchoolPlanning.vue";
import EditBusSchool from "./EditBusSchool.vue";
import { usePlanningStore } from "../../stores/planning";
import StudentPlaceHolderTable from "../students/StudentPlaceHolderTable.vue";
import router from "../../router";
const route = useRoute();

const busSchoolsStore = useBusSchoolsStore();
const studentsStore = useStudentsStore();
const driversStore = useDriversStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
const planningStore = usePlanningStore();
const rerenderMap = ref(false);
let busschoolInfo = ref({});
let driverInfo = ref({});
let zoneInfo = ref({});
let trajectsInfo = ref([]);
let studentsInfo = ref([]);
const onReRender = () => {
    rerenderMap.value = true;
    setTimeout(() => {
        rerenderMap.value = false;
    }, 500);
};
const delAndUpdtSdtsZoneTraject = async (infos) => {
    if (infos.students) {
        console.log(infos);
        await studentsStore.deleteStudentsFromBusSchool(infos.students);
        await zonesStore.updateBusSchoolZone(infos.zone);
        await trajectsStore.updateBusSchoolTraject(infos.trajectGo);
        await trajectsStore.updateBusSchoolTraject(infos.trajectComeBack);
    } else {
        await zonesStore.updateBusSchoolZone(infos.zone);
    }
};
const updateData = async (infos) => {
    console.log(infos);
    if (infos.studentsToAdd || infos.studentsToDelete) {
        if (infos.studentsToDelete) {
            await studentsStore.deleteStudentsFromBusSchool(
                infos.studentsToDelete
            );
        }
        if (infos.studentsToAdd) {
            await studentsStore.addStudentsToBusSchool(infos.studentsToAdd);
        }
        await trajectsStore.updateBusSchoolTraject(infos.trajectGo);
        await trajectsStore.updateBusSchoolTraject(infos.trajectComeBack);
        if (infos.driverInfos) {
            await driversStore.updateDriver(infos.driverInfos);
        }
        if (infos.planningInfos) {
            await planningStore.updatePlanning(infos.planningInfos);
        }
        if (infos.busschoolInfos) {
            await busSchoolsStore.updateBusSchool(infos.busschoolInfos);
        }
    } else {
        if (infos.driverInfos) {
            await driversStore.updateDriver(infos.driverInfos);
        }
        if (infos.planningInfos) {
            await planningStore.updatePlanning(infos.planningInfos);
        }
        if (infos.busschoolInfos) {
            await busSchoolsStore.updateBusSchool(infos.busschoolInfos);
        }
    }
};
onMounted(() => {
    busSchoolsStore.busschools.map((busschool) => {
        if (busschool.id === parseInt(route.params.busschool_id)) {
            busschoolInfo.value = busschool;
        }
    });
    driversStore.drivers.map((driver) => {
        if (driver.bus_school_id === parseInt(route.params.busschool_id)) {
            driverInfo.value = driver;
        }
    });
    studentsStore.students.map((student) => {
        if (student.bus_school_id === parseInt(route.params.busschool_id)) {
            studentsInfo.value = studentsInfo.value.concat(student);
        }
    });
    zonesStore.zones.map((zone) => {
        if (zone.bus_school_id === parseInt(route.params.busschool_id)) {
            zoneInfo.value = zone;
        }
    });
    trajectsStore.trajects.map((traject) => {
        if (traject.bus_school_id === parseInt(route.params.busschool_id)) {
            trajectsInfo.value = trajectsInfo.value.concat(traject);
        }
    });
});
</script>
<template>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-bottom py-3">
                    <div class="row row-deck row-cards">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center mb-3">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <div class="col-auto">
                                            <span class="avatar avatar-xl"
                                                ><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-user"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                >
                                                    <desc>
                                                        Download more icon
                                                        variants from
                                                        https://tabler-icons.io/i/user
                                                    </desc>
                                                    <path
                                                        stroke="none"
                                                        d="M0 0h24v24H0z"
                                                        fill="none"
                                                    ></path>
                                                    <circle
                                                        cx="12"
                                                        cy="7"
                                                        r="4"
                                                    ></circle>
                                                    <path
                                                        d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                                    ></path></svg
                                            ></span>
                                        </div>
                                        <div class="col">
                                            <h3 class="m-0 mb-1">
                                                <a href="#">{{
                                                    driverInfo.name
                                                }}</a>
                                            </h3>
                                            <div
                                                class="text-muted text-truncate mb-2"
                                            >
                                                <span
                                                    class="badge badge-outline text-red"
                                                    ><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-mail"
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="2"
                                                        stroke="currentColor"
                                                        fill="none"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    >
                                                        <desc>
                                                            Download more icon
                                                            variants from
                                                            https://tabler-icons.io/i/mail
                                                        </desc>
                                                        <path
                                                            stroke="none"
                                                            d="M0 0h24v24H0z"
                                                            fill="none"
                                                        ></path>
                                                        <rect
                                                            x="3"
                                                            y="5"
                                                            width="18"
                                                            height="14"
                                                            rx="2"
                                                        ></rect>
                                                        <polyline
                                                            points="3 7 12 13 21 7"
                                                        ></polyline></svg
                                                ></span>
                                                {{ driverInfo.email }}
                                            </div>
                                            <div class="text-muted">
                                                <span
                                                    class="badge badge-outline text-indigo"
                                                    >CIN</span
                                                >
                                                {{ driverInfo.cin }}
                                            </div>
                                        </div>
                                        <div
                                            class="col m-0 p-0"
                                            style="align-self: flex-start"
                                        >
                                            <a
                                                v-if="!planningStore.loading"
                                                href="#"
                                                class="btn btn-icon btn-outline-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-report"
                                                aria-label="Facebook"
                                                style="margin-left: 80%"
                                            >
                                                <!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-edit"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                >
                                                    <desc>
                                                        Download more icon
                                                        variants from
                                                        https://tabler-icons.io/i/edit
                                                    </desc>
                                                    <path
                                                        stroke="none"
                                                        d="M0 0h24v24H0z"
                                                        fill="none"
                                                    ></path>
                                                    <path
                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"
                                                    ></path>
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"
                                                    ></path>
                                                    <path d="M16 5l3 3"></path>
                                                </svg>
                                            </a>
                                            <div
                                                v-if="planningStore.loading"
                                                class="spinner-border text-azure"
                                                style="
                                                    margin-left: 80%;
                                                    margin-top: 3%;
                                                "
                                                role="status"
                                            ></div>
                                        </div>
                                    </div>
                                    <BusSchoolStudentsList
                                        :students="studentsInfo"
                                    />

                                    <BusSchoolPlanning />
                                </div>
                                <div
                                    class="ribbon ribbon-top ribbon-start bg-info"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-steering-wheel"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <desc>
                                            Download more icon variants from
                                            https://tabler-icons.io/i/steering-wheel
                                        </desc>
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        ></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <circle cx="12" cy="12" r="2"></circle>
                                        <line
                                            x1="12"
                                            y1="14"
                                            x2="12"
                                            y2="21"
                                        ></line>
                                        <line
                                            x1="10"
                                            y1="12"
                                            x2="3.25"
                                            y2="10"
                                        ></line>
                                        <line
                                            x1="14"
                                            y1="12"
                                            x2="20.75"
                                            y2="10"
                                        ></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <MapBusSchoolInfos
                            v-if="
                                studentsInfo.length !== 0 &&
                                zoneInfo !== {} &&
                                trajectInfo !== {} &&
                                !rerenderMap
                            "
                            :students="studentsInfo"
                            :zone="zoneInfo"
                            :trajects="trajectsInfo"
                            :edit="true"
                            @rerender-map="onReRender"
                            @del-stds-updt-zone-traject="
                                delAndUpdtSdtsZoneTraject
                            "
                            @update-data="updateData"
                        />
                        <Spinner v-else-if="rerenderMap" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
