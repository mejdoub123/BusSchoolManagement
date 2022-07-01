<script setup>
import L from "leaflet";
import { onMounted } from "vue";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useSchoolStore } from "../../stores/school";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";
import MapSchoolInfos from "../maps/MapSchoolInfos.vue";
import { useUserStore } from "../../stores/user";
import Spinner from "../layouts/Spinner.vue";
import router from "../../router";
import MapSpinner from "../layouts/MapSpinner.vue";
import PlaceHolderBusSchoolsList from "../busschools/PlaceHolderBusSchoolsList.vue";
import BusSchoolList from "../busschools/BusSchoolHPList.vue";
import BusSchoolsNotExist from "../busschools/BusSchoolsNotExist.vue";
import CardItem from "../layouts/CardItem.vue";
import { useDriversStore } from "../../stores/drivers";
import { useTrajectStore } from "../../stores/trajects";
const userStore = useUserStore();
const schoolStore = useSchoolStore();
const busSchoolsStore = useBusSchoolsStore();
const studentsStore = useStudentsStore();
const driversStore = useDriversStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
const items = ["Students", "Busschools", "Drivers", "Zones"];
onMounted(async () => {
    if (!schoolStore.schoolInfos) {
        await schoolStore.fetchSchool(userStore.user.profile_id);
        if (!schoolStore.schoolInfos) {
            router.push("school/notfound");
            return;
        } else if (schoolStore.schoolInfos) {
            await busSchoolsStore.fetchBusSchools(schoolStore.school.id);
            await studentsStore.fetchSchoolStudents(schoolStore.school.id);
            await driversStore.fetchSchoolDrivers(schoolStore.school.id);
            await zonesStore.fetchSchoolZones(schoolStore.school.id);
            await trajectsStore.getSchoolTrajects(schoolStore.school.id);
            return;
        }
    }
});
</script>
<template>
    <div class="row row-cards">
        <CardItem :key="item" v-for="item in items" :type_data="item" />
        <div v-if="!schoolStore.loading" class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ schoolStore.school.name }}</h3>
                </div>
                <div class="card-body border-bottom py-3">
                    <div class="row row-deck row-cards">
                        <div class="col-lg-6">
                            <div class="row row-cards">
                                <div class="col-12">
                                    <div class="card">
                                        <MapSchoolInfos
                                            v-if="
                                                schoolStore.schoolInfos &&
                                                !studentsStore.loading &&
                                                !busSchoolsStore.loading &&
                                                !zonesStore.loading &&
                                                !trajectsStore.loading
                                            "
                                        />
                                        <MapSpinner
                                            v-if="
                                                studentsStore.loading ||
                                                busSchoolsStore.loading ||
                                                zonesStore.loading ||
                                                trajectsStore.loading
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row row-cards">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Bus Schools
                                            </h3>
                                        </div>
                                        <PlaceHolderBusSchoolsList
                                            v-if="busSchoolsStore.loading"
                                        />
                                        <BusSchoolList
                                            v-if="
                                                busSchoolsStore.busSchoolsInfos &&
                                                !busSchoolsStore.loading
                                            "
                                        />
                                        <BusSchoolsNotExist
                                            v-if="
                                                busSchoolsStore.busschools
                                                    .length === 0 &&
                                                !busSchoolsStore.loading
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Spinner v-if="schoolStore.loading"></Spinner>
    </div>
</template>
