<script setup>
import { onMounted, ref } from "vue";
import router from "../../router";
import { useStudentsStore } from "../../stores/students";
import StudentsTableItem from "./StudentsTableItem.vue";
import StudentPlaceHolderTable from "./StudentPlaceHolderTable.vue";

const loading = ref(false);

const studentsStore = useStudentsStore();
const students = ref([...studentsStore.students]);
const pageOfItems = ref([]);
const onChangePage = (pageOfItem) => {
    pageOfItems.value = pageOfItem;
};
onMounted(() => {
    if (studentsStore.students.length === 0 && !studentsStore.loading) {
        router.push("students/notfound");
    }
});
</script>
<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Students List</h3>
                <div class="card-actions btn-actions">
                    <router-link
                        class="btn btn-primary ms-auto"
                        to="students/create"
                    >
                        Add new Student
                    </router-link>
                </div>
            </div>
            <div v-if="!studentsStore.loading" class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Bus School</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <StudentsTableItem
                            :key="student.id"
                            v-for="student in studentsStore.students"
                            :student="student"
                        />
                    </tbody>
                </table>
            </div>
            <StudentPlaceHolderTable v-if="studentsStore.loading" />
            <div class="card-footer d-flex align-items-center"></div>
        </div>
    </div>
</template>
