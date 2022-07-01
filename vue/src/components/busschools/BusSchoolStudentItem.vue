<script setup>
import { toRefs } from "@vue/reactivity";
const props = defineProps({
    student: Object,
    del: Boolean,
    add: Boolean,
});
const emit = defineEmits(["delete-student", "add-student"]);
const { student, del, add } = toRefs(props);
const onAddStudent = () => {
    emit("add-student", student.value);
};
const onDeleteStudent = () => {
    emit("delete-student", student.value);
};
</script>
<template>
    <div class="col-6">
        <div class="row g-3 align-items-center">
            <a href="#" class="col-auto">
                <span class="avatar">STD</span>
            </a>
            <div class="col text-truncate">
                <a href="#" class="text-reset d-block text-truncate">{{
                    student.name
                }}</a>
                <div class="text-muted text-truncate mt-1">
                    {{ student.email }}
                </div>
            </div>
            <div v-if="del" class="col-auto align-self-center">
                <button
                    @click="onDeleteStudent"
                    class="btn btn-outline-danger btn-icon btn-sm"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-x"
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
                            https://tabler-icons.io/i/x
                        </desc>
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div v-if="add" class="col-auto align-self-center">
                <button
                    @click="onAddStudent"
                    class="btn btn-outline-primary btn-icon btn-sm"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-plus"
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
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
