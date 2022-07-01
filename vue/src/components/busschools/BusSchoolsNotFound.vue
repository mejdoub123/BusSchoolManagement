<script setup>
import BusSchoolsNotExist from "./BusSchoolsNotExist.vue";
</script>
<template>
    <div class="col-6" style="margin-top: 20%; margin-left: 20%">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <h3 class="mb-1" style="margin-top: 1%">
                This School doesn't have any bus schools yet !
            </h3>
            <p style="margin-bottom: 10%">
                Do you have some bus schools not added yet ?
            </p>
            <div class="btn-list">
                <router-link
                    to="/admin/busschools/create"
                    class="btn btn btn-success"
                >
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
                        <polyline points="16 5 17.5 12 22 12"></polyline>
                        <line x1="2" y1="10" x2="17" y2="10"></line>
                        <line x1="7" y1="5" x2="7" y2="10"></line>
                        <line x1="12" y1="5" x2="12" y2="10"></line>
                    </svg>
                    Add Bus School</router-link
                >

                <router-link to="/admin/school" class="btn">Cancel</router-link>
            </div>
        </div>
    </div>
</template>
