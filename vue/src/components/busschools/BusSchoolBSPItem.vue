<script setup>
import BusSchoolDriverInfos from "./BusSchoolDriverInfos.vue";
import BusSchoolStudentsList from "./BusSchoolStudentsList.vue";
import MapBusSchoolInfos from "../maps/MapBusSchoolInfos.vue";
import { toRefs } from "@vue/reactivity";
import { useDriversStore } from "../../stores/drivers";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";
import { useTrajectStore } from "../../stores/trajects";

const props = defineProps({
    busSchool: Object,
});
const { busSchool } = toRefs(props);
const driversStore = useDriversStore();
const studentsStore = useStudentsStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
</script>
<template>
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <span class="badge bg-azure m-1"
                    ><svg
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
                        <line x1="12" y1="14" x2="12" y2="21"></line>
                        <line x1="10" y1="12" x2="3.25" y2="10"></line>
                        <line x1="14" y1="12" x2="20.75" y2="10"></line>
                    </svg>
                    {{
                        " " +
                        driversStore.drivers.filter(
                            (driver) => driver.bus_school_id === busSchool.id
                        )[0].name
                    }}
                </span>

                <span class="badge bg-teal m-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-a-b"
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
                            https://tabler-icons.io/i/a-b
                        </desc>
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <path
                            d="M3 16v-5.5a2.5 2.5 0 0 1 5 0v5.5m0 -4h-5"
                        ></path>
                        <line x1="12" y1="6" x2="12" y2="18"></line>
                        <path
                            d="M16 16v-8h3a2 2 0 0 1 0 4h-3m3 0a2 2 0 0 1 0 4h-3"
                        ></path>
                    </svg>
                    {{ " " + busSchool.matricule }}
                </span>

                <span class="badge bg-yellow m-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-yoga"
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
                            https://tabler-icons.io/i/yoga
                        </desc>
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <circle cx="12" cy="4" r="1"></circle>
                        <path d="M4 20h4l1.5 -3"></path>
                        <path d="M17 20l-1 -5h-5l1 -7"></path>
                        <path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg
                    >{{
                        " " +
                        studentsStore.students.filter(
                            (student) => student.bus_school_id === busSchool.id
                        ).length +
                        "/" +
                        busSchool.capacity
                    }}</span
                >
            </h3>
            <div class="card-actions">
                <router-link
                    :to="`busschools/${busSchool.id}/reel-time`"
                    class="btn btn-ghost-secondary"
                    style="margin-right: 10px"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-current-location"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <circle cx="12" cy="12" r="3"></circle>
                        <circle cx="12" cy="12" r="8"></circle>
                        <line x1="12" y1="2" x2="12" y2="4"></line>
                        <line x1="12" y1="20" x2="12" y2="22"></line>
                        <line x1="20" y1="12" x2="22" y2="12"></line>
                        <line x1="2" y1="12" x2="4" y2="12"></line>
                    </svg>
                    Tracking
                </router-link>
                <router-link
                    :to="`busschools/${busSchool.id}`"
                    class="btn btn-info"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-eye"
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
                            https://tabler-icons.io/i/eye
                        </desc>
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <circle cx="12" cy="12" r="2"></circle>
                        <path
                            d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"
                        ></path>
                    </svg>
                    See more
                </router-link>
            </div>
        </div>
        <div class="card-body">
            <div class="row row-cards">
                <BusSchoolDriverInfos
                    :driver="
                        driversStore.drivers.filter(
                            (driver) => driver.bus_school_id === busSchool.id
                        )[0]
                    "
                />
                <BusSchoolStudentsList
                    :students="
                        studentsStore.students.filter(
                            (student) => student.bus_school_id === busSchool.id
                        )
                    "
                />
                <MapBusSchoolInfos
                    :students="
                        studentsStore.students.filter(
                            (student) => student.bus_school_id === busSchool.id
                        )
                    "
                    :zone="
                        zonesStore.zones.filter(
                            (zone) => zone.bus_school_id === busSchool.id
                        )[0]
                    "
                    :trajects="
                        trajectsStore.trajects.filter(
                            (traject) => traject.bus_school_id === busSchool.id
                        )
                    "
                    :edit="false"
                />
            </div>
        </div>
    </div>
</template>
