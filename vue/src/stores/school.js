import { defineStore } from "pinia";
import axios from "axios";
import router from "../router";
import { POSITION, useToast } from "vue-toastification";
import { useUserStore } from "./user";

const toast = useToast();
let user;
export const useSchoolStore = defineStore({
    id: "school",
    state: () => ({
        school: {},
        schoolInfos: false,
        loading: false,
    }),
    getters: {
        currentSchool: (state) => state.school,
        schoolStatus: (state) => state.schoolInfos,
        loadingStatus: (state) => state.loading,
    },
    actions: {
        //----------------------------Get School Infos for the current Admin--------------------------------------------
        async fetchSchool(admin_id) {
            if (!admin_id) {
                toast.warning("Please enter a valid creds");
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
                const { data } = await axios.get(
                    `api/school/${admin_id}`,
                    config
                );
                
                this.school = data.school;
                this.schoolInfos = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`${user.user.name} doesn't add a school yet!`, {
                    position: POSITION.TOP_CENTER,
                });
                this.schoolInfos = false;
                this.loading = false;
            }
        },
        //--------------------------Create a new School if the admin doesn't has one----------------------------------
        async createSchool(school) {
            
            if (
                !school.name ||
                !school.address ||
                !school.address_lat ||
                !school.address_lng
            ) {
                toast.warning("Please enter all the fields");
                return;
            }
            this.loading = true;
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                };
                const name = school.name;
                const address = school.address;
                const address_lat = school.address_lat;
                const address_lng = school.address_lng;
                const admin_id = user.user.profile_id;
                const { data } = await axios.post(
                    "api/school",
                    { admin_id, name, address, address_lat, address_lng },
                    config
                );
                this.school = data.school;
                this.schoolInfos = true;
                this.loading = false;
            } catch (err) {
                toast.warning(err, {
                    position: POSITION.TOP_CENTER,
                });
                this.schoolInfos = false;
                this.loading = false;
            }
        },
    },
});
