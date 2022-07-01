<script setup>
import { useStudentsStore } from "../../stores/students";
import BusSchoolStudentItem from "./BusSchoolStudentItem.vue";
import { toRefs } from "@vue/reactivity";
const props = defineProps({
    students: Array,
});
const { students } = toRefs(props);
</script>

<template>
    <div class="col-md">
        <div class="card">
            <div class="card-status-top bg-green"></div>
            <div class="card-header">
                <h3 class="card-title">Students List</h3>
            </div>
            <div class="card-body">
                <div class="row g-3 overflow-auto" style="max-height: 235px">
                    <BusSchoolStudentItem
                        :key="student"
                        v-for="student in students"
                        :student="student"
                        :del="false"
                        :add="false"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
