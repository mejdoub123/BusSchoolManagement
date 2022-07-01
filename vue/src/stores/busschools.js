import { defineStore } from "pinia";
import axios from "axios";
import router from "../router";
import { POSITION, useToast } from "vue-toastification";
import { useUserStore } from "./user";
import { useSchoolStore } from "./school";

const toast = useToast();
let user;
let school;
export const useBusSchoolsStore = defineStore({
    id: "busschools",
    state: () => ({
        busschools: [],
        lastBusSchoolAdded: {},
        busschoolRoutes: [],
        busSchoolsInfos: false,
        loading: false,
    }),
    getters: {
        currentBusSchools: (state) => state.busschools,
        currentBusSchool: (state) => state.lastBusSchoolAdded,
        currentBusSchoolRoutes: (state) => state.busschoolRoutes,
        busSchoolStatus: (state) => state.busSchoolsInfos,
        loadingStatus: (state) => state.loading,
    },
    actions: {
        //-------------------------------Create new Bus School-------------------------------------
        async createBusSchool(busschool) {
            if (
                !busschool.matricule ||
                !busschool.capacity ||
                !busschool.school_id
            ) {
                toast.warning("Please enter all the fields");
                return;
            }
            this.loading = true;
            user = useUserStore();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const school_id = busschool.school_id;
                const matricule = busschool.matricule;
                const capacity = busschool.capacity;
                const { data } = await axios.post(
                    "api/busschool",
                    { school_id, matricule, capacity },
                    config
                );
                this.busschools.push(data.busschool);
                this.lastBusSchoolAdded = data.busschool;
                this.loading = false;
                if (this.busschools.length === 1) {
                    this.busSchoolsInfos = true;
                }
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        //-------------------------------Fetch all Bus schools for a specific School------------------------------
        async fetchBusSchools(school_id) {
            if (!school_id) {
                toast.warning("Please enter a valid creds");
                return;
            }
            this.loading = true;
            user = useUserStore();
            school = useSchoolStore();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const { data } = await axios.get(
                    `api/busschool/${school_id}`,
                    config
                );

                this.busschools = data.busschools;
                this.busSchoolsInfos = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`This school doesn't have a bus school yet!`, {
                    position: POSITION.TOP_CENTER,
                });
                this.schoolInfos = false;
                this.loading = false;
            }
        },
        async updateBusSchool(busschoolInfos) {
            this.loading = true;
            user = useUserStore();
            school = useSchoolStore();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const matricule = busschoolInfos.matricule;
                const capacity = busschoolInfos.capacity;
                const { data } = await axios.put(
                    `api/busschool/${busschoolInfos.id}`,
                    { matricule, capacity },
                    config
                );
                await this.fetchBusSchools(school.school.id);
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
    },
});
