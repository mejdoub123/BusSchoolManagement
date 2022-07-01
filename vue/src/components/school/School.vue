<script setup>
import SchoolNotExist from "./SchoolNotExist.vue";
import AddSchool from "./AddSchool.vue";
import SchoolInfo from "./SchoolInfo.vue";
import { useSchoolStore } from "../../stores/school";
import { useUserStore } from "../../stores/user";
import { useBusSchoolsStore } from "../../stores/busschools";
import { onMounted, ref } from "vue";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";
import router from "../../router";
const userStore = useUserStore();
const schoolStore = useSchoolStore();
const busSchoolsStore = useBusSchoolsStore();
const studentsStore = useStudentsStore();
const zonesStore = useZoneStore();

</script>
<template>
    <div>
        <div class="row row-deck row-cards">
            <router-view></router-view>
        </div>
    </div>
</template>
