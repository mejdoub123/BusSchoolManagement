<script setup>
import BusSchoolPlanning from "./BusSchoolPlanning.vue";
import BusSchoolStudentItem from "./BusSchoolStudentItem.vue";
import { ref, onMounted, toRef } from "vue";
import { toRefs } from "@vue/reactivity";
import { usePlanningStore } from "../../stores/planning";

import { useStudentsStore } from "../../stores/students";
import AddBsStdtsPlaceHolder from "./AddBsStdtsPlaceHolder.vue";
import { useDriversStore } from "../../stores/drivers";
import { useBusSchoolsStore } from "../../stores/busschools";
const props = defineProps({
    busschool: Object,
    driver: Object,
    students: Array,
    zone_id: Number,
});
const { busschool, driver, students, zone_id } = toRefs(props);
const emit = defineEmits(["update-data"]);
const planningStore = usePlanningStore();
const studentsStore = useStudentsStore();
const driverStore = useDriversStore();
const busschoolStore = useBusSchoolsStore();
const studentsInterZone = ref([]);
const studentsZone = ref([...students.value]);
const driverBusschool = ref({ ...driver.value });
const busschoolInfo = ref({ ...busschool.value });
const studentsToAdd = ref([]);
const studentsToDelete = ref([]);
const planningInfo = ref({});
const getStudentsIntersectZone = async () => {
    await studentsStore.fetchStudentsIntersectZone(zone_id.value);
    studentsInterZone.value = studentsStore.studentsIntZone;
    studentsStore.removeStudentsIntZone();
};
const addStudent = (studentInfo) => {
    studentsInterZone.value = studentsInterZone.value.filter(
        (student) => student.id !== studentInfo.id
    );
    studentsToAdd.value = [...studentsToAdd.value, studentInfo];
    studentsZone.value = [...studentsZone.value, studentInfo];
};
const deleteStudent = (studentInfo) => {
    studentsZone.value = studentsZone.value.filter(
        (student) => student.id !== studentInfo.id
    );
    studentsToDelete.value = [...studentsToDelete.value, studentInfo];
};
const updateData = async () => {
    var updateInfosBsSchool = {};
    if (studentsToAdd.value.length > 0) {
        const studentsInfo = {
            students: studentsToAdd.value,
            zone_id: zone_id.value,
            bus_school_id: busschool.value.id,
        };
        updateInfosBsSchool.studentsToAdd = { ...studentsInfo };
        // await studentsStore.addStudentsToBusSchool(studentsInfo);
    }
    if (studentsToDelete.value.length > 0) {
        updateInfosBsSchool.studentsToDelete = [...studentsToDelete.value];
        // await studentsStore.deleteStudentsFromBusSchool(studentsToDelete.value);
    }
    if (
        busschoolInfo.value.matricule !== busschool.value.matricule ||
        busschoolInfo.value.capacity !== busschool.value.capacity
    ) {
        if (busschoolInfo.value.matricule === busschool.value.matricule) {
            busschoolInfo.value.matricule = null;
        }
        if (busschoolInfo.value.capacity === busschool.value.capacity) {
            busschoolInfo.value.capacity = null;
        }
        updateInfosBsSchool.busschoolInfos = { ...busschoolInfo.value };
        // await busschoolStore.updateBusSchool(busschoolInfo.value);
    }
    if (
        driverBusschool.value.cin !== driver.value.cin ||
        driverBusschool.value.name !== driver.value.name ||
        driverBusschool.value.email !== driver.value.email
    ) {
        if (driverBusschool.value.cin === driver.value.cin) {
            driverBusschool.value.cin = null;
        }
        if (driverBusschool.value.name === driver.value.name) {
            driverBusschool.value.name = null;
        }
        if (driverBusschool.value.email === driver.value.email) {
            driverBusschool.value.email = null;
        }
        updateInfosBsSchool.driverInfos = { ...driverBusschool.value };
        // await driverStore.updateDriver(driverBusschool.value);
    }
    if (
        planningInfo.value.monday_go_at !==
            planningStore.planning.monday_go_at ||
        planningInfo.value.monday_comeback_at !==
            planningStore.planning.monday_comeback_at ||
        planningInfo.value.tuesday_go_at !==
            planningStore.planning.tuesday_go_at ||
        planningInfo.value.tuesday_comeback_at !==
            planningStore.planning.tuesday_go_at ||
        planningInfo.value.wednesday_go_at !==
            planningStore.planning.wednesday_go_at ||
        planningInfo.value.wednesday_comeback_at !==
            planningStore.planning.wednesday_comeback_at ||
        planningInfo.value.thursday_go_at !==
            planningStore.planning.thursday_go_at ||
        planningInfo.value.thursday_comeback_at !==
            planningStore.planning.thursday_comeback_at ||
        planningInfo.value.friday_go_at !==
            planningStore.planning.friday_go_at ||
        planningInfo.value.friday_comeback_at !==
            planningStore.planning.friday_comeback_at
    ) {
        if (
            planningInfo.value.monday_go_at ===
            planningStore.planning.monday_go_at
        ) {
            planningInfo.value.monday_go_at = null;
        }
        if (
            planningInfo.value.monday_comeback_at ===
            planningStore.planning.monday_comeback_at
        ) {
            planningInfo.value.monday_comeback_at = null;
        }
        if (
            planningInfo.value.tuesday_go_at ===
            planningStore.planning.tuesday_go_at
        ) {
            planningInfo.value.tuesday_go_at = null;
        }
        if (
            planningInfo.value.tuesday_comeback_at ===
            planningStore.planning.tuesday_comeback_at
        ) {
            planningInfo.value.tuesday_comeback_at = null;
        }
        if (
            planningInfo.value.wednesday_go_at ===
            planningStore.planning.wednesday_go_at
        ) {
            planningInfo.value.wednesday_go_at = null;
        }
        if (
            planningInfo.value.wednesday_comeback_at ===
            planningStore.planning.wednesday_comeback_at
        ) {
            planningInfo.value.wednesday_comeback_at = null;
        }
        if (
            planningInfo.value.thursday_go_at ===
            planningStore.planning.thursday_go_at
        ) {
            planningInfo.value.thursday_go_at = null;
        }
        if (
            planningInfo.value.thursday_comeback_at ===
            planningStore.planning.thursday_comeback_at
        ) {
            planningInfo.value.thursday_comeback_at = null;
        }
        if (
            planningInfo.value.friday_go_at ===
            planningStore.planning.friday_go_at
        ) {
            planningInfo.value.friday_go_at = null;
        }
        if (
            planningInfo.value.friday_comeback_at ===
            planningStore.planning.friday_comeback_at
        ) {
            planningInfo.value.friday_comeback_at = null;
        }
        updateInfosBsSchool.planningInfos = { ...planningInfo.value };
        // await planningStore.updatePlanning(planningInfo.value);
    }
    emit("update-data", updateInfosBsSchool);
};
onMounted(() => {
    planningInfo.value = { ...planningStore.planning };
});
</script>
<template>
    <div
        class="modal modal-blur fade"
        id="modal-report"
        tabindex="-1"
        style="display: none"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
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
                                Download more icon variants from
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
                        Edit
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div
                    class="list-group list-group-flush overflow-auto"
                    style="max-height: 40rem"
                >
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div id="accordion-example">
                                    <h3 id="heading-2">
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-2"
                                            aria-expanded="true"
                                        >
                                            <h3 class="card-title">
                                                Bus School
                                            </h3>
                                        </button>
                                    </h3>
                                </div>

                                <div class="ribbon ribbon-top bg-yellow">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-bus"
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
                                            https://tabler-icons.io/i/bus
                                        </desc>
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        ></path>
                                        <circle cx="6" cy="17" r="2"></circle>
                                        <circle cx="18" cy="17" r="2"></circle>
                                        <path
                                            d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"
                                        ></path>
                                        <polyline
                                            points="16 5 17.5 12 22 12"
                                        ></polyline>
                                        <line
                                            x1="2"
                                            y1="10"
                                            x2="17"
                                            y2="10"
                                        ></line>
                                        <line
                                            x1="7"
                                            y1="5"
                                            x2="7"
                                            y2="10"
                                        ></line>
                                        <line
                                            x1="12"
                                            y1="5"
                                            x2="12"
                                            y2="10"
                                        ></line>
                                    </svg>
                                </div>
                                <div
                                    class="accordion-collapse collapse row"
                                    id="collapse-2"
                                    data-bs-parent="#accordion-example"
                                >
                                    <div class="mb-3">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Matricule</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            busschoolInfo.matricule
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Capacity</label
                                                    >
                                                    <input
                                                        type="number"
                                                        v-model="
                                                            busschoolInfo.capacity
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div id="accordion-example">
                                    <h3 id="heading-3">
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-3"
                                            aria-expanded="true"
                                        >
                                            <h3 class="card-title">
                                                Bus School Driver
                                            </h3>
                                        </button>
                                    </h3>
                                </div>

                                <div class="ribbon ribbon-top bg-info">
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
                                <div
                                    class="accordion-collapse collapse row"
                                    id="collapse-3"
                                    data-bs-parent="#accordion-example"
                                >
                                    <div class="mb-3">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Name</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            driverBusschool.name
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Email</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            driverBusschool.email
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50 mt-1">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >CIN</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            driverBusschool.cin
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div id="accordion-example">
                                    <h3 id="heading-4">
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-4"
                                            aria-expanded="true"
                                        >
                                            <h3 class="card-title">
                                                Bus School Students
                                            </h3>
                                        </button>
                                    </h3>
                                </div>

                                <div class="ribbon ribbon-top bg-purple">
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
                                        <path
                                            d="M4 10l4 -1l4 -1l4 1.5l4 1.5"
                                        ></path>
                                    </svg>
                                </div>
                                <div
                                    class="accordion-collapse collapse row"
                                    id="collapse-4"
                                    data-bs-parent="#accordion-example"
                                >
                                    <div class="mb-3">
                                        <div
                                            v-if="
                                                studentsInterZone.length === 0
                                            "
                                            class="card-header mb-3"
                                        >
                                            <div class="card-actions">
                                                <a
                                                    @click="
                                                        getStudentsIntersectZone
                                                    "
                                                    href="#"
                                                    class="btn btn-primary btn-icon"
                                                >
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="icon"
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
                                                            https://tabler-icons.io/i/plus
                                                        </desc>
                                                        <path
                                                            stroke="none"
                                                            d="M0 0h24v24H0z"
                                                            fill="none"
                                                        ></path>
                                                        <line
                                                            x1="12"
                                                            y1="5"
                                                            x2="12"
                                                            y2="19"
                                                        ></line>
                                                        <line
                                                            x1="5"
                                                            y1="12"
                                                            x2="19"
                                                            y2="12"
                                                        ></line>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                !studentsStore.loadingAdd &&
                                                studentsInterZone.length > 0
                                            "
                                            class="card mb-2"
                                        >
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Student(s) to add
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div
                                                    class="row g-3 overflow-auto"
                                                    style="max-height: 235px"
                                                >
                                                    <BusSchoolStudentItem
                                                        :key="student"
                                                        v-for="student in studentsInterZone"
                                                        :student="student"
                                                        :del="false"
                                                        :add="true"
                                                        @add-student="
                                                            addStudent
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-else-if="studentsStore.loadingAdd"
                                            class="card mb-2"
                                        >
                                            <AddBsStdtsPlaceHolder />
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Students List
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div
                                                    class="row g-3 overflow-auto"
                                                    style="max-height: 235px"
                                                >
                                                    <BusSchoolStudentItem
                                                        :key="student"
                                                        v-for="student in studentsZone"
                                                        :student="student"
                                                        :del="true"
                                                        :add="false"
                                                        @delete-student="
                                                            deleteStudent
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div id="accordion-example">
                                    <h3 id="heading-5">
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-5"
                                            aria-expanded="true"
                                        >
                                            <h3 class="card-title">
                                                Bus School Planning
                                            </h3>
                                        </button>
                                    </h3>
                                </div>

                                <div class="ribbon ribbon-top bg-lime">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-calendar"
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
                                            https://tabler-icons.io/i/calendar
                                        </desc>
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        ></path>
                                        <rect
                                            x="4"
                                            y="5"
                                            width="16"
                                            height="16"
                                            rx="2"
                                        ></rect>
                                        <line
                                            x1="16"
                                            y1="3"
                                            x2="16"
                                            y2="7"
                                        ></line>
                                        <line
                                            x1="8"
                                            y1="3"
                                            x2="8"
                                            y2="7"
                                        ></line>
                                        <line
                                            x1="4"
                                            y1="11"
                                            x2="20"
                                            y2="11"
                                        ></line>
                                        <line
                                            x1="11"
                                            y1="15"
                                            x2="12"
                                            y2="15"
                                        ></line>
                                        <line
                                            x1="12"
                                            y1="15"
                                            x2="12"
                                            y2="18"
                                        ></line>
                                    </svg>
                                </div>
                                <div
                                    class="accordion-collapse collapse row"
                                    id="collapse-5"
                                    data-bs-parent="#accordion-example"
                                >
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label"
                                                >Monday</label
                                            >
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Go at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.monday_go_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Come at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.monday_comeback_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label"
                                                >Tuesday</label
                                            >
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Go at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.tuesday_go_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Come at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.tuesday_comeback_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label"
                                                >Wednesday</label
                                            >
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Go at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.wednesday_go_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Come at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.wednesday_comeback_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label"
                                                >Thursday</label
                                            >
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Go at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.thursday_go_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Come at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.thursday_comeback_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label"
                                                >Friday</label
                                            >
                                            <div class="row">
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Go at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.friday_go_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="col-lg-3 w-50">
                                                    <label
                                                        class="form-label"
                                                        style="font-size: 12px"
                                                        >Come at</label
                                                    >
                                                    <input
                                                        type="time"
                                                        v-model="
                                                            planningInfo.friday_comeback_at
                                                        "
                                                        class="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        class="btn btn-link link-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button
                        @click="updateData"
                        class="btn btn-success ms-auto"
                        data-bs-dismiss="modal"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-device-floppy"
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
                                https://tabler-icons.io/i/device-floppy
                            </desc>
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <path
                                d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
                            ></path>
                            <circle cx="12" cy="14" r="2"></circle>
                            <polyline points="14 4 14 8 8 8 8 4"></polyline>
                        </svg>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
