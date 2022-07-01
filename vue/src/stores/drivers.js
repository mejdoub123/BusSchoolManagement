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
export const useDriversStore = defineStore({
    id: "drivers",
    state: () => ({
        drivers: [],
        driver: {},
        driversData: false,
        loading: false,
    }),
    getters: {
        currentDriver: (state) => state.driver,
        currentDrivers: (state) => state.drivers,
        dataStatus: (state) => state.driversData,
        loadingStatus: (state) => state.loading,
    },
    actions: {
        //function to fetch drivers infos for a specific school and fetch the driver for a specific bus school
        async fetchSchoolDrivers(school_id) {
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
                    `api/drivers/school/${school_id}`,
                    config
                );
                this.drivers = data.drivers;
                this.driversData = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        }, // funcion to add driver for a specific bus school
        async fetchBusSchoolDriver(bus_school_id) {
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
                    `api/drivers/busschool/${bus_school_id}`,
                    config
                );
                this.driver = data.driver;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },

        async createDriver(driver) {
            if (
                !driver.name ||
                !driver.email ||
                !driver.cin ||
                !driver.password
            ) {
                toast.warning("Please enter all the fields");
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
                const name = driver.name;
                const email = driver.email;
                const cin = driver.cin;
                const password = driver.password;
                const school_id = driver.school_id;
                const bus_school_id = driver.bus_school_id;
                const { data } = await axios.post(
                    `api/drivers`,
                    { name, email, cin, password, school_id, bus_school_id },
                    config
                );
                this.drivers.push(data.driver);
                if (this.drivers.length === 1) {
                    this.driversData = true;
                }
                this.driver = data.driver;
                this.loading = false;
            } catch (err) {
                toast.warning(`${err}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async updateDriver(driverInfo) {
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
                const name = driverInfo.name;
                const cin = driverInfo.cin;
                const email = driverInfo.email;
                const { data } = await axios.put(
                    `api/drivers/${driverInfo.profile_id}`,
                    { name, cin, email },
                    config
                );
                console.log(data);
                await this.fetchSchoolDrivers(school.school.id);
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
