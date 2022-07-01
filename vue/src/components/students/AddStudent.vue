<script setup>
import L from "leaflet";
import "leaflet-draw";
import { onMounted, ref } from "vue";
import { useSchoolStore } from "../../stores/school";
import { useStudentsStore } from "../../stores/students";
const schoolStore = useSchoolStore();
const studentsStore = useStudentsStore();
const address_lat = ref(0);
const address_lng = ref(0);
const student_name = ref("Student1");
const student_email = ref("s1@gmail.com");
const student_cne = ref("s1");
const student_phone = ref("0611111111");
const student_address = ref("S1 Address");
const addStudent = async () => {
    const student = {
        name: student_name.value,
        email: student_email.value,
        cne: student_cne.value,
        address: student_address.value,
        address_lat: address_lng.value,
        address_lng: address_lat.value,
        phone_number: student_phone.value,
    };
    await studentsStore.createStudent(student);
};
onMounted(() => {
    navigator.geolocation.getCurrentPosition((pos) => {
        //Current position of the admin
        address_lat.value = pos.coords.latitude;
        address_lng.value = pos.coords.longitude;
        // Create the map
        var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            osmAttrib =
                '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib }),
            map = new L.Map("map-address-position", {
                center: new L.LatLng(address_lat.value, address_lng.value),
                zoom: 16,
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

        var studentIcon = L.divIcon({
            iconSize: null,
            html: `<div class="map-label yellowborder"><div class="map-label-content-yellow">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-yoga" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><desc> Download more icon variants from https://tabler-icons.io/i/yoga </desc><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="4" r="1"></circle><path d="M4 20h4l1.5 -3"></path><path d="M17 20l-1 -5h-5l1 -7"></path><path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg>
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
        var markerStudentAddress = L.marker(
            [address_lat.value, address_lng.value],
            {
                icon: studentIcon,
                draggable: "true",
            }
        ).addTo(map);
        //Udapted the lat ,lng when the marker is dragend
        markerStudentAddress.on("dragend", function (event) {
            var position = markerStudentAddress.getLatLng();
            address_lat.value = position.lat;
            address_lng.value = position.lng;
            console.log(position);
            markerStudentAddress.setLatLng(position, {
                icon: studentIcon,
                draggable: "true",
            });
        });
    });
});
</script>
<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Student</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col-md-6 col-xl-12">
                                <label class="form-label">Student Infos</label>
                                <fieldset class="form-fieldset">
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Full name</label
                                        >
                                        <input
                                            type="text"
                                            v-model="student_name"
                                            class="form-control"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >CNE</label
                                        >
                                        <input
                                            type="text"
                                            v-model="student_cne"
                                            class="form-control"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Email</label
                                        >
                                        <input
                                            type="email"
                                            v-model="student_email"
                                            class="form-control"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Address</label
                                        >
                                        <input
                                            type="text"
                                            v-model="student_address"
                                            class="form-control"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Phone number</label
                                        >
                                        <input
                                            type="tel"
                                            v-model="student_phone"
                                            class="form-control"
                                            autocomplete="off"
                                        />
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-md-6 col-xl-12">
                                <label class="form-label"
                                    >Address Position</label
                                >
                                <div
                                    class="form-fieldset"
                                    id="map-address-position"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <router-link to="/admin/students" class="btn btn-link">
                        Cancel
                    </router-link>
                    <router-link
                        to="/admin/students"
                        @click="addStudent"
                        type="submit"
                        :class="
                            studentsStore.loading
                                ? 'btn btn-primary ms-auto btn-loading'
                                : 'btn btn-primary ms-auto'
                        "
                    >
                        Submit
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
#map-address-position {
    height: 435px;
}
</style>
