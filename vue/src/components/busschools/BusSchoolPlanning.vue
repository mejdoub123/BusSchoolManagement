<script setup>
import { onMounted } from "@vue/runtime-core";
import { useRoute } from "vue-router";
import { ref } from "vue";
import { usePlanningStore } from "../../stores/planning";
const route = useRoute();
const planningStore = usePlanningStore();
const planningInfo = ref({});
onMounted(async () => {
    await planningStore.fetchBusSchoolPlanning(
        parseInt(route.params.busschool_id)
    );
    planningInfo.value = { ...planningStore.planning };
});
</script>
<template>
    <div v-if="!planningStore.loading" class="card mt-3">
        <div class="card-body">
            <div id="accordion-example">
                <h3 id="heading-1">
                    <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse-1"
                        aria-expanded="true"
                    >
                        <h3 class="card-title">Planning</h3>
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                    <line x1="16" y1="3" x2="16" y2="7"></line>
                    <line x1="8" y1="3" x2="8" y2="7"></line>
                    <line x1="4" y1="11" x2="20" y2="11"></line>
                    <line x1="11" y1="15" x2="12" y2="15"></line>
                    <line x1="12" y1="15" x2="12" y2="18"></line>
                </svg>
            </div>
            <div
                class="accordion-collapse collapse row"
                id="collapse-1"
                data-bs-parent="#accordion-example"
            >
                <div class="mb-3">
                    <div>
                        <label class="form-label">Monday</label>
                        <div class="row">
                            <div class="col-lg-3 w-50">
                                <label
                                    class="form-label"
                                    style="font-size: 12px"
                                    >Go at</label
                                >
                                <input
                                    type="time"
                                    :value="`${planningInfo.monday_go_at}`"
                                    class="form-control"
                                    disabled
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
                                    :value="`${planningInfo.monday_comeback_at}`"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <label class="form-label">Tuesday</label>
                        <div class="row">
                            <div class="col-lg-3 w-50">
                                <label
                                    class="form-label"
                                    style="font-size: 12px"
                                    >Go at</label
                                >
                                <input
                                    type="time"
                                    :value="`${planningInfo.tuesday_go_at}`"
                                    class="form-control"
                                    disabled
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
                                    :value="`${planningInfo.tuesday_comeback_at}`"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <label class="form-label">Wednesday</label>
                        <div class="row">
                            <div class="col-lg-3 w-50">
                                <label
                                    class="form-label"
                                    style="font-size: 12px"
                                    >Go at</label
                                >
                                <input
                                    type="time"
                                    :value="`${planningInfo.wednesday_go_at}`"
                                    class="form-control"
                                    disabled
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
                                    :value="`${planningInfo.wednesday_comeback_at}`"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <label class="form-label">Thursday</label>
                        <div class="row">
                            <div class="col-lg-3 w-50">
                                <label
                                    class="form-label"
                                    style="font-size: 12px"
                                    >Go at</label
                                >
                                <input
                                    type="time"
                                    :value="`${planningInfo.thursday_go_at}`"
                                    class="form-control"
                                    disabled
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
                                    :value="`${planningInfo.thursday_comeback_at}`"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div>
                        <label class="form-label">Friday</label>
                        <div class="row">
                            <div class="col-lg-3 w-50">
                                <label
                                    class="form-label"
                                    style="font-size: 12px"
                                    >Go at</label
                                >
                                <input
                                    type="time"
                                    :value="`${planningInfo.friday_go_at}`"
                                    class="form-control"
                                    disabled
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
                                    :value="`${planningInfo.friday_comeback_at}`"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="card mt-3">
        <div class="card-body">
            <div class="placeholder col-9 mb-3"></div>
            <div class="placeholder placeholder-xs col-10"></div>
            <div class="placeholder placeholder-xs col-11"></div>
        </div>
    </div>
</template>
