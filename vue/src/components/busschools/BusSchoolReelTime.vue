<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useDriversStore } from "../../stores/drivers";
import { usePlanningStore } from "../../stores/planning";
import { useSchoolStore } from "../../stores/school";
import { useStudentsStore } from "../../stores/students";
import { useTrajectStore } from "../../stores/trajects";
import { useZoneStore } from "../../stores/zones";
import LatLon from "geodesy/latlon-spherical";
import "leaflet-marker-rotation";
const schoolStore = useSchoolStore();
const route = useRoute();
const busSchoolsStore = useBusSchoolsStore();
const studentsStore = useStudentsStore();
const driversStore = useDriversStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
const planningStore = usePlanningStore();
let busschoolInfo = ref({});
let driverInfo = ref({});
let zoneInfo = ref({});
let trajectsInfo = ref([]);
let studentsInfo = ref([]);
onMounted(() => {
    busSchoolsStore.busschools.map((busschool) => {
        if (busschool.id === parseInt(route.params.busschool_id)) {
            busschoolInfo.value = busschool;
        }
    });
    driversStore.drivers.map((driver) => {
        if (driver.bus_school_id === parseInt(route.params.busschool_id)) {
            driverInfo.value = driver;
        }
    });
    studentsStore.students.map((student) => {
        if (student.bus_school_id === parseInt(route.params.busschool_id)) {
            studentsInfo.value = studentsInfo.value.concat(student);
        }
    });
    zonesStore.zones.map((zone) => {
        if (zone.bus_school_id === parseInt(route.params.busschool_id)) {
            zoneInfo.value = zone;
        }
    });
    trajectsStore.trajects.map((traject) => {
        if (traject.bus_school_id === parseInt(route.params.busschool_id)) {
            trajectsInfo.value = trajectsInfo.value.concat(traject);
        }
    });
    var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        osmAttrib =
            '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib }),
        map = new L.Map("map-container", {
            center: new L.LatLng(
                schoolStore.school.position.coordinates[1],
                schoolStore.school.position.coordinates[0]
            ),
            zoom: 15,
        }),
        drawnItems = L.featureGroup().addTo(map);

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

    var defaultIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label blueborder"><div class="map-label-content">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/school </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });
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
    //----------------Students---------------------------------
    var studentIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label yellowborder"><div class="map-label-content-yellow">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });
    studentsInfo.value.forEach((student) => {
        L.marker(
            [
                student.address_position.coordinates[1],
                student.address_position.coordinates[0],
            ],
            {
                icon: studentIcon,
            }
        ).addTo(map);
    });
    //------------------------Zone-----------------------------------
    var latlngsZone = [];
    zoneInfo.value.geom.coordinates[0].forEach((point) => {
        var latlng = [point[1], point[0]];
        latlngsZone = latlngsZone.concat([latlng]);
    });
    var zoneAdd = L.polygon(latlngsZone, { color: "green" });
    zoneAdd.addTo(map);
    //------------------------Trajects-------------------------------
    var allPointsTraject = [];
    var latlngsTrajectGo = [];
    var latlngsTrajectComeBack = [];
    trajectsInfo.value.forEach((traject) => {
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

                L.marker([coordinate[1], coordinate[0]], {
                    icon: stopIcon,
                }).addTo(map);
            });
        }

        if (traject.type === "traject_go") {
            traject.geometry.coordinates.forEach((point) => {
                var latlng = [point[1], point[0]];
                latlngsTrajectGo = latlngsTrajectGo.concat([latlng]);
            });
            L.polyline(latlngsTrajectGo, {
                color: "#422361",
                weight: 3,
            }).addTo(map);
        } else {
            traject.geometry.coordinates.forEach((point) => {
                var latlng = [point[1], point[0]];
                latlngsTrajectComeBack = latlngsTrajectComeBack.concat([
                    latlng,
                ]);
            });
            L.polyline(latlngsTrajectComeBack, {
                color: "red",

                weight: 3,
            }).addTo(map);
        }
    });
    if (latlngsTrajectGo.length > 0 || latlngsTrajectComeBack.length > 0) {
        allPointsTraject = allPointsTraject.concat(latlngsTrajectGo);
        allPointsTraject = allPointsTraject.concat(latlngsTrajectComeBack);
    }

    var markerBus;
    allPointsTraject.forEach(async (point, index) => {
        var icon = L.icon({
            iconUrl: "/src/assets/bus-school-icon-reel-time.png",
            iconSize: [70, 40],
        });
        if (index === 0) {
            const p1 = new LatLon(
                schoolStore.school.position.coordinates[1],
                schoolStore.school.position.coordinates[0]
            );
            const p2 = new LatLon(point[0], point[1]);
            const b1 = p1.initialBearingTo(p2);

            markerBus = L.rotatedMarker([point[0], point[1]], {
                icon: icon,
                rotationAngle: b1,
            }).addTo(map);
        } else {
            setTimeout(() => {
                if (index < allPointsTraject.length - 1) {
                    const p1 = new LatLon(point[0], point[1]);
                    const p2 = new LatLon(
                        allPointsTraject[index + 1][0],
                        allPointsTraject[index + 1][1]
                    );
                    const b1 = p1.initialBearingTo(p2);

                    var newLatLng = new L.LatLng(point[0], point[1]);
                    map.removeLayer(markerBus);
                    markerBus = L.rotatedMarker([point[0], point[1]], {
                        icon: icon,
                        rotationAngle: b1,
                        rotationOrigin: "50% 15%",
                    }).addTo(map);
                    
                    // markerBus.setLatLng(newLatLng).update();
                    map.setView(markerBus.getLatLng(), map.getZoom());
                }
            }, 200 * index);
        }
    });
});
</script>
<template>
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-blue text-white avatar"
                                        ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-bus"
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
                                            <circle
                                                cx="6"
                                                cy="17"
                                                r="2"
                                            ></circle>
                                            <circle
                                                cx="18"
                                                cy="17"
                                                r="2"
                                            ></circle>
                                            <path
                                                d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"
                                            ></path>
                                            <polyline
                                                points="16 5 17.5 12 22 12"
                                            ></polyline>
                                            <line
                                                x1="2"
                                                y1="10"
                                                x2="17"
                                                y2="10"
                                            ></line>
                                            <line
                                                x1="7"
                                                y1="5"
                                                x2="7"
                                                y2="10"
                                            ></line>
                                            <line
                                                x1="12"
                                                y1="5"
                                                x2="12"
                                                y2="10"
                                            ></line>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        <span class="badge bg-teal-lt mb-1">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-a-b"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <desc>
                                                    Download more icon variants
                                                    from
                                                    https://tabler-icons.io/i/a-b
                                                </desc>
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                ></path>
                                                <path
                                                    d="M3 16v-5.5a2.5 2.5 0 0 1 5 0v5.5m0 -4h-5"
                                                ></path>
                                                <line
                                                    x1="12"
                                                    y1="6"
                                                    x2="12"
                                                    y2="18"
                                                ></line>
                                                <path
                                                    d="M16 16v-8h3a2 2 0 0 1 0 4h-3m3 0a2 2 0 0 1 0 4h-3"
                                                ></path>
                                            </svg>
                                            {{ " " + busschoolInfo.matricule }}
                                        </span>
                                    </div>
                                    <div class="text-muted">
                                        <span
                                            class="badge badge-outline text-blue"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-yoga"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <desc>
                                                    Download more icon variants
                                                    from
                                                    https://tabler-icons.io/i/yoga
                                                </desc>
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                ></path>
                                                <circle
                                                    cx="12"
                                                    cy="4"
                                                    r="1"
                                                ></circle>
                                                <path d="M4 20h4l1.5 -3"></path>
                                                <path
                                                    d="M17 20l-1 -5h-5l1 -7"
                                                ></path>
                                                <path
                                                    d="M4 10l4 -1l4 -1l4 1.5l4 1.5"
                                                ></path>
                                            </svg>

                                            {{
                                                " " +
                                                studentsInfo.length +
                                                "/" +
                                                busschoolInfo.capacity
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-green text-white avatar"
                                        ><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-steering-wheel"
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
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            ></circle>
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="2"
                                            ></circle>
                                            <line
                                                x1="12"
                                                y1="14"
                                                x2="12"
                                                y2="21"
                                            ></line>
                                            <line
                                                x1="10"
                                                y1="12"
                                                x2="3.25"
                                                y2="10"
                                            ></line>
                                            <line
                                                x1="14"
                                                y1="12"
                                                x2="20.75"
                                                y2="10"
                                            ></line>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium mb-2">
                                        <span
                                            class="badge badge-outline text-azure"
                                            >NAME</span
                                        >
                                        {{ driverInfo.name }}
                                    </div>
                                    <div class="text-muted mt-1 mb-1">
                                        <span
                                            class="badge badge-outline text-indigo"
                                            >CIN</span
                                        >
                                        {{ " " + driverInfo.cin }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8" id="map-container"></div>
        <div class="col-md-6 col-lg-4">
            <div class="space-y" style="width: 100%">
                <div class="card">
                    <h3 class="card-header">
                        <span class="badge bg-azure"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-clock"
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
                                <circle cx="12" cy="12" r="9"></circle>
                                <polyline points="12 7 12 12 15 15"></polyline>
                            </svg>
                            Trip date & time</span
                        >
                    </h3>
                    <div class="card-body">
                        <label class="form-label">Monday</label>
                        <div class="row">
                            <div class="col-lg-3 w-100">
                                <label
                                    class="form-label"
                                    style="font-size: 12px"
                                    >Trip Time</label
                                >
                                <input
                                    type="time"
                                    value="07:00"
                                    class="form-control"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h3 class="card-header">
                        <span class="badge bg-lime"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-checkup-list"
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
                                <path
                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"
                                ></path>
                                <rect
                                    x="9"
                                    y="3"
                                    width="6"
                                    height="4"
                                    rx="2"
                                ></rect>
                                <path d="M9 14h.01"></path>
                                <path d="M9 17h.01"></path>
                                <path d="M12 16l1 1l3 -3"></path>
                            </svg>
                            Liste of absences</span
                        >
                    </h3>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-title">
                                There is no student absent yet!
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h3 class="card-header">
                        <span class="badge bg-cyan"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-shape-3"
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
                                <circle cx="5" cy="5" r="2"></circle>
                                <circle cx="19" cy="19" r="2"></circle>
                                <circle cx="19" cy="5" r="2"></circle>
                                <circle cx="5" cy="19" r="2"></circle>
                                <path d="M7 5h10m-12 2v10m14 -10v10"></path>
                            </svg>
                            Traject Infos</span
                        >
                    </h3>
                    <div class="card-body">
                        <div class="col">
                            <span class="badge badge-outline text-blue">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-alarm"
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
                                    <circle cx="12" cy="13" r="7"></circle>
                                    <polyline
                                        points="12 10 12 13 14 13"
                                    ></polyline>
                                    <line x1="7" y1="4" x2="4.25" y2="6"></line>
                                    <line
                                        x1="17"
                                        y1="4"
                                        x2="19.75"
                                        y2="6"
                                    ></line></svg
                            ></span>
                            <input
                                type="text"
                                value="22 min 31s "
                                class="form-control mt-2"
                                disabled
                            />
                        </div>
                        <div class="col mt-3">
                            <span class="badge badge-outline text-orange">
                                Km
                            </span>
                            <input
                                type="text"
                                value="4.8 Km"
                                class="form-control mt-2"
                                disabled
                            />
                        </div>

                        <div class="col mt-3">
                            <span class="badge badge-outline text-pink">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-list-numbers"
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
                                    <path d="M11 6h9"></path>
                                    <path d="M11 12h9"></path>
                                    <path d="M12 18h8"></path>
                                    <path
                                        d="M4 16a2 2 0 1 1 4 0c0 .591 -.5 1 -1 1.5l-3 2.5h4"
                                    ></path>
                                    <path d="M6 10v-6l-2 2"></path>
                                </svg>
                            </span>
                            <input
                                type="text"
                                value="4 Stops"
                                class="form-control mt-2"
                                disabled
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
#map-container {
    height: 700px;
    border-radius: 10px;
}
</style>
