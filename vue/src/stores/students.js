import { defineStore } from "pinia";
import axios from "axios";
import router from "../router";
import { POSITION, useToast } from "vue-toastification";
import { useUserStore } from "./user";
import { useSchoolStore } from "./school";

const toast = useToast();
let user;
let school;
export const useStudentsStore = defineStore({
    id: "students",
    state: () => ({
        students: [],
        busSchoolStudents: [],
        studentsIntZone: [],
        studentsData: false,
        loading: false,
        loadingAdd: false,
    }),
    getters: {
        currentStudentIntZone: (state) => state.studentsIntZone,
        currentBusSchoolsStudents: (state) => state.busSchoolStudents,
        currentSchoolStudents: (state) => state.students,
        studentsDataStatus: (state) => state.studentsData,
        loadingStatus: (state) => state.loading,
        loadingAddStatus: (state) => state.loadingAdd,
    },
    actions: {
        removeStudentsIntZone() {
            this.studentsIntZone = [];
        },
        async fetchSchoolStudents(school_id) {
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
                    `api/students/school/${school_id}`,
                    config
                );
                this.students = data.students;
                this.studentsData = true;
                this.loading = false;
            } catch (err) {
                toast.warning(`This school doesn't have a students yet!`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async fetchBusSchoolStudents(bus_school_id) {
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
                    `api/students/busschool/${bus_school_id}`,
                    config
                );
                this.busSchoolStudents = data.students;
                this.loading = false;
            } catch (err) {
                toast.warning(`This bus school doesn't have a students yet!`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async addStudentsToBusSchool(studentsInfo) {
            if (
                studentsInfo.students_id.length === 0 ||
                !studentsInfo.zone_id ||
                !studentsInfo.bus_school_id
            ) {
                toast.warning("Please enter all the fields");
                return;
            }
            console.log(studentsInfo);
            this.loading = true;
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const students = studentsInfo.students_id;
                const zone_id = studentsInfo.zone_id;
                const bus_school_id = studentsInfo.bus_school_id;
                await axios.put(
                    "api/students/busschool/add",
                    { students, zone_id, bus_school_id },
                    config
                );
                await this.fetchSchoolStudents(school.school.id);
                this.loading = false;
            } catch (err) {
                toast.warning(`${err.message}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async deleteStudentsFromBusSchool(studentsID) {
            if (studentsID.length === 0) {
                toast.warning("Please enter all the fields");
                return;
            }
            this.loading = true;
            try {
                const config = {
                    withCredentials: true,
                    headers: {
                        Authorization: `Bearer ${user.token}`,
                        Accept: "application/json",
                    },
                };
                const students = studentsID;
                await axios.put(
                    "api/students/busschool/delete",
                    { students },
                    config
                );
                await this.fetchSchoolStudents(school.school.id);
                this.loading = false;
            } catch (err) {
                toast.warning(`${err.message}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
        async fetchStudentsIntersectZone(zone_id) {
            this.loadingAdd = true;
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
                    `api/students/zone/${zone_id}`,
                    config
                );
                this.studentsIntZone = data.students;
                this.loadingAdd = false;
            } catch (err) {
                toast.warning(`This zone doesn't intersect with any student!`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loadingAdd = false;
            }
        },
        async createStudent(student) {
            if (
                !student.name ||
                !student.email ||
                !student.cne ||
                !student.address ||
                !student.phone_number ||
                !student.address_lat ||
                !student.address_lng
            ) {
                toast.warning("Please enter all the fields");
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
                const school_id = school.school.id;
                const name = student.name;
                const email = student.email;
                const cne = student.cne;
                const address = student.address;
                const address_lat = `${student.address_lat}`;
                const address_lng = `${student.address_lng}`;
                const phone_number = student.phone_number;
                const password = student.cne;
                console.log(student);
                const { data } = await axios.post(
                    "api/students",
                    {
                        school_id,
                        name,
                        email,
                        cne,
                        address,
                        address_lat,
                        address_lng,
                        phone_number,
                        password,
                    },
                    config
                );

                this.students = this.students.concat(data.student);
                if (this.students.length === 1) {
                    this.studentsData = true;
                }
                this.loading = false;
            } catch (err) {
                toast.warning(`${err.message}`, {
                    position: POSITION.TOP_CENTER,
                });
                this.loading = false;
            }
        },
    },
});
