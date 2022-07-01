import { createRouter, createWebHistory } from "vue-router";

import { useUserStore } from "../stores/user";
import { useBusSchoolsStore } from "../stores/busschools";
import { useStudentsStore } from "../stores/students";
import { useSchoolStore } from "../stores/school";
import { useZoneStore } from "../stores/zones";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/admin",
            name: "home",
            meta: { requiresAuth: true },
            component: () => import("../views/HomeView.vue"),
            children: [
                {
                    path: "school",
                    name: "school",
                    component: () => import("../components/school/School.vue"),
                    children: [
                        {
                            path: "",
                            name: "school-info",
                            component: () =>
                                import("../components/school/SchoolInfo.vue"),
                        },
                        {
                            path: "create",
                            component: () =>
                                import("../components/school/AddSchool.vue"),
                        },
                        {
                            path: "notfound",
                            component: () =>
                                import(
                                    "../components/school/SchoolNotExist.vue"
                                ),
                        },
                    ],
                },
                {
                    path: "busschools",
                    name: "busschools",
                    component: () =>
                        import("../components/busschools/BusSchools.vue"),
                    children: [
                        {
                            path: "",
                            name: "busschoolslist",
                            component: () =>
                                import(
                                    "../components/busschools/BusSchoolsList.vue"
                                ),
                        },
                        {
                            path: "create",
                            component: () =>
                                import(
                                    "../components/busschools/AddBusSchool.vue"
                                ),
                        },
                        {
                            path: "notfound",
                            component: () =>
                                import(
                                    "../components/busschools/BusSchoolsNotFound.vue"
                                ),
                        },
                        {
                            path: ":busschool_id",
                            component: () =>
                                import(
                                    "../components/busschools/BusSchool.vue"
                                ),
                            children: [
                                {
                                    path: "",
                                    name: "busschoolinfos",
                                    component: () =>
                                        import(
                                            "../components/busschools/BusSchoolInfos.vue"
                                        ),
                                },
                                //TODO path for reel time tracking
                                {
                                    path: "reel-time",
                                    name: "reeltimebusschool",
                                    component: () =>
                                        import(
                                            "../components/busschools/BusSchoolReelTime.vue"
                                        ),
                                },
                            ],
                        },
                    ],
                },
                {
                    path: "students",
                    name: "students",
                    component: () =>
                        import("../components/students/Students.vue"),
                    children: [
                        {
                            path: "",

                            component: () =>
                                import(
                                    "../components/students/StudentsTable.vue"
                                ),
                        },

                        {
                            path: "create",
                            component: () =>
                                import("../components/students/AddStudent.vue"),
                        },
                        {
                            path: "notfound",
                            component: () =>
                                import(
                                    "../components/students/StudentsNotFound.vue"
                                ),
                        },
                    ],
                },
            ],
        },
        {
            path: "/signin",
            name: "signin",
            component: () => import("../components/auth/SignIn.vue"),
        },
        {
            path: "/signup",
            name: "signup",
            component: () => import("../components/auth/SignUp.vue"),
        },
        {
            path: "/about",
            name: "about",
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/AboutView.vue"),
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: () => import("../views/NotFoundView.vue"),
        },
    ],
});
router.beforeEach(async (to, from) => {
    const user = useUserStore();
    const busschools = useBusSchoolsStore();
    const students = useStudentsStore();
    const zones = useZoneStore();
    const school = useSchoolStore();
    if (to.meta.requiresAuth && !user.token) {
        return "/signin";
    } else if (user.token && (to.name === "signin" || to.name === "signup")) {
        return `/${user.user.user_type}`;
    } else {
        return;
    }
});

export default router;
