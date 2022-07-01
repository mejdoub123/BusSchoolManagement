<script setup>
import { onMounted } from "vue";
import { useBusSchoolsStore } from "../../stores/busschools";
import { useSchoolStore } from "../../stores/school";
import { useStudentsStore } from "../../stores/students";
import { useTrajectStore } from "../../stores/trajects";
import { useZoneStore } from "../../stores/zones";
const schoolStore = useSchoolStore();
const busSchoolsStore = useBusSchoolsStore();
const studentsStore = useStudentsStore();
const zonesStore = useZoneStore();
const trajectsStore = useTrajectStore();
onMounted(() => {
    // Create the map
    var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        osmAttrib =
            '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib }),
        map = new L.Map("map", {
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

    var legend = L.control({ position: "bottomleft" });
    var nbrStops = 0;
    trajectsStore.trajects.filter((traject) => {
        if (traject.type === "traject_go") {
            nbrStops = nbrStops + traject.stops.coordinates.length;
        }
    });
    legend.onAdd = function (map) {
        var div = L.DomUtil.create("div", "card m-1");

        var lebels = [
            `
            <div class="card-body m-0">
            <div class="row align-items-center">
            <div class="col-auto">
            <span class="badge badge-outline text-indigo">
            <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/school </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path></svg>
            </span>
            </div>
            <div class="col">
            <div class="font-weight-medium">School position</div>
            </div>
            </div>
            <div class="row align-items-center mt-1">
            <div class="col-auto">
            <span class="badge badge-outline text-red">
            <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
            </span>
            </div>
            <div class="col">
            <div class="font-weight-medium">${
                studentsStore.students.filter(
                    (student) => student.bus_school_id === null
                ).length
            } Students still have no bus school</div>
            </div>
            </div>
            <div class="row align-items-center mt-1">
            <div class="col-auto">
            <span class="badge badge-outline text-yellow">
            <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
            </span>
            </div>
            <div class="col">
            <div class="font-weight-medium">${
                studentsStore.students.filter(
                    (student) => student.bus_school_id !== null
                ).length
            } Students who have a bus school</div>
            </div>
            </div>
            <div class="row align-items-center mt-1">
            <div class="col-auto">
            <span class="badge badge-outline text-green">
            <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
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
            </svg>
            </span>
            </div>
            <div class="col">
            <div class="font-weight-medium">${nbrStops} Bus schools Stations</div>
            </div>
            </div>
            <div class="row align-items-center mt-1">
            <div class="col-auto">
            <span class="badge badge-outline text-black">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-timeline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 16l6 -7l5 5l5 -6"></path>
                    <circle cx="15" cy="14" r="1"></circle>
                    <circle cx="10" cy="9" r="1"></circle>
                    <circle cx="4" cy="16" r="1"></circle>
                    <circle cx="20" cy="8" r="1"></circle>
                </svg>
            </span>
            </div>
            <div class="col">
            <div class="font-weight-medium">${
                trajectsStore.trajects.length
            } Bus schools trajects</div>
            </div>
            </div>
            </div>`,
        ];

        div.innerHTML = lebels;
        return div;
    };

    legend.addTo(map);
    // var legend = L.control({ position: "bottomleft" });
    // legend.onAdd = `<div class="card">legend</div>`;
    // legend.addTo(map);
    //Custmize Icon of the current position
    //Custmize Icon of the current position
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
    var studentNoBsIcon = L.divIcon({
        iconSize: null,
        html: `<div class="map-label redborder"><div class="map-label-content-red">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
    });
    var zoneIcon = L.divIcon({
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
                    </svg>
                    </div>
                <div class="map-label-arrow"></div></div>`,
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
            var latlngsZone = [];
            zone.geom.coordinates[0].forEach((point) => {
                var latlng = [point[1], point[0]];
                latlngsZone = latlngsZone.concat([latlng]);
            });

            const zoneAdd = L.polygon(latlngsZone, { color: "green" }).addTo(
                map
            );
        });
    }
    if (trajectsStore.trajectsData) {
        trajectsStore.trajects.forEach((traject) => {
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
                    L.marker([coordinate[1], coordinate[0]], {
                        icon: stopIcon,
                    }).addTo(map);
                });
            }
            traject.geometry.coordinates.forEach((point) => {
                var latlng = [point[1], point[0]];
                latlngsTraject = latlngsTraject.concat([latlng]);
            });
            if (traject.type === "traject_go") {
                L.polyline(latlngsTraject, {
                    color: "#422361",
                    weight: 3,
                }).addTo(map);
            } else {
                L.polyline(latlngsTraject, {
                    color: "red",

                    weight: 3,
                }).addTo(map);
            }
        });
    }
});
</script>
<template>
    <div class="card-body" id="map"></div>
</template>
<style scoped>
#map {
    height: 500px;
}
</style>
