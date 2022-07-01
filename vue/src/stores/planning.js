import { defineStore } from "pinia";
import axios from "axios";
import router from "../router";
import { POSITION, useToast } from "vue-toastification";
import { useUserStore } from "./user";
import { useBusSchoolsStore } from "./busschools";

const toast = useToast();
let user;
let busschools;

export const usePlanningStore = defineStore({
    id: "planning",
    state: () => ({
        planning: {},
        planningData: false,
        loading: false,
    }),
    getters: {},
    actions: {
        async createPlanning(planning) {
            this.loading = true;
            user = useUserStore();
            busschools = useBusSchoolsStore();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const monday_go_at = planning.monday_go_at;
                const monday_comeback_at = planning.monday_comeback_at;
                const tuesday_go_at = planning.tuesday_go_at;
                const tuesday_comeback_at = planning.tuesday_comeback_at;
                const wednesday_go_at = planning.wednesday_go_at;
                const wednesday_comeback_at = planning.wednesday_comeback_at;
                const thursday_go_at = planning.thursday_go_at;
                const thursday_comeback_at = planning.thursday_comeback_at;
                const friday_go_at = planning.friday_go_at;
                const friday_comeback_at = planning.friday_comeback_at;
                const bus_school_id = planning.bus_school_id;
                const { data } = await axios.post(
                    "api/planning",
                    {
                        bus_school_id,
                        monday_go_at,
                        monday_comeback_at,
                        tuesday_go_at,
                        tuesday_comeback_at,
                        wednesday_go_at,
                        wednesday_comeback_at,
                        thursday_go_at,
                        thursday_comeback_at,
                        friday_go_at,
                        friday_comeback_at,
                    },
                    config
                );
                this.planning = data.planning;
                this.planningData = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async fetchBusSchoolPlanning(bus_school_id) {
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
                    `api/planning/${bus_school_id}`,
                    config
                );
                this.planning = data.planning;
                this.planningData = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async updatePlanning(planning) {
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

                const monday_go_at = planning.monday_go_at;
                const monday_comeback_at = planning.monday_comeback_at;
                const tuesday_go_at = planning.tuesday_go_at;
                const tuesday_comeback_at = planning.tuesday_comeback_at;
                const wednesday_go_at = planning.wednesday_go_at;
                const wednesday_comeback_at = planning.wednesday_comeback_at;
                const thursday_go_at = planning.thursday_go_at;
                const thursday_comeback_at = planning.thursday_comeback_at;
                const friday_go_at = planning.friday_go_at;
                const friday_comeback_at = planning.friday_comeback_at;
                const planning_id = planning.id;
                const { data } = await axios.put(
                    `api/planning/${planning_id}`,
                    {
                        monday_go_at,
                        monday_comeback_at,
                        tuesday_go_at,
                        tuesday_comeback_at,
                        wednesday_go_at,
                        wednesday_comeback_at,
                        thursday_go_at,
                        thursday_comeback_at,
                        friday_go_at,
                        friday_comeback_at,
                    },
                    config
                );

                console.log(data);
                this.planning = data.planning;
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
