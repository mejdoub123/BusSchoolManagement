<script setup>
import { toRefs } from "@vue/reactivity";
import * as turf from "@turf/turf";
import { ref } from "vue";
import { onMounted } from "@vue/runtime-core";
import { useRoute } from "vue-router";
import { useSchoolStore } from "../../stores/school";

import Spinner from "../layouts/Spinner.vue";
import router from "../../router";
import { useStudentsStore } from "../../stores/students";
import { usePlanningStore } from "../../stores/planning";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useDriversStore } from "../../stores/drivers";
import { useZoneStore } from "../../stores/zones";
import EditBusSchool from "../busschools/EditBusSchool.vue";
const props = defineProps({
    students: Array,
    zone: Object,
    trajects: Array,
    edit: Boolean,
});
const emit = defineEmits([
    "rerender-map",
    "del-stds-updt-zone-traject",
    "update-data",
]);
const route = useRoute();
const zoneEdited = ref([]);
const trajectGoEdited = ref([]);
const trajectComebackEdited = ref([]);
const stops = ref([]);
const studentsToDel = ref([]);
const { students, zone, trajects, edit } = toRefs(props);
const schoolStore = useSchoolStore();
const studentsStore = useStudentsStore();
const driversStore = useDriversStore();
const zonesStore = useZoneStore();
const busSchoolsStore = useBusSchoolsStore();
const planningStore = usePlanningStore();
const confirmDel = ref(false);
var map;
var traject_go;
var traject_comeback;
var stopsMarkers = [];
var studentsMarkers = [];
var firstStudent;
var studentsInfosToAdd = {};
var studentsInfosToDelete = [];
const delStatus = () => {
    confirmDel.value = false;
    emit("rerender-map");
};
const updateAndDelInfosMap = () => {
    var infos = {};

    infos.students = [];
    infos.trajectGo = {
        traject_id: trajects.value.filter(
            (traject) => traject.type === "traject_go"
        )[0].id,
        geometry: trajectGoEdited.value,
        stops: stops.value,
    };
    infos.trajectComeBack = {
        traject_id: trajects.value.filter(
            (traject) => traject.type === "traject_comeback"
        )[0].id,
        geometry: trajectComebackEdited.value,
        stops: null,
    };
    infos.zone = {
        zone_id: zone.value.id,
        geom: zoneEdited.value,
    };
    studentsToDel.value.forEach((student) => {
        infos.students = infos.students.concat(student.profile_id);
    });
    emit("del-stds-updt-zone-traject", infos);
    confirmDel.value = false;
};
const updateZne = () => {
    var infos = {};
    infos.zone = {
        zone_id: zone.value.id,
        geom: zoneEdited.value,
    };

    emit("del-stds-updt-zone-traject", infos);
};
const updateDataBusSchool = async (infos) => {
    if (infos.studentsToAdd || infos.studentsToDelete) {
        var newStudentsList = [...students.value];
        if (infos.studentsToAdd) {
            infos.studentsToAdd.students.forEach((student) => {
                if (!studentsInfosToAdd.students_id) {
                    studentsInfosToAdd.students_id = [];
                }

                studentsInfosToAdd.students_id =
                    studentsInfosToAdd.students_id.concat(student.profile_id);
            });
            studentsInfosToAdd.zone_id = infos.studentsToAdd.zone_id;
            studentsInfosToAdd.bus_school_id =
                infos.studentsToAdd.bus_school_id;
            newStudentsList = newStudentsList.concat(
                ...infos.studentsToAdd.students
            );
            infos.studentsToAdd = studentsInfosToAdd;
        }
        if (infos.studentsToDelete) {
            infos.studentsToDelete.forEach((student) => {
                studentsInfosToDelete = studentsInfosToDelete.concat(
                    student.profile_id
                );
            });
            newStudentsList = newStudentsList.filter((student) => {
                return !infos.studentsToDelete.includes(student);
            });
            infos.studentsToDelete = studentsInfosToDelete;
        }

        map.removeLayer(traject_go);
        map.removeLayer(traject_comeback);

        stopsMarkers.forEach((stopMarker) => map.removeLayer(stopMarker));
        studentsMarkers.forEach((studentMarker) =>
            map.removeLayer(studentMarker)
        );
        stopsMarkers = [];
        studentsMarkers = [];
        stops.value = [];
        var studentIcon = L.divIcon({
            iconSize: null,
            html: `<div class="map-label yellowborder"><div class="map-label-content-yellow">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
        });

        newStudentsList.forEach((student) => {
            studentsMarkers = studentsMarkers.concat(
                L.marker(
                    [
                        student.address_position.coordinates[1],
                        student.address_position.coordinates[0],
                    ],
                    {
                        icon: studentIcon,
                    }
                ).addTo(map)
            );
        });

        if (newStudentsList.length > 0) {
            map.removeLayer(traject_go);
            map.removeLayer(traject_comeback);
            stopsMarkers.map((stopMarker) => map.removeLayer(stopMarker));
            traject_go = [];
            traject_comeback = [];
            trajectGoEdited.value = [];
            trajectComebackEdited.value = [];
            stopsMarkers = [];
            stops.value = [];
            //--------------------Find the first student in the traject---------------------------
            const r = await Promise.all(
                newStudentsList.map(async (student) => [
                    await route_getter(schoolStore.school, student),
                    student,
                ])
            );
            console.log({ r });
            const sorted = r
                //.filter((item) => typeof item[0] !== "string")
                .sort(
                    (a, b) =>
                        a[0]?.summary?.totalDistance -
                        b[0]?.summary?.totalDistance
                );

            firstStudent = sorted[0][1];
            trajectGoEdited.value = trajectGoEdited.value.concat(
                sorted[0][0].coordinates
            );
            stops.value = stops.value.concat([
                sorted[0][0].coordinates[sorted[0][0].coordinates.length - 1],
            ]);
            var stopIcon = L.divIcon({
                iconSize: null,
                html: `<div class="map-label greenbackground"><div class="map-label-content">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <desc>Download more icon variants from https://tabler-icons.io/i/bus</desc>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="6" cy="17" r="2"></circle>
                        <circle cx="18" cy="17" r="2"></circle>
                        <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>
                        <polyline points="16 5 17.5 12 22 12"></polyline>
                        <line x1="2" y1="10" x2="17" y2="10"></line>
                        <line x1="7" y1="5" x2="7" y2="10"></line>
                        <line x1="12" y1="5" x2="12" y2="10"></line>
                    </svg> 1
        </div><div class="map-label-arrow"></div></div>`,
            });
            stopsMarkers = stopsMarkers.concat(
                L.marker(
                    [
                        sorted[0][0].coordinates[
                            sorted[0][0].coordinates.length - 1
                        ].lat,
                        sorted[0][0].coordinates[
                            sorted[0][0].coordinates.length - 1
                        ].lng,
                    ],
                    {
                        icon: stopIcon,
                    }
                ).addTo(map)
            );

            // ---------------Find the optimale traject to all students------------------------
            var studentsZ = [...newStudentsList];
            studentsZ = studentsZ.filter(
                (student, index) => student !== firstStudent
            );
            let j = 0;
            let lengthS = studentsZ.length;
            var latlngs = [];

            while (studentsZ.length > 0) {
                var pickUp;
                var distination;

                if (j === 0) {
                    pickUp = firstStudent;
                    console.log(pickUp);
                }
                if (j < lengthS) {
                    const r = await Promise.all(
                        studentsZ.map(async (student) => [
                            await route_getter(pickUp, student),
                            student,
                        ])
                    );
                    console.log({ r });
                    const sorted = r
                        //.filter((item) => typeof item[0] !== "string")
                        .sort(
                            (a, b) =>
                                a[0]?.summary?.totalDistance -
                                b[0]?.summary?.totalDistance
                        );

                    distination = sorted[0][1];

                    trajectGoEdited.value = trajectGoEdited.value.concat(
                        sorted[0][0].coordinates
                    );
                    stops.value = stops.value.concat([
                        sorted[0][0].coordinates[
                            sorted[0][0].coordinates.length - 1
                        ],
                    ]);
                    var stopIcon = L.divIcon({
                        iconSize: null,
                        html: `<div class="map-label greenbackground"><div class="map-label-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <desc>Download more icon variants from https://tabler-icons.io/i/bus</desc>
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="6" cy="17" r="2"></circle>
                                    <circle cx="18" cy="17" r="2"></circle>
                                    <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>
                                    <polyline points="16 5 17.5 12 22 12"></polyline>
                                    <line x1="2" y1="10" x2="17" y2="10"></line>
                                    <line x1="7" y1="5" x2="7" y2="10"></line>
                                    <line x1="12" y1="5" x2="12" y2="10"></line>
                                    </svg> ${j + 2}
                                </div><div class="map-label-arrow"></div></div>`,
                    });
                    stopsMarkers = stopsMarkers.concat(
                        L.marker(
                            [
                                sorted[0][0].coordinates[
                                    sorted[0][0].coordinates.length - 1
                                ].lat,
                                sorted[0][0].coordinates[
                                    sorted[0][0].coordinates.length - 1
                                ].lng,
                            ],
                            {
                                icon: stopIcon,
                            }
                        ).addTo(map)
                    );
                }

                pickUp = distination;
                j++;
                console.log(studentsZ.length === 1);
                if (studentsZ.length === 1) {
                    // var polyline = L.polyline(latlngs, {
                    //     color: "#422361",
                    //     weight: 3,
                    // });
                    // polyline.addTo(map);
                    const result = await route_getter(
                        pickUp,
                        schoolStore.school
                    );

                    trajectComebackEdited.value =
                        trajectComebackEdited.value.concat(result.coordinates);
                    traject_go = L.polyline(trajectGoEdited.value, {
                        color: "#000000",
                        width: 5,
                    }).addTo(map);
                    traject_comeback = L.polyline(trajectComebackEdited.value, {
                        color: "red",
                        weight: 3,
                    }).addTo(map);
                }
                studentsZ = studentsZ.filter(
                    (student) => student !== distination
                );
            }
        }
    }

    infos.trajectGo = {
        traject_id: trajects.value.filter(
            (traject) => traject.type === "traject_go"
        )[0].id,
        geometry: trajectGoEdited.value,
        stops: stops.value,
    };

    infos.trajectComeBack = {
        traject_id: trajects.value.filter(
            (traject) => traject.type === "traject_comeback"
        )[0].id,
        geometry: trajectComebackEdited.value,
        stops: null,
    };

    emit("update-data", infos);
};

const route_getter = async (pickUp, distination) => {
    return new Promise(function (resolve, reject) {
        if (pickUp.address_position) {
            var wayPoint1 = L.latLng(
                pickUp.address_position.coordinates[1],
                pickUp.address_position.coordinates[0]
            );
        } else {
            var wayPoint1 = L.latLng(
                pickUp.position.coordinates[1],
                pickUp.position.coordinates[0]
            );
        }

        if (distination.address_position) {
            var wayPoint2 = L.latLng(
                distination.address_position.coordinates[1],
                distination.address_position.coordinates[0]
            );
        } else {
            var wayPoint2 = L.latLng(
                distination.position.coordinates[1],
                distination.position.coordinates[0]
            );
        }

        var rWP1 = new L.Routing.Waypoint();
        rWP1.latLng = wayPoint1;

        var rWP2 = new L.Routing.Waypoint();
        rWP2.latLng = wayPoint2;
        var myRoute = L.Routing.osrmv1();
        myRoute.route([rWP1, rWP2], function (err, routes) {
            if (err == null) {
                resolve(routes[0]);
            } else resolve("No route available");
        });
    });
};
onMounted(async () => {
    // Create the map
    var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        osmAttrib =
            '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib });
    map = new L.Map(`map${zone.value.id}`, {
        center: new L.LatLng(
            schoolStore.school.position.coordinates[1],
            schoolStore.school.position.coordinates[0]
        ),
        zoom: 15,
    });
    var drawnItems = L.featureGroup();
    map.addLayer(drawnItems);
    osm.addTo(map);
    if (edit.value) {
        var options = {
            edit: {
                featureGroup: drawnItems,
                remove: false,
            },
            draw: {
                polyline: false,
                marker: false,
                polygon: false,
                circle: false,
                rectangle: false,
                circlemarker: false,
            },
            showRadius: true,
        };
        var drawControl = new L.Control.Draw(options);
        map.addControl(drawControl);
    }
    var defaultIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label blueborder"><div class="map-label-content">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/school </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });
    var studentIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label yellowborder"><div class="map-label-content-yellow">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });

    const get_route = (pickUp, distination) => {
        return new Promise(function (resolve, reject) {
            if (pickUp.address_position) {
                var wayPoint1 = L.latLng(
                    pickUp.address_position.coordinates[1],
                    pickUp.address_position.coordinates[0]
                );
            } else {
                var wayPoint1 = L.latLng(
                    pickUp.position.coordinates[1],
                    pickUp.position.coordinates[0]
                );
            }

            if (distination.address_position) {
                var wayPoint2 = L.latLng(
                    distination.address_position.coordinates[1],
                    distination.address_position.coordinates[0]
                );
            } else {
                var wayPoint2 = L.latLng(
                    distination.position.coordinates[1],
                    distination.position.coordinates[0]
                );
            }

            var rWP1 = new L.Routing.Waypoint();
            rWP1.latLng = wayPoint1;

            var rWP2 = new L.Routing.Waypoint();
            rWP2.latLng = wayPoint2;
            var myRoute = L.Routing.osrmv1();
            myRoute.route([rWP1, rWP2], function (err, routes) {
                if (err == null) {
                    resolve(routes[0]);
                } else resolve("No route available");
            });
        });
    };
    var schoolMarker = L.marker([
        schoolStore.school.position.coordinates[1],
        schoolStore.school.position.coordinates[0],
    ]).addTo(map);
    var schoolIconMarker = L.marker(
        [
            schoolStore.school.position.coordinates[1],
            schoolStore.school.position.coordinates[0],
        ],
        {
            icon: defaultIcon,
        }
    ).addTo(map);
    var studentsZone = [...students.value];
    const currentZone = { ...zone.value };
    const trajectsBusSchool = [...trajects.value];
    if (studentsZone.length) {
        studentsZone.forEach((student) => {
            studentsMarkers = studentsMarkers.concat(
                L.marker(
                    [
                        student.address_position.coordinates[1],
                        student.address_position.coordinates[0],
                    ],
                    {
                        icon: studentIcon,
                    }
                ).addTo(map)
            );
        });
    }

    var latlngsZone = [];
    currentZone.geom.coordinates[0].forEach((point) => {
        var latlng = [point[1], point[0]];
        latlngsZone = latlngsZone.concat([latlng]);
    });

    var zoneAdd = L.polygon(latlngsZone, { color: "green" });
    if (edit.value) {
        drawnItems.addLayer(zoneAdd);
    } else {
        zoneAdd.addTo(map);
    }
    trajectsBusSchool.forEach((traject) => {
        var latlngsTraject = [];

        if (traject.stops) {
            traject.stops.coordinates.forEach((coordinate, index) => {
                var stopIcon = L.divIcon({
                    iconSize: null,
                    html: `<div class="map-label greenbackground"><div class="map-label-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <desc>Download more icon variants from https://tabler-icons.io/i/bus</desc>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="6" cy="17" r="2"></circle>
                        <circle cx="18" cy="17" r="2"></circle>
                        <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>
                        <polyline points="16 5 17.5 12 22 12"></polyline>
                        <line x1="2" y1="10" x2="17" y2="10"></line>
                        <line x1="7" y1="5" x2="7" y2="10"></line>
                        <line x1="12" y1="5" x2="12" y2="10"></line>
                    </svg> ${index + 1}
                    </div>
                    <div class="map-label-arrow"></div></div>`,
                });
                stopsMarkers = stopsMarkers.concat(
                    L.marker([coordinate[1], coordinate[0]], {
                        icon: stopIcon,
                    }).addTo(map)
                );
            });
        }
        traject.geometry.coordinates.forEach((point) => {
            var latlng = [point[1], point[0]];
            latlngsTraject = latlngsTraject.concat([latlng]);
        });
        if (traject.type === "traject_go") {
            traject_go = L.polyline(latlngsTraject, {
                color: "#422361",
                weight: 3,
            }).addTo(map);
        } else {
            traject_comeback = L.polyline(latlngsTraject, {
                color: "red",

                weight: 3,
            }).addTo(map);
        }
    });

    if (edit.value) {
        map.on("draw:edited", async function (e) {
            var layers = e.layers;

            layers.eachLayer(async function (layer) {
                var shape = layer.toGeoJSON();
                zoneEdited.value = shape.geometry.coordinates[0];
                map.eachLayer(async function (layerMarker) {
                    if (layerMarker instanceof L.Marker) {
                        if (
                            layerMarker.getLatLng().lat !==
                                schoolStore.school.position.coordinates[1] &&
                            layerMarker.getLatLng().lng !==
                                schoolStore.school.position.coordinates[0] &&
                            !turf.booleanPointInPolygon(
                                layerMarker.toGeoJSON(),
                                layer.toGeoJSON()
                            )
                        ) {
                            students.value.forEach((student) => {
                                if (
                                    student.address_position.coordinates[1] ===
                                        layerMarker.getLatLng().lat &&
                                    student.address_position.coordinates[0] ===
                                        layerMarker.getLatLng().lng
                                ) {
                                    if (
                                        studentsToDel.value.indexOf(student) ===
                                        -1
                                    ) {
                                        studentsToDel.value =
                                            studentsToDel.value.concat(student);
                                        studentsZone = studentsZone.filter(
                                            (studentZone) =>
                                                studentZone.profile_id !==
                                                student.profile_id
                                        );
                                    }
                                }
                            });
                            map.removeLayer(layerMarker);
                        }
                    }
                });
                if (studentsToDel.value.length === 0) {
                    updateZne();
                } else if (studentsToDel.value.length > 0) {
                    map.removeLayer(traject_go);
                    map.removeLayer(traject_comeback);
                    stopsMarkers.map((stopMarker) =>
                        map.removeLayer(stopMarker)
                    );
                    traject_go = [];
                    traject_comeback = [];
                    trajectGoEdited.value = [];
                    trajectComebackEdited.value = [];
                    stopsMarkers = [];
                    stops.value = [];
                    if (studentsZone.length > 0) {
                        //--------------------Find the first student in the traject---------------------------
                        const r = await Promise.all(
                            studentsZone.map(async (student) => [
                                await get_route(schoolStore.school, student),
                                student,
                            ])
                        );
                        console.log({ r });
                        const sorted = r
                            //.filter((item) => typeof item[0] !== "string")
                            .sort(
                                (a, b) =>
                                    a[0]?.summary?.totalDistance -
                                    b[0]?.summary?.totalDistance
                            );

                        firstStudent = sorted[0][1];

                        trajectGoEdited.value = trajectGoEdited.value.concat(
                            sorted[0][0].coordinates
                        );
                        stops.value = stops.value.concat([
                            sorted[0][0].coordinates[
                                sorted[0][0].coordinates.length - 1
                            ],
                        ]);
                        var stopIcon = L.divIcon({
                            iconSize: null,
                            html: `<div class="map-label greenbackground"><div class="map-label-content">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <desc>Download more icon variants from https://tabler-icons.io/i/bus</desc>
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="6" cy="17" r="2"></circle>
                        <circle cx="18" cy="17" r="2"></circle>
                        <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>
                        <polyline points="16 5 17.5 12 22 12"></polyline>
                        <line x1="2" y1="10" x2="17" y2="10"></line>
                        <line x1="7" y1="5" x2="7" y2="10"></line>
                        <line x1="12" y1="5" x2="12" y2="10"></line>
                    </svg> 1
        </div><div class="map-label-arrow"></div></div>`,
                        });
                        stopsMarkers = stopsMarkers.concat(
                            L.marker(
                                [
                                    sorted[0][0].coordinates[
                                        sorted[0][0].coordinates.length - 1
                                    ].lat,
                                    sorted[0][0].coordinates[
                                        sorted[0][0].coordinates.length - 1
                                    ].lng,
                                ],
                                {
                                    icon: stopIcon,
                                }
                            ).addTo(map)
                        );
                        // ---------------Find the optimale traject to all students------------------------
                        var studentsZ = [...studentsZone];
                        studentsZ = studentsZ.filter(
                            (student, index) => student !== firstStudent
                        );
                        let j = 0;
                        let lengthS = studentsZ.length;
                        var latlngs = [];
                        while (studentsZ.length > 0) {
                            var pickUp;
                            var distination;

                            if (j === 0) {
                                pickUp = firstStudent;
                                console.log(pickUp);
                            }
                            if (j < lengthS) {
                                const r = await Promise.all(
                                    studentsZ.map(async (student) => [
                                        await get_route(pickUp, student),
                                        student,
                                    ])
                                );
                                console.log({ r });
                                const sorted = r
                                    //.filter((item) => typeof item[0] !== "string")
                                    .sort(
                                        (a, b) =>
                                            a[0]?.summary?.totalDistance -
                                            b[0]?.summary?.totalDistance
                                    );

                                distination = sorted[0][1];

                                trajectGoEdited.value =
                                    trajectGoEdited.value.concat(
                                        sorted[0][0].coordinates
                                    );
                                stops.value = stops.value.concat([
                                    sorted[0][0].coordinates[
                                        sorted[0][0].coordinates.length - 1
                                    ],
                                ]);
                                var stopIcon = L.divIcon({
                                    iconSize: null,
                                    html: `<div class="map-label greenbackground"><div class="map-label-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <desc>Download more icon variants from https://tabler-icons.io/i/bus</desc>
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="6" cy="17" r="2"></circle>
                                    <circle cx="18" cy="17" r="2"></circle>
                                    <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"></path>
                                    <polyline points="16 5 17.5 12 22 12"></polyline>
                                    <line x1="2" y1="10" x2="17" y2="10"></line>
                                    <line x1="7" y1="5" x2="7" y2="10"></line>
                                    <line x1="12" y1="5" x2="12" y2="10"></line>
                                    </svg> ${j + 2}
                                </div><div class="map-label-arrow"></div></div>`,
                                });
                                stopsMarkers = stopsMarkers.concat(
                                    L.marker(
                                        [
                                            sorted[0][0].coordinates[
                                                sorted[0][0].coordinates
                                                    .length - 1
                                            ].lat,
                                            sorted[0][0].coordinates[
                                                sorted[0][0].coordinates
                                                    .length - 1
                                            ].lng,
                                        ],
                                        {
                                            icon: stopIcon,
                                        }
                                    ).addTo(map)
                                );
                            }

                            pickUp = distination;
                            j++;
                            console.log(studentsZ.length === 1);
                            if (studentsZ.length === 1) {
                                // var polyline = L.polyline(latlngs, {
                                //     color: "#422361",
                                //     weight: 3,
                                // });
                                // polyline.addTo(map);
                                const result = await get_route(
                                    pickUp,
                                    schoolStore.school
                                );

                                trajectComebackEdited.value =
                                    trajectComebackEdited.value.concat(
                                        result.coordinates
                                    );
                                traject_go = L.polyline(trajectGoEdited.value, {
                                    color: "#000000",
                                    width: 5,
                                }).addTo(map);
                                traject_comeback = L.polyline(
                                    trajectComebackEdited.value,
                                    {
                                        color: "red",
                                        weight: 3,
                                    }
                                ).addTo(map);
                            }
                            studentsZ = studentsZ.filter(
                                (student) => student !== distination
                            );
                        }
                        confirmDel.value = true;
                    }
                }
            });
        });
    }
});
</script>
<template>
    <div class="col-md">
        <div class="card" style="max-height: 600px">
            <div
                v-if="route.name !== 'busschoolinfos'"
                class="card-status-top bg-blue"
            ></div>
            <div v-if="route.name !== 'busschoolinfos'" class="card-header">
                <h3 class="card-title">Zone and Students Positions</h3>
            </div>
            <div
                class="card-body p-0"
                :id="'map' + zone.id"
                :style="
                    route.name !== 'busschoolinfos'
                        ? 'height: 250px'
                        : 'height: 600px'
                "
            ></div>
        </div>
        <div
            v-if="studentsToDel.length !== 0"
            :class="
                !confirmDel
                    ? 'modal modal-blur fade'
                    : 'modal modal-blur fade show'
            "
            :style="!confirmDel ? 'display: none' : 'display: block;'"
            id="modal-danger"
            tabindex="-1"
            :aria-hidden="!confirmDel ? 'true' : 'false'"
            :aria-modal="!confirmDel ? 'false' : 'true'"
            role="dialog"
        >
            <div
                class="modal-dialog modal-sm modal-dialog-centered"
                role="document"
            >
                <div class="modal-content">
                    <button
                        @click="delStatus"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon mb-2 text-danger icon-lg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <path d="M12 9v2m0 4v.01"></path>
                            <path
                                d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"
                            ></path>
                        </svg>
                        <h3>Are you sure?</h3>
                        <div class="text-muted">
                            Do you really want to remove
                            {{ studentsToDel.length }} student(s) from this Bus
                            School?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <a
                                        @click="delStatus"
                                        href="#"
                                        class="btn w-100"
                                        data-bs-dismiss="modal"
                                    >
                                        Cancel
                                    </a>
                                </div>
                                <div class="col">
                                    <a
                                        @click="updateAndDelInfosMap"
                                        href="#"
                                        class="btn btn-danger w-100"
                                        data-bs-dismiss="modal"
                                    >
                                        Delete
                                        {{ studentsToDel.length }} student(s)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <EditBusSchool
            v-if="!planningStore.loading && edit"
            :busschool="
                busSchoolsStore.busschools.filter(
                    (busschool) =>
                        busschool.id === parseInt(route.params.busschool_id)
                )[0]
            "
            :students="
                studentsStore.students.filter(
                    (student) =>
                        student.bus_school_id ===
                        parseInt(route.params.busschool_id)
                )
            "
            :driver="
                driversStore.drivers.filter(
                    (driver) =>
                        driver.bus_school_id ===
                        parseInt(route.params.busschool_id)
                )[0]
            "
            :zone_id="
                zonesStore.zones.filter(
                    (zone) =>
                        zone.bus_school_id ===
                        parseInt(route.params.busschool_id)
                )[0].id
            "
            @update-data="updateDataBusSchool"
        />
    </div>
</template>
