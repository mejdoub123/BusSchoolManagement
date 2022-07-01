<script setup>
import { ref } from "vue";
import { useUserStore } from "../../stores/user";
const auth = useUserStore();
const name = ref("MEJDOUB Abdelkader");
const email = ref("abdelkader12334@gmail.com");
const cin = ref("L608187");
const role = ref("admin");
const password = ref("abde1998");
const password_confirmation = ref("abde1998");
const registerUser = async () => {
    const user = {
        name: name.value,
        email: email.value,
        cin: cin.value,
        role: role.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
    };
    await auth.register(user);
};
</script>
<template>
    <div class="border-top-wide border-primary d-flex flex-column theme-light">
        <div class="page page-center">
            <div class="container-tight py-4">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark"
                        ><img
                            src="../../assets/school_pic_1.svg"
                            height="36"
                            alt=""
                    /></a>
                </div>
                <form class="card card-md" action="." method="get">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">
                            Create new account
                        </h2>
                        <div class="mb-3">
                            <label class="form-label required">Name</label>
                            <input
                                type="text"
                                v-model="name"
                                class="form-control"
                                placeholder="Enter name"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Email address</label
                            >
                            <input
                                type="email"
                                v-model="email"
                                class="form-control"
                                placeholder="Enter email"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">CIN</label>
                            <input
                                type="text"
                                v-model="cin"
                                class="form-control"
                                placeholder="Enter CIN"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Password</label>
                            <div class="input-group input-group-flat">
                                <input
                                    type="password"
                                    v-model="password"
                                    class="form-control"
                                    placeholder="Password"
                                    autocomplete="off"
                                />
                                <span class="input-group-text">
                                    <a
                                        href="#"
                                        class="link-secondary"
                                        title=""
                                        data-bs-toggle="tooltip"
                                        data-bs-original-title="Show password"
                                        ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon"
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
                                                r="2"
                                            ></circle>
                                            <path
                                                d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"
                                            ></path>
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Confirm password</label
                            >
                            <div class="input-group input-group-flat">
                                <input
                                    type="password"
                                    v-model="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm Passowrd"
                                    autocomplete="off"
                                />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                />
                                <span class="form-check-label"
                                    >Agree the
                                    <a
                                        href="./terms-of-service.html"
                                        tabindex="-1"
                                        >terms and policy</a
                                    >.</span
                                >
                            </label>
                        </div>
                        <div class="form-footer">
                            <a
                                href="#"
                                @click="registerUser"
                                :class="
                                    auth.loadingStatus
                                        ? 'btn btn-primary w-100 btn-loading'
                                        : 'btn btn-primary w-100'
                                "
                            >
                                Create new account
                            </a>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted mt-3">
                    Already have account?
                    <router-link to="/signin">Sign in</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped></style>
