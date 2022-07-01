<script setup>
import { useUserStore } from "../../stores/user";
const auth = useUserStore();
</script>
<template>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">ADSELLO</div>
                    <h2 class="page-title">PFE-APP</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <!-- <span class="d-none d-sm-inline">
                            <a href="#" class="btn btn-white"> New view </a>
                        </span> -->
                        <router-link to="busschools/create" v-if="this.$route.name ==='busschoolslist'" class="btn btn-info active">
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
                                <line
                                    x1="12"
                                    y1="5"
                                    x2="12"
                                    y2="10"
                                ></line></svg
                            >Add Bus School
                        </router-link>
                        <a
                            href="#"
                            @click="auth.logout()"
                            class="btn btn-outline-danger d-none d-sm-inline"
                        >
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-logout"
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
                                    https://tabler-icons.io/i/logout
                                </desc>
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"
                                ></path>
                                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                            </svg>
                            Sign Out
                        </a>

                        <a
                            href="#"
                            class="btn btn-outline-danger d-sm-none btn-icon"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-report"
                            aria-label="Create new report"
                        >
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-logout"
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
                                    https://tabler-icons.io/i/logout
                                </desc>
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"
                                ></path>
                                <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
