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

export const useZoneStore = defineStore({
    id: "zones",
    state: () => ({
        zones: [],
        zonesData: false,
        busschoolZone: {},
        loading: false,
    }),
    getters: {
        currentSchoolZones: (state) => state.zones,
        zonesDataStatus: (state) => state.zonesData,
        currentBusSchoolZone: (state) => state.busschoolZone,
        loadingStatus: (state) => state.loading,
    },
    actions: {
        async createZone(zone) {
            if (
                zone.geom.length === 0 ||
                !zone.bus_school_id ||
                !zone.school_id
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
                const bus_school_id = zone.bus_school_id;
                const school_id = zone.school_id;
                const geom = zone.geom;
                const { data } = await axios.post(
                    "api/zones",
                    { bus_school_id, school_id, geom },
                    config
                );
                this.zones.push(data.zone);
                this.busschoolZone = data.zone;
                this.loading = false;
                if (this.zones.length === 1) {
                    this.zonesData = true;
                }
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async fetchSchoolZones(school_id) {
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
                    `api/zones/school/${school_id}`,
                    config
                );
                this.zones = data.zones;
                this.zonesData = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async fetchBusSchoolZone(bus_school_id) {
            this.loading = true;
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const { data } = await axios.get(
                    `api/zones/busschool/${bus_school_id}`,
                    config
                );
                this.busschoolZone = data.zone;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async updateBusSchoolZone(zone) {
            if (zone.geom.length === 0 || !zone.zone_id) {
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
                const geom = zone.geom;
                const { data } = await axios.put(
                    `api/zones/${zone.zone_id}`,
                    { geom },
                    config
                );
                
                await this.fetchSchoolZones(school.school.id);

                this.busschoolZone = data.zone;
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
