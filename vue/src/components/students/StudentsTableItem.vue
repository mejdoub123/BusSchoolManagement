<script setup>
import { toRefs } from "@vue/reactivity";

const props = defineProps({
    student: Object,
});
const { student } = toRefs(props);
</script>
<template>
    <tr>
        <td>
            <div class="d-flex py-1 align-items-center">
                <span class="avatar me-2"
                    ><svg
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
                        <path d="M4 10l4 -1l4 -1l4 1.5l4 1.5"></path></svg
                ></span>
                <div class="flex-fill">
                    <div class="font-weight-medium">
                        {{ student.name }}
                    </div>
                    <div class="text-muted">
                        <a href="#" class="text-reset">{{ student.email }}</a>
                    </div>
                </div>
            </div>
        </td>
        <td>
            <div>{{ student.address }}</div>
            <div class="text-muted">Tetouan</div>
        </td>
        <td class="text-muted">Student</td>
        <td>
            <a href="#">Edit</a>
        </td>
    </tr>
</template>
