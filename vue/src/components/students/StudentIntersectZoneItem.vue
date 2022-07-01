<script setup>
import { toRefs } from "@vue/reactivity";

const props = defineProps({
    student: Object,
});
const { student } = toRefs(props);
</script>
<template>
    <div class="m-1">
        <label class="form-selectgroup-item flex-fill">
            <input
                type="checkbox"
                name="form-project-manager[]"
                value="2"
                class="form-selectgroup-input"
                checked=""
            />
            <div class="form-selectgroup-label d-flex align-items-center p-3">
                <div class="me-3">
                    <span class="form-selectgroup-check"></span>
                </div>
                <div
                    class="form-selectgroup-label-content d-flex align-items-center"
                >
                    <span class="avatar me-3">JL</span>
                    <div>
                        <div class="font-weight-medium">{{student.name}}</div>
                        <div class="text-muted">{{student.email}} || {{student.cne}}</div>
                    </div>
                </div>
            </div>
        </label>
    </div>
</template>
