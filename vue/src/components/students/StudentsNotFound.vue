<script setup></script>
<template>
    <div class="col-6" style="margin-top: 20%; margin-left: 20%">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <h3 class="mb-1" style="margin-top: 1%">
                This School doesn't have any student yet !
            </h3>
            <p style="margin-bottom: 10%">
                Do you have some students not added yet ?
            </p>
            <div class="btn-list">
                <router-link to="create" class="btn btn btn-success">
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
                            Download more icon variants from
                            https://tabler-icons.io/i/yoga
                        </desc>
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <circle cx="12" cy="4" r="1"></circle>
                        <path d="M4 20h4l1.5 -3"></path>
                        <path d="M17 20l-1 -5h-5l1 -7"></path>
                        <path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path>
                    </svg>
                    Add Student</router-link
                >

                <router-link to="/admin/school" class="btn">Cancel</router-link>
            </div>
        </div>
    </div>
</template>
