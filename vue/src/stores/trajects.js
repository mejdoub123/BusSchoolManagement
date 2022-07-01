import { defineStore } from "pinia";
import axios from "axios";
import router from "../router";
import { POSITION, useToast } from "vue-toastification";
import { useSchoolStore } from "./school";
import { useUserStore } from "./user";
import { useBusSchoolsStore } from "./busschools";

const toast = useToast();
let user;
let busschools;
let school;

export const useTrajectStore = defineStore({
    id: "trajects",
    state: () => ({
        trajects: [],
        trajectsData: false,
        busSchoolTrajects: [],
        loading: false,
    }),
    getters: {
        currentSchoolTrajects: (state) => state.trajects,
        trajectsDataStatus: (state) => state.trajectsData,
        currentBusSchoolTrajects: (state) => state.busSchoolTrajects,
        loadingStatus: (state) => state.loading,
    },
    actions: {
        async createTraject(traject) {
            if (
                traject.geometry.length === 0 ||
                !traject.school_id ||
                !traject.bus_school_id ||
                !traject.type
            ) {
                toast.warning("Please enter a valid creds");
                return;
            }
            this.loading = true;
            user = useUserStore();
            school = useSchoolStore();
            busschools = useBusSchoolsStore();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const bus_school_id = traject.bus_school_id;
                const school_id = traject.school_id;
                const geometry = traject.geometry;
                const type = traject.type;
                const stops = traject.stops;
                console.log(traject.stops);
                console.log(traject.geometry);
                const { data } = await axios.post(
                    "api/trajects",
                    { bus_school_id, school_id, geometry, type, stops },
                    config
                );
                this.trajects.push(data.traject);
                this.busSchoolTrajects.push(data.traject);
                this.loading = false;
                if (this.trajects.length === 1) {
                    this.trajectsData = true;
                }
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async getSchoolTrajects(school_id) {
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
                const { data } = await axios.get(
                    `api/trajects/school/${school_id}`,
                    config
                );
                this.trajects = data.trajects;
                this.trajectsData = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async updateBusSchoolTraject(traject) {
            if (traject.geometry.length === 0 || !traject.traject_id) {
                toast.warning("Please enter a valid creds");
                return;
            }
            this.loading = true;
            school = useSchoolStore();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const geometry = traject.geometry;
                const stops = traject.stops;
                const { data } = await axios.put(
                    `api/trajects/${traject.traject_id}`,
                    { geometry, stops },
                    config
                );
                console.log(data);

                await this.getSchoolTrajects(school.school.id);

                this.busSchoolTrajects = data.traject;
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
