<script setup>
import { toRefs } from "@vue/reactivity";
import { ref, defineEmits } from "vue";
const props = defineProps({
    driver: Object,
});
const { driver } = toRefs(props);
let driverName = ref(driver.value.name);
let driverEmail = ref( driver.value.email);
let driverCIN = ref(driver.value.cin);
const edit = ref(false);
const changeEditStatus = () => {
    edit.value = !edit.value;
};
</script>
<template>
    <div class="col-md">
        <div class="card">
            <div class="card-status-top bg-red"></div>
            <div class="card-header">
                <h3 class="card-title">Driver Info</h3>
                
            </div>
            <div  class="card-body p-4 text-center">
                <span class="avatar avatar-xl mb-3 avatar-rounded">DR</span>
                <h3 class="m-0 mb-1">
                    <a href="#">{{ driver.name }}</a>
                </h3>
                <div class="text-muted">
                    <span class="badge badge-outline text-red"
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
                                Download more icon variants from
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
                            <polyline points="3 7 12 13 21 7"></polyline></svg
                    ></span>

                    {{ driver.email }}
                    <span class="badge badge-outline text-indigo">CIN</span>

                    {{ driver.cin }}
                </div>
            </div>
           
        </div>
    </div>
</template>
