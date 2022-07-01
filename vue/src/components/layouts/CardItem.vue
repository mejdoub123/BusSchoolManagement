<script setup>
import { toRefs } from "@vue/reactivity";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useDriversStore } from "../../stores/drivers";
import { useSchoolStore } from "../../stores/school";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";

const props = defineProps({
    type_data: String,
});
const { type_data } = toRefs(props);
const studentsStore = useStudentsStore();
const driversStore = useDriversStore();
const busschoolsStore = useBusSchoolsStore();
const zonesStore = useZoneStore();
const schoolStore = useSchoolStore();
</script>
<template>
    <div v-if="!schoolStore.loading" class="col-sm-6 col-lg-3">
        <div
            v-if="
                !studentsStore.loading &&
                !driversStore.loading &&
                !busschoolsStore.loading &&
                !zonesStore.loading
            "
            class="card card-sm"
        >
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span
                            v-if="type_data === 'Students'"
                            class="bg-azure text-white avatar"
                            ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
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
                                />
                                <circle cx="12" cy="4" r="1" />
                                <path d="M4 20h4l1.5 -3" />
                                <path d="M17 20l-1 -5h-5l1 -7" />
                                <path d="M4 10l4 -1l4 -1l4 1.5l4 1.5" />
                            </svg>
                        </span>
                        <span
                            v-if="type_data === 'Busschools'"
                            class="bg-yellow text-white avatar"
                            ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
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
                                <line x1="2" y1="10" x2="17" y2="10"></line>
                                <line x1="7" y1="5" x2="7" y2="10"></line>
                                <line x1="12" y1="5" x2="12" y2="10"></line>
                            </svg>
                        </span>
                        <span
                            v-if="type_data === 'Drivers'"
                            class="bg-cyan text-white avatar"
                            ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
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
                                />
                                <circle cx="12" cy="12" r="9" />
                                <circle cx="12" cy="12" r="2" />
                                <line x1="12" y1="14" x2="12" y2="21" />
                                <line x1="10" y1="12" x2="3.25" y2="10" />
                                <line x1="14" y1="12" x2="20.75" y2="10" />
                            </svg>
                        </span>
                        <span
                            v-if="type_data === 'Zones'"
                            class="bg-lime text-white avatar"
                            ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-polygon"
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
                                    https://tabler-icons.io/i/polygon
                                </desc>
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <circle cx="12" cy="5" r="2"></circle>
                                <circle cx="19" cy="8" r="2"></circle>
                                <circle cx="5" cy="11" r="2"></circle>
                                <circle cx="15" cy="19" r="2"></circle>
                                <path d="M6.5 9.5l3.5 -3"></path>
                                <path d="M14 5.5l3 1.5"></path>
                                <path d="M18.5 10l-2.5 7"></path>
                                <path d="M13.5 17.5l-7 -5"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">{{ type_data }}</div>
                        <div class="text-muted">
                            {{
                                type_data === "Students"
                                    ? studentsStore.students.length + " Student"
                                    : type_data === "Busschools"
                                    ? busschoolsStore.busschools.length +
                                      " Busschool"
                                    : type_data === "Drivers"
                                    ? driversStore.drivers.length + " Driver"
                                    : zonesStore.zones.length + " Zone"
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="
                studentsStore.loading ||
                driversStore.loading ||
                busschoolsStore.loading ||
                zonesStore.loading
            "
            class="card card-sm"
        >
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <div class="avatar avatar-rounded placeholder"></div>
                    </div>
                    <div class="col">
                        <div class="placeholder placeholder-xs col-9"></div>
                        <div class="placeholder placeholder-xs col-7"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
