<script setup>
import L from "leaflet";
import "leaflet-draw";
import { useSchoolStore } from "../../stores/school";
import { onMounted, ref } from "vue";
import router from "../../router";
const schoolStore = useSchoolStore();
const schoolname = ref("College Ibn Sinna");
const schooladdress = ref("TETOUAN Avenue Boulevard Hassan 2, Maroc");
const lat = ref(0);
const lng = ref(0);
const addSchool = async () => {
    const schoolInfos = {
        name: schoolname.value,
        address: schooladdress.value,
        address_lat: `${lat.value}`,
        address_lng: `${lng.value}`,
    };
    await schoolStore.createSchool(schoolInfos);
    router.push("/admin/school");
};
onMounted(() => {
    // if (navigator.geolocation) {
    //     //get the current position
    //     navigator.geolocation.getCurrentPosition((pos) => {
    //         lat.value = pos.coords.latitude;
    //         lng.value = pos.coords.longitude;

    //         // center of the map
    //         var center = [lat.value, lng.value];

    //         // Create the map
    //         var map = L.map("map", { drawControl: true }).setView(center, 15);

    //         // Set up the OSM layer
    //         L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    //             attribution:
    //                 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
    //             maxZoom: 18,
    //         }).addTo(map);

    //         //Custmize Icon of the current position
    //         var defaultIcon = L.icon({
    //             iconUrl: "/src/assets/School-icon.png",
    //             iconSize: [33, 33],
    //             iconAnchor: [18, 18],
    //             popupAnchor: [0, -10],
    //             shadowSize: [0, 0],
    //             shadowAnchor: [10, 10],
    //         });

    //         // add a marker in the given location
    //         var marker = L.marker(center, {
    //             icon: defaultIcon,
    //             draggable: "true",
    //         }).addTo(map);
    //         // Initialise the FeatureGroup to store editable layers
    //         var editableLayers = new L.FeatureGroup();
    //         map.addLayer(editableLayers);

    //         var drawPluginOptions = {
    //             position: "topright",
    //             draw: {
    //                 polygon: {
    //                     allowIntersection: false, // Restricts shapes to simple polygons
    //                     drawError: {
    //                         color: "#e1e100", // Color the shape will turn when intersects
    //                         message:
    //                             "<strong>Oh snap!<strong> you can't draw that!", // Message that will show when intersect
    //                     },
    //                     shapeOptions: {
    //                         color: "#97009c",
    //                     },
    //                 },
    //                 // disable toolbar item by setting it to false
    //                 polyline: false,
    //                 circle: false, // Turns off this drawing tool
    //                 rectangle: false,
    //                 marker: false,
    //             },
    //             edit: {
    //                 featureGroup: editableLayers, //REQUIRED!!
    //                 poly: {
    //                     allowIntersection: false,
    //                 },
    //                 remove: true,
    //             },
    //         };

    //         // Initialise the draw control and pass it the FeatureGroup of editable layers
    //         var drawControl = new L.Control.Draw(drawPluginOptions);
    //         map.addControl(drawControl);
    //         // Initialise the draw
    //         map.on("draw:created", function (e) {
    //             var type = e.layerType,
    //                 layer = e.layer;
    //             if (type === "marker") {
    //                 layer.bindPopup("A popup!");
    //             }
    //             console.log(layer);
    //             editableLayers.addLayer(layer);
    //         });

    //         map.on("draw:edited", function (e) {
    //             let layers = e.layers;
    //             layers.eachLayer(function (layer) {
    //                 console.log(layer);
    //             });
    //         });

    //         marker.on("dragend", function (event) {
    //             var position = marker.getLatLng();
    //             lat.value = position.lat;
    //             lng.value = position.lng;
    //             console.log(position);
    //             marker.setLatLng(position, {
    //                 icon: defaultIcon,
    //                 draggable: "true",
    //             });
    //             // .bindPopup(position)
    //             // .update();
    //             marker.bindPopup(`${lat.value} <br> ${lng.value}`);
    //         });
    //     });
    // }
    navigator.geolocation.getCurrentPosition((pos) => {
        //Current position of the admin
        lat.value = pos.coords.latitude;
        lng.value = pos.coords.longitude;

        // Create the map
        var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            osmAttrib =
                '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib }),
            map = new L.Map("map", {
                center: new L.LatLng(lat.value, lng.value),
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

        //Custmize Icon of the current position
        var defaultIcon = L.divIcon({
            iconSize: null,
            html: `<div class="map-label blueborder"><div class="map-label-content">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/school </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path></svg>
        </div><div class="map-label-arrow"></div></div>`,
        });

        // add a marker in the given location
        var marker = L.marker([lat.value, lng.value], {
            icon: defaultIcon,
            draggable: "true",
        }).addTo(map);

        //Udapted the lat ,lng when the marker is dragend
        marker.on("dragend", function (event) {
            var position = marker.getLatLng();
            lat.value = position.lat;
            lng.value = position.lng;
            console.log(position);
            marker.setLatLng(position, {
                icon: defaultIcon,
                draggable: "true",
            });
            // // .bindPopup(position)
            // // .update();
            // marker.bindPopup(`${lat.value} <br> ${lng.value}`);
        });

        // //Display lat,lng when the user click the marker
        // marker.on("click",function (event) {
        //     marker.bindPopup(`${lat.value} <br> ${lng.value}`);
        // })
    });

    // map.addControl(
    //     new L.Control.Draw({
    //         edit: {
    //             featureGroup: drawnItems,
    //             poly: {
    //                 allowIntersection: false,
    //             },
    //         },
    //         draw: {
    //             polygon: {
    //                 allowIntersection: false,
    //                 showArea: true,
    //             },
    //         },
    //     })
    // );

    // map.on(L.Draw.Event.CREATED, function (event) {
    //     var layer = event.layer;

    //     drawnItems.addLayer(layer);
    // });
});
</script>
<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add School</h3>
            </div>
            <div class="card-body border-bottom py-3">
                <div class="row row-deck row-cards">
                    <div class="col-lg-6">
                        <div class="row row-cards">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label required"
                                                >School name</label
                                            >
                                            <input
                                                type="text"
                                                v-model="schoolname"
                                                class="form-control"
                                                placeholder="Enter school name"
                                                autocomplete="off"
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required"
                                                >School address</label
                                            >
                                            <input
                                                type="text"
                                                v-model="schooladdress"
                                                class="form-control"
                                                placeholder="Enter school address"
                                                autocomplete="off"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row row-cards">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center">
                <div class="pagination m-0 ms-auto">
                    <a
                        @click="addSchool"
                        :class="
                            schoolStore.loading
                                ? 'btn btn-primary btn-loading'
                                : 'btn btn-primary'
                        "
                        href="#"
                    >
                        Submit
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
#map {
    height: 500px;
}
</style>
