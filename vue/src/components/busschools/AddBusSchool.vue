<script setup>
import L from "leaflet";
import "leaflet-routing-machine";
import "leaflet-control-geocoder";
import "leaflet-draw/dist/leaflet.draw-src.js";
import * as turf from "@turf/turf";
import { onMounted, ref, watch } from "vue";
import { useSchoolStore } from "../../stores/school";
import { useBusSchoolsStore } from "../../stores/busschools";
import { POSITION, useToast } from "vue-toastification";
import StudentsIntersectZone from "../students/StudentsIntersectZone.vue";
import { useStudentsStore } from "../../stores/students";
import { useZoneStore } from "../../stores/zones";
import { useTrajectStore } from "../../stores/trajects";
import { useDriversStore } from "../../stores/drivers";
import { usePlanningStore } from "../../stores/planning";
const toast = useToast();

//------------------------Variables-------------------------------------------
let map = ref(null);
const schoolStore = useSchoolStore();
const busSchoolStore = useBusSchoolsStore();
const studentsStore = useStudentsStore();
const zonesStore = useZoneStore();
const driverStore = useDriversStore();
const trajectsStore = useTrajectStore();
const planningStore = usePlanningStore();
const busschoolMatricule = ref("243532|A|44");
const busschoolCapacity = ref(26);
const active1 = ref("active");
const active2 = ref("");
const active3 = ref("");
const active4 = ref("");
const driverName = ref("RAJI Hamid");
const driverEmail = ref("hamid@gmail.com");
const driverCIN = ref("L543234");
let zonePolygon = ref([]);
let trajectGo = ref([]);
let trajectComeBack = ref([]);
let stops = ref([]);
const mondayGoAt = ref("07:00");
const mondayComeAt = ref("15:00");
const tuesdayGoAt = ref("07:00");
const tuesdayComeAt = ref("15:00");
const wednesdayGoAt = ref("07:00");
const wednesdayComeAt = ref("15:00");
const thursdayGoAt = ref("07:00");
const thursdayComeAt = ref("15:00");
const fridayGoAt = ref("07:00");
const fridayComeAt = ref("12:30");
//----------------------Fin Variables----------------------------------------

//--------------------------Fonctions----------------------------------------
//----------------------create bus school & driver & zone--------------------
const postTheData = async () => {
    const busschool = {
        matricule: busschoolMatricule.value,
        capacity: busschoolCapacity.value,
        school_id: schoolStore.school.id,
    };

    await busSchoolStore.createBusSchool(busschool);
    if (Object.keys(busSchoolStore.lastBusSchoolAdded).length !== 0) {
        const driver = {
            name: driverName.value,
            email: driverEmail.value,
            cin: driverCIN.value,
            password: driverCIN.value,
            school_id: schoolStore.school.id,
            bus_school_id: busSchoolStore.lastBusSchoolAdded.id,
        };
        const traject_go = {
            geometry: trajectGo.value,
            bus_school_id: busSchoolStore.lastBusSchoolAdded.id,
            school_id: schoolStore.school.id,
            type: "traject_go",
            stops: stops.value,
        };
        const traject_back = {
            geometry: trajectComeBack.value,
            bus_school_id: busSchoolStore.lastBusSchoolAdded.id,
            school_id: schoolStore.school.id,
            type: "traject_comeback",
            stops: null,
        };
        const zone = {
            geom: zonePolygon.value,
            bus_school_id: busSchoolStore.lastBusSchoolAdded.id,
            school_id: schoolStore.school.id,
        };
        const planning = {
            bus_school_id: busSchoolStore.lastBusSchoolAdded.id,
            monday_go_at: mondayGoAt.value,
            monday_comeback_at: mondayComeAt.value,
            tuesday_go_at: tuesdayGoAt.value,
            tuesday_comeback_at: tuesdayComeAt.value,
            wednesday_go_at: wednesdayGoAt.value,
            wednesday_comeback_at: wednesdayComeAt.value,
            thursday_go_at: thursdayGoAt.value,
            thursday_comeback_at: thursdayComeAt.value,
            friday_go_at: fridayGoAt.value,
            friday_comeback_at: fridayComeAt.value,
        };
        await planningStore.createPlanning(planning);
        await driverStore.createDriver(driver);
        await trajectsStore.createTraject(traject_go);
        await trajectsStore.createTraject(traject_back);
        await zonesStore.createZone(zone);

        if (Object.keys(zonesStore.busschoolZone).length !== 0) {
            await studentsStore.fetchStudentsIntersectZone(
                zonesStore.busschoolZone.id
            );
        }
    }
};
const addStdsToBschool = async () => {
    let students_id = [];
    studentsStore.studentsIntZone.forEach((student) => {
        students_id = students_id.concat(student.id);
    });
    console.log(students_id);

    const studentsInfo = {
        students_id: students_id,
        zone_id: zonesStore.busschoolZone.id,
        bus_school_id: busSchoolStore.lastBusSchoolAdded.id,
    };
    console.log(studentsInfo);
    await studentsStore.addStudentsToBusSchool(studentsInfo);
};
//----------------invalidate Size in the Add Zone Tab------------------------
const invalidateSize = () => {
    if (active3.value === "active") {
        map.invalidateSize();
    }
};
//---------------------------------------------------------------------------
const nextActiveTab = () => {
    if (active1.value === "active") {
        if (busschoolMatricule.value !== "" && busschoolCapacity.value !== 0) {
            active1.value = "";
            active2.value = "active";
        } else {
            toast.warning("Please enter all the fields", {
                position: POSITION.TOP_CENTER,
            });
        }
    } else if (active2.value === "active") {
        if (
            driverName.value !== "" &&
            driverEmail.value !== "" &&
            driverCIN.value !== ""
        ) {
            active2.value = "";
            active3.value = "active";
        } else {
            toast.warning("Please enter all the fields", {
                position: POSITION.TOP_CENTER,
            });
        }
    } else if (active3.value === "active") {
        if (zonePolygon.value.length !== 0) {
            active3.value = "";
            active4.value = "active";
            postTheData();
        } else {
            toast.error("Please draw a zone", {
                position: POSITION.TOP_CENTER,
            });
        }
    } else if ((active4.value = "active")) {
        addStdsToBschool();
    }
};
//---------------------------------------------------------------------------
const backActiveTab = () => {
    if (active2.value === "active") {
        active2.value = "";
        active1.value = "active";
    } else if (active3.value === "active") {
        active3.value = "";
        active2.value = "active";
    } else if (active4.value === "active") {
        active4.value = "";
        active3.value = "active";
    }
};
//---------------------------------------------------------------------------

//------------------Initialize Map-------------------------------------------
onMounted(() => {
    // Create the map
    var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        osmAttrib =
            '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib });
    map = new L.Map("map", {
        center: new L.LatLng(
            schoolStore.school.position.coordinates[1],
            schoolStore.school.position.coordinates[0]
        ),
        zoom: 15,
    });
    var drawnItems = L.featureGroup().addTo(map);
    let polyline;
    let centerZone;
    //Add Map types Control
    L.control
        .layers(
            {
                osm: osm.addTo(map),
                google: L.tileLayer(
                    "http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}",
                    {
                        attribution: "google",
                    }
                ),
            },
            { drawlayer: drawnItems },
            { position: "topright", collapsed: false }
        )
        .addTo(map);
    var options = {
        edit: {
            featureGroup: drawnItems,
        },
        draw: {
            polyline: false,
            marker: false,
            polygon: {
                shapeOptions: {
                    color: "green",
                },
            },
            circle: false,
            rectangle: false,
            circlemarker: false,
        },
        showRadius: true,
    };
    var drawControl = new L.Control.Draw(options);
    map.addControl(drawControl);
    //Custmize Icon of the current position

    //    var icon = L.divIcon({
    //      iconSize:null,
    //      html:'<div class="map-label '+instanceclass+'"><div class="map-label-content">'+icontext+'</div><div class="map-label-arrow"></div></div>'
    //    });

    //   L.marker(pos).addTo(map); //reference marker (for checking position)
    //   L.marker(pos,{icon: icon}).addTo(map);
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
    var zoneIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label greenbackground"><div class="map-label-content">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-polygon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/polygon </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="5" r="2"></circle><circle cx="19" cy="8" r="2"></circle><circle cx="5" cy="11" r="2"></circle><circle cx="15" cy="19" r="2"></circle><path d="M6.5 9.5l3.5 -3"></path><path d="M14 5.5l3 1.5"></path><path d="M18.5 10l-2.5 7"></path><path d="M13.5 17.5l-7 -5"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });
    var studentNoBsIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label redborder"><div class="map-label-content-red">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });
    //-----------------------Get route---------------------------------------------
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

    // add a marker in the given location
    var marker = L.marker([
        schoolStore.school.position.coordinates[1],
        schoolStore.school.position.coordinates[0],
    ]).addTo(map);
    var marker = L.marker(
        [
            schoolStore.school.position.coordinates[1],
            schoolStore.school.position.coordinates[0],
        ],
        {
            icon: defaultIcon,
        }
    ).addTo(map);
    if (studentsStore.studentsData) {
        studentsStore.students.forEach((student) => {
            if (student.bus_school_id !== null) {
                var marker = L.marker([
                    student.address_position.coordinates[1],
                    student.address_position.coordinates[0],
                ]).addTo(map);
                var marker = L.marker(
                    [
                        student.address_position.coordinates[1],
                        student.address_position.coordinates[0],
                    ],
                    {
                        icon: studentIcon,
                    }
                ).addTo(map);
            } else {
                var marker = L.marker([
                    student.address_position.coordinates[1],
                    student.address_position.coordinates[0],
                ]).addTo(map);
                var marker = L.marker(
                    [
                        student.address_position.coordinates[1],
                        student.address_position.coordinates[0],
                    ],
                    {
                        icon: studentNoBsIcon,
                    }
                ).addTo(map);
            }
        });
    }

    if (zonesStore.zonesData) {
        zonesStore.zones.forEach((zone) => {
            var latlngs = [];
            zone.geom.coordinates[0].forEach((point) => {
                var latlng = [point[1], point[0]];
                latlngs = latlngs.concat([latlng]);
            });

            L.polygon(latlngs, { color: "green" }).addTo(map);
        });
    }
    map.on("draw:edited", function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            var shape = layer.toGeoJSON();
            map.removeLayer(centerZone);
            map.removeLayer(polyline);
            const centerLayer = layer.getBounds().getCenter();
            //Custmize Icon of the current position

            centerZone = L.marker([centerLayer.lat, centerLayer.lng], {
                icon: zoneIcon,
            }).addTo(map);
            var wayPoint1 = L.latLng(
                schoolStore.school.position.coordinates[1],
                schoolStore.school.position.coordinates[0]
            );
            var wayPoint2 = L.latLng(centerLayer.lat, centerLayer.lng);

            var rWP1 = new L.Routing.Waypoint();
            rWP1.latLng = wayPoint1;

            var rWP2 = new L.Routing.Waypoint();
            rWP2.latLng = wayPoint2;
            var myRoute = L.Routing.osrmv1();
            var myRoute = L.Routing.osrmv1();
            myRoute.route([rWP1, rWP2], function (err, routes) {
                polyline = L.polyline(routes[0].coordinates, {
                    color: "#6841C2",
                }).addTo(map);
                trajects.value = routes[0].coordinates;
            });

            map.fitBounds(L.latLngBounds(wayPoint1, wayPoint2));

            zonePolygon.value = shape.geometry.coordinates[0];
        });
    });
    map.on("draw:deleted", function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            var shape = layer.toGeoJSON();

            map.removeLayer(centerZone);
            map.removeLayer(polyline);
            zonePolygon.value = [];
            trajects.value = [];
            drawControl.setDrawingOptions({
                polygon: {
                    shapeOptions: {
                        color: "green",
                    },
                },
                polyline: false,
                marker: false,
                circle: false,
                rectangle: false,
                circlemarker: false,
            });
            map.removeControl(drawControl);
            map.addControl(drawControl);
        });
    });
    map.on(L.Draw.Event.CREATED, async function (event) {
        var layer = event.layer;
        var studentsIntZone = [];
        var firstStudent;
        if (studentsStore.students) {
            studentsStore.students.forEach((student) => {
                if (student.bus_school_id === null) {
                    if (
                        turf.booleanPointInPolygon(
                            student.address_position,
                            layer.toGeoJSON()
                        )
                    ) {
                        studentsIntZone = studentsIntZone.concat(student);
                    }
                }
            });
        }
        if (studentsIntZone.length > 0) {
            //--------------------Find the first student in the traject---------------------------
            const r = await Promise.all(
                studentsIntZone.map(async (student) => [
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

            console.log({ firstStudent });
            L.polyline(sorted[0][0].coordinates, {
                color: "#000000",
                width: 5,
            }).addTo(map);
            trajectGo.value = trajectGo.value.concat(sorted[0][0].coordinates);
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
            ).addTo(map);
            // ---------------Find the optimale traject to all students------------------------
            var studentsZ = [...studentsIntZone];
            studentsZ = studentsZ.filter(
                (student, index) => student !== firstStudent
            );
            let j = 0;
            let lengthS = studentsZ.length;
            var latlngs = [];
            drawnItems.addLayer(layer);
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
                    L.polyline(sorted[0][0].coordinates, {
                        color: "#000000",
                        width: 5,
                    }).addTo(map);
                    trajectGo.value = trajectGo.value.concat(
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
                    ).addTo(map);
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
                    const result = await get_route(pickUp, schoolStore.school);
                    var pol = L.polyline(result.coordinates, {
                        color: "red",
                        weight: 3,
                    });
                    trajectComeBack.value = trajectComeBack.value.concat(
                        result.coordinates
                    );
                    console.log(trajectComeBack.value);
                    console.log(trajectGo.value);
                    console.log(stops.value);
                    pol.addTo(map);
                }
                studentsZ = studentsZ.filter(
                    (student) => student !== distination
                );
            }
        }

        // const centerLayer = layer.getBounds().getCenter();
        // //Custmize Icon of the current position
        // centerZone = L.marker([centerLayer.lat, centerLayer.lng], {
        //     icon: zoneIcon,
        // }).addTo(map);
        // var wayPoint1 = L.latLng(
        //     schoolStore.school.position.coordinates[1],
        //     schoolStore.school.position.coordinates[0]
        // );
        // var wayPoint2 = L.latLng(centerLayer.lat, centerLayer.lng);

        // var rWP1 = new L.Routing.Waypoint();
        // rWP1.latLng = wayPoint1;

        // var rWP2 = new L.Routing.Waypoint();
        // rWP2.latLng = wayPoint2;
        // var myRoute = L.Routing.osrmv1();
        // var myRoute = L.Routing.osrmv1();
        // myRoute.route([rWP1, rWP2], function (err, routes) {
        //     polyline = L.polyline(routes[0].coordinates, {
        //         color: "#6841C2",
        //     }).addTo(map);
        //     trajectPolyline.value = routes[0].coordinates;
        // });

        // map.fitBounds(L.latLngBounds(wayPoint1, wayPoint2));
        var shape = layer.toGeoJSON();
        zonePolygon.value = shape.geometry.coordinates[0];

        drawControl.setDrawingOptions({
            polygon: false,
            polyline: false,
            marker: false,
            circle: false,
            rectangle: false,
            circlemarker: false,
        });
        map.removeControl(drawControl);
        map.addControl(drawControl);
    });
});
//---------------------------------------------------------------------------
watch([active3], () => setTimeout(invalidateSize, 100));
</script>
<template>
    <div class="col-12">
        <!-- Cards with tabs component -->
        <div class="card-tabs w-100">
            <div class="tab-content">
                <!-- Cards navigation -->

                <div class="nav nav-tabs nav-tabs-bottom steps mb-3">
                    <a
                        href="#tab-bottom-1"
                        data-bs-toggle="tab"
                        :class="'step-item ' + active1 + ' disabled'"
                    >
                        Add Bus School Infos
                    </a>
                    <a
                        href="#tab-bottom-2"
                        data-bs-toggle="tab"
                        :class="'step-item ' + active2 + ' disabled'"
                    >
                        Add Driver
                    </a>
                    <a
                        href="#tab-bottom-3"
                        data-bs-toggle="tab"
                        :class="'step-item ' + active3 + ' disabled'"
                    >
                        Add Zone
                    </a>
                    <a
                        href="#tab-bottom-4"
                        data-bs-toggle="tab"
                        :class="'step-item ' + active4 + ' disabled'"
                    >
                        Select Students
                    </a>
                </div>
                <!-- Content of card #1 -->
                <div id="tab-bottom-1" :class="'card tab-pane ' + active1">
                    <div class="card-header">
                        <h3 class="card-title">Add Bus School</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Bus School matricule</label
                                    >
                                    <input
                                        type="text"
                                        v-model="busschoolMatricule"
                                        class="form-control"
                                        placeholder="Enter bus school matricule"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Bus School capacity</label
                                    >
                                    <input
                                        type="number"
                                        v-model="busschoolCapacity"
                                        class="form-control"
                                        placeholder="Enter bus school capacity"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title" id="accordion-example">
                            <h2 id="heading-1">
                                <button
                                    class="accordion-button"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse-1"
                                    aria-expanded="true"
                                    style="font-size: 18px"
                                >
                                    Planning
                                </button>
                            </h2>
                        </div>
                        <div
                            class="accordion-collapse collapse row"
                            id="collapse-1"
                            data-bs-parent="#accordion-example"
                        >
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label">Monday</label>
                                        <div class="row">
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Go at</label
                                                >
                                                <input
                                                    type="time"
                                                    v-model="mondayGoAt"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Come at</label
                                                >
                                                <input
                                                    type="time"
                                                    v-model="mondayComeAt"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label"
                                            >Tuesday</label
                                        >
                                        <div class="row">
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Go at</label
                                                >
                                                <input
                                                    v-model="tuesdayGoAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Come at</label
                                                >
                                                <input
                                                    v-model="tuesdayComeAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-text text-primary"></div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label"
                                            >Wednesday</label
                                        >
                                        <div class="row">
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Go at</label
                                                >
                                                <input
                                                    v-model="wednesdayGoAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Come at</label
                                                >
                                                <input
                                                    v-model="wednesdayComeAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label"
                                            >Thursday</label
                                        >
                                        <div class="row">
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Go at</label
                                                >
                                                <input
                                                    v-model="thursdayGoAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Come at</label
                                                >
                                                <input
                                                    v-model="thursdayComeAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-text text-primary"></div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label">Friday</label>
                                        <div class="row">
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Go at</label
                                                >
                                                <input
                                                    v-model="fridayGoAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                            <div class="col-lg-3 w-50">
                                                <label
                                                    class="form-label"
                                                    style="font-size: 12px"
                                                    >Come at</label
                                                >
                                                <input
                                                    v-model="fridayComeAt"
                                                    type="time"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content of card #2 -->
                <div id="tab-bottom-2" :class="'card tab-pane ' + active2">
                    <div class="card-header">
                        <h3 class="card-title">Add Driver</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Driver name</label
                                    >
                                    <input
                                        type="text"
                                        v-model="driverName"
                                        class="form-control"
                                        placeholder="Enter driver name"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Driver email</label
                                    >
                                    <input
                                        type="email"
                                        v-model="driverEmail"
                                        class="form-control"
                                        placeholder="Enter driver email"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Driver CIN</label
                                    >
                                    <input
                                        type="text"
                                        v-model="driverCIN"
                                        class="form-control"
                                        placeholder="Enter driver CIN"
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content of card #3 -->
                <div id="tab-bottom-3" :class="'card tab-pane ' + active3">
                    <div class="card-header">
                        <h3 class="card-title">Add Zone</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-12" id="map"></div>
                    </div>
                </div>
                <!-- Content of card #4 -->
                <div id="tab-bottom-4" :class="'card tab-pane ' + active4">
                    <div class="card-header">
                        <h3 class="card-title">Select Students</h3>
                    </div>
                    <div class="card-body">
                        <!-- Student that doesn't have a bus school and intersecte with the bus school zone -->
                        <StudentsIntersectZone />
                    </div>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="pagination m-0"></div>
                    <div class="pagination m-0 ms-auto">
                        <button
                            v-if="active1 === '' && active4 === ''"
                            @click="backActiveTab"
                            class="btn btn-danger m-2"
                        >
                            Back
                        </button>
                        <button
                            @click="nextActiveTab"
                            class="btn btn-primary m-2"
                        >
                            {{ active4 !== "active" ? "Next" : "Submit" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
#map {
    height: 600px;
}
</style>
