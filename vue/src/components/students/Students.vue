<script setup>
import { useStudentsStore } from "../../stores/students";
import AddStudent from "./AddStudent.vue";
import StudentsTable from "./StudentsTable.vue";
const studentsStore = useStudentsStore();
</script>
<template>
    <div>
        
        <router-view></router-view>
        <!-- <AddStudent v-if="studentsStore.create === true" />
        <StudentsTable v-if="studentsStore.create === false" /> -->
    </div>
</template>
