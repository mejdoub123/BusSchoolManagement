import { defineStore } from "pinia";
import axios from "axios";
import router from "../router";
import { POSITION, useToast } from "vue-toastification";
import { useBusSchoolsStore } from "./busschools";
import { useSchoolStore } from "./school";
import { useDriversStore } from "./drivers";
import { useStudentsStore } from "./students";
import { useZoneStore } from "./zones";
import { useTrajectStore } from "./trajects";

const toast = useToast();
export const useUserStore = defineStore({
    id: "user",
    state: () => ({
        user: {},
        token: "",
        logged: false,
        loading: false,
    }),
    getters: {
        currentUser: (state) => state.user,
        currentToken: (state) => state.token,
        loginStatus: (state) => state.logged,
        loadingStatus: (state) => state.loading,
    },
    actions: {
        //--------------------Get Csrf Token----------------------
        async csrfToken() {
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                };
                await axios.get("sanctum/csrf-cookie", config);
            } catch (err) {
                toast.warning(err, {
                    position: POSITION.TOP_CENTER,
                });
            }
        },
        //---------------------Login-------------------------------
        async login(user) {
            if (!user.email || !user.password) {
                toast.warning("Please enter all the fields");
                return;
            }
            this.loading = true;
            await this.csrfToken();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                };

                const email = user.email;
                const password = user.password;

                const { data } = await axios.post(
                    "api/login",
                    { email, password },
                    config
                );

                this.user = data.user;
                this.token = data.token;
                this.logged = true;
                this.loading = false;
                if (data.user.user_type === "admin") {
                    router.push("/admin/school");
                }

                return;
            } catch (error) {
                toast.warning("Email or Password invalid", {
                    position: POSITION.TOP_CENTER,
                });

                this.loading = false;
            }
        },
        //--------------------------register---------------------------
        async register(user) {
            if (
                !user.name ||
                !user.email ||
                !user.cin ||
                !user.role ||
                !user.password ||
                !user.password_confirmation
            ) {
                toast.warning("Please enter all the fields");
                return;
            }
            if (user.password !== user.password_confirmation) {
                toast.warning("Please enter a valid password");
            }
            this.loading = true;
            await this.csrfToken();
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                };
                const name = user.name;
                const email = user.email;
                const cin = user.cin;
                const role = user.role;
                const password = user.password;
                const password_confirmation = user.password_confirmation;
                const { data } = await axios.post(
                    "api/register",
                    { name, email, password, password_confirmation, cin, role },
                    config
                );

                this.user = data.user;
                this.token = data.token;
                this.logged = true;
                this.loading = false;
                if (data.user.user_type === "admin") {
                    router.push("/admin/school");
                }
            } catch (error) {
                toast.warning("Invalid creds", {
                    position: POSITION.TOP_CENTER,
                });

                this.loading = false;
            }
        },
        //-----------------------------Update Password-----------------------------
        async updatePassword(passwordsList) {
            //Check all the fields
            if (
                !passwordsList.old_password ||
                !passwordsList.new_password ||
                !passwordsList.new_password_confirmation
            ) {
                console.log("Please Enter All the Fields !");
            }
            //Match the password and the confirmation
            if (
                passwordsList.new_password !==
                passwordsList.new_password_confirmation
            ) {
                console.log("Please Enter a valid Password !");
            }
            this.loading = true;
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        Accept: "application/json",
                    },
                };
                const old_password = passwordsList.old_password;
                const new_password = passwordsList.new_password;
                const new_password_confirmation =
                    passwordsList.new_password_confirmation;
                await axios.post(
                    "api/change-password",
                    { old_password, new_password, new_password_confirmation },
                    config
                );
                toast.success("Password changed successfully!");
                await this.logout();
            } catch (err) {
                console.log(err);
                this.loading = false;
            }
        },
        //-----------------------------logout-----------------------------------
        async logout() {
            this.loading = true;
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        Accept: "application/json",
                    },
                };

                await axios.post("api/logout", null, config);
                const user = useUserStore();
                const busSchoolsStore = useBusSchoolsStore();
                const driversStore = useDriversStore();
                const schoolStore = useSchoolStore();
                const zoneStore = useZoneStore();
                const trajectStore = useTrajectStore();
                const studentsStore = useStudentsStore();
                user.$reset();
                schoolStore.$reset();
                driversStore.$reset();
                busSchoolsStore.$reset();
                studentsStore.$reset();
                zoneStore.$reset();
                trajectStore.$reset();
                router.push("/signin");
            } catch (err) {
                console.log(err);
                this.loading = false;
            }
        },
    },
});
