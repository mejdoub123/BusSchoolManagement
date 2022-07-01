<script setup>
import { toRefs } from "@vue/reactivity";
import { onMounted, watch, ref, onActivated } from "@vue/runtime-core";
import { useDriversStore } from "../../stores/drivers";

const props = defineProps({
    busSchool: Object,
});
const { busSchool } = toRefs(props);
const driversStore = useDriversStore();
</script>
<template>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col-auto">
                <span class="badge"></span>
            </div>
            <div class="col-auto">
                <a href="#">
                    <span
                        class="avatar"
                        style="
                            background-image: url('/src/assets/Bus-School-Icon.png');
                        "
                    ></span>
                </a>
            </div>
            <div class="col text-truncate">
                <a href="#" class="text-reset d-block">{{
                    busSchool.matricule
                }}</a>
                <div
                    v-if="driversStore.loading || !driversStore.driversData"
                    class="spinner-border spinner-border-sm"
                    style="margin-left: 10%; margin-top: 1%"
                    role="status"
                ></div>
                <div
                    v-if="!driversStore.loading && driversStore.driversData"
                    class="d-block text-muted text-truncate mt-n1"
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
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="12" cy="12" r="9" />
                        <circle cx="12" cy="12" r="2" />
                        <line x1="12" y1="14" x2="12" y2="21" />
                        <line x1="10" y1="12" x2="3.25" y2="10" />
                        <line x1="14" y1="12" x2="20.75" y2="10" />
                    </svg>

                    {{
                        driversStore.drivers.filter(
                            (driver) => driver.bus_school_id === busSchool.id
                        )[0].name
                    }}

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
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="12" cy="4" r="1" />
                        <path d="M4 20h4l1.5 -3" />
                        <path d="M17 20l-1 -5h-5l1 -7" />
                        <path d="M4 10l4 -1l4 -1l4 1.5l4 1.5" />
                    </svg>
                    {{ busSchool.capacity }}
                </div>
            </div>
            <div class="col-auto">
                <router-link
                    :to="`/admin/busschools/${busSchool.id}`"
                    class="list-group-item-actions"
                    ><!-- Download SVG icon from http://tabler-icons.io/i/star -->
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
                </router-link>
            </div>
        </div>
    </div>
</template>
