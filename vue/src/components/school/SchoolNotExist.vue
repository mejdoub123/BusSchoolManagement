<script setup>
import { useSchoolStore } from "../../stores/school";
const schoolStore = useSchoolStore();
</script>
<template>
    <div class="container-tight py-4" v-show="!schoolStore.loading">
        <div class="empty">
            <div class="empty-img">
                <img
                    src="../../assets/undraw_quitting_time_dm8t.svg"
                    height="128"
                    alt=""
                />
            </div>
            <p class="empty-title">Please add a school to manage</p>
            <p class="empty-subtitle text-muted">
                Sorry for the inconvenience but you didn't add any school yet!
            </p>
            <div class="empty-action">
                <router-link to="create" class="btn btn-primary">
                    <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon dropdown-item-icon"
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
                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                    </svg>
                    Add your school
                </router-link>
            </div>
        </div>
    </div>
</template>
