<script setup>
import { ref } from "vue";
import { useUserStore } from "../../stores/user";
const auth = useUserStore();
</script>
<template>
    <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar-menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item d-none d-lg-flex me-3">
                    <div class="btn-list">
                        <a
                            href="https://github.com/tabler/tabler"
                            class="btn"
                            target="_blank"
                            rel="noreferrer"
                        >
                            <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
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
                                <desc>
                                    Download more icon variants from
                                    https://tabler-icons.io/i/brand-github
                                </desc>
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"
                                ></path>
                            </svg>
                            Source code
                        </a>
                        <a
                            href="https://github.com/sponsors/codecalm"
                            class="btn"
                            target="_blank"
                            rel="noreferrer"
                        >
                            <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon text-pink"
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
                                    https://tabler-icons.io/i/heart
                                </desc>
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M19.5 12.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"
                                ></path>
                            </svg>
                            Sponsor
                        </a>
                    </div>
                </div>
                <div class="d-none d-lg-flex">
                    <a
                        href="?theme=dark"
                        class="nav-link px-0 hide-theme-dark"
                        title=""
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="Enable dark mode"
                    >
                        <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
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
                            <desc>
                                Download more icon variants from
                                https://tabler-icons.io/i/moon
                            </desc>
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <path
                                d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"
                            ></path>
                        </svg>
                    </a>
                    <a
                        href="?theme=light"
                        class="nav-link px-0 hide-theme-light"
                        title=""
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-original-title="Enable light mode"
                    >
                        <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
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
                            <desc>
                                Download more icon variants from
                                https://tabler-icons.io/i/sun
                            </desc>
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <circle cx="12" cy="12" r="4"></circle>
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"
                            ></path>
                        </svg>
                    </a>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a
                            href="#"
                            class="nav-link px-0"
                            data-bs-toggle="dropdown"
                            tabindex="-1"
                            aria-label="Show notifications"
                        >
                            <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
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
                                <desc>
                                    Download more icon variants from
                                    https://tabler-icons.io/i/bell
                                </desc>
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"
                                ></path>
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                            </svg>
                            <span class="badge bg-red"></span>
                        </a>
                        <div
                            class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card"
                        >
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Last updates</h3>
                                </div>
                                <div
                                    class="list-group list-group-flush list-group-hoverable"
                                >
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="status-dot status-dot-animated bg-red d-block"
                                                ></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a
                                                    href="#"
                                                    class="text-body d-block"
                                                    >Example 1</a
                                                >
                                                <div
                                                    class="d-block text-muted text-truncate mt-n1"
                                                >
                                                    Change deprecated html tags
                                                    to text decoration classes
                                                    (#29604)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a
                                                    href="#"
                                                    class="list-group-item-actions"
                                                >
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="icon text-muted"
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
                                                            Download more icon
                                                            variants from
                                                            https://tabler-icons.io/i/star
                                                        </desc>
                                                        <path
                                                            stroke="none"
                                                            d="M0 0h24v24H0z"
                                                            fill="none"
                                                        ></path>
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                        ></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="status-dot d-block"
                                                ></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a
                                                    href="#"
                                                    class="text-body d-block"
                                                    >Example 2</a
                                                >
                                                <div
                                                    class="d-block text-muted text-truncate mt-n1"
                                                >
                                                    justify-content:between ⇒
                                                    justify-content:space-between
                                                    (#29734)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a
                                                    href="#"
                                                    class="list-group-item-actions show"
                                                >
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="icon text-yellow"
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
                                                            Download more icon
                                                            variants from
                                                            https://tabler-icons.io/i/star
                                                        </desc>
                                                        <path
                                                            stroke="none"
                                                            d="M0 0h24v24H0z"
                                                            fill="none"
                                                        ></path>
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                        ></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="status-dot d-block"
                                                ></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a
                                                    href="#"
                                                    class="text-body d-block"
                                                    >Example 3</a
                                                >
                                                <div
                                                    class="d-block text-muted text-truncate mt-n1"
                                                >
                                                    Update change-version.js
                                                    (#29736)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a
                                                    href="#"
                                                    class="list-group-item-actions"
                                                >
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="icon text-muted"
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
                                                            Download more icon
                                                            variants from
                                                            https://tabler-icons.io/i/star
                                                        </desc>
                                                        <path
                                                            stroke="none"
                                                            d="M0 0h24v24H0z"
                                                            fill="none"
                                                        ></path>
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                        ></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span
                                                    class="status-dot status-dot-animated bg-green d-block"
                                                ></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a
                                                    href="#"
                                                    class="text-body d-block"
                                                    >Example 4</a
                                                >
                                                <div
                                                    class="d-block text-muted text-truncate mt-n1"
                                                >
                                                    Regenerate package-lock.json
                                                    (#29730)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a
                                                    href="#"
                                                    class="list-group-item-actions"
                                                >
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="icon text-muted"
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
                                                            Download more icon
                                                            variants from
                                                            https://tabler-icons.io/i/star
                                                        </desc>
                                                        <path
                                                            stroke="none"
                                                            d="M0 0h24v24H0z"
                                                            fill="none"
                                                        ></path>
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                        ></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a
                        href="#"
                        class="nav-link d-flex lh-1 text-reset p-0"
                        data-bs-toggle="dropdown"
                        aria-label="Open user menu"
                    >
                        <span
                            class="avatar avatar-sm"
                            style="
                                background-image: url(./static/avatars/000m.jpg);
                            "
                        ></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>Paweł Kuna</div>
                            <div class="mt-1 small text-muted">UI Designer</div>
                        </div>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                    >
                        <a href="#" class="dropdown-item">Set status</a>
                        <a href="#" class="dropdown-item"
                            >Profile &amp; account</a
                        >
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="text-center mt-3">
                    <span class="avatar avatar-xl mb-3 avatar-rounded">{{
                        auth.user.user_type === "admin"
                            ? "AD"
                            : auth.user.user_type === "student"
                            ? "SDT"
                            : "DR"
                    }}</span>
                    <h3 class="m-0 mb-1">
                        <a href="#">{{ auth.user.name }}</a>
                    </h3>
                    <div class="text-muted">{{ auth.user.email }}</div>
                    <div class="mt-3">
                        <span class="badge badge-outline text-cyan">{{
                            auth.user.user_type
                        }}</span>
                    </div>
                </div>
                <ul
                    v-if="auth.user.user_type === 'admin'"
                    class="navbar-nav pt-lg-3"
                >
                    <li class="nav-item">
                        <router-link class="nav-link" to="/admin/school">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"
                                ><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-school"
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
                                        https://tabler-icons.io/i/school
                                    </desc>
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    ></path>
                                    <path
                                        d="M22 9l-10 -4l-10 4l10 4l10 -4v6"
                                    ></path>
                                    <path
                                        d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"
                                    ></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> School </span>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" to="/admin/busschools">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"
                                ><!-- Download SVG icon from http://tabler-icons.io/i/home -->
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
                                    <desc>
                                        Download more icon variants from
                                        https://tabler-icons.io/i/bus
                                    </desc>
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    ></path>
                                    <circle cx="6" cy="17" r="2"></circle>
                                    <circle cx="18" cy="17" r="2"></circle>
                                    <path
                                        d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"
                                    ></path>
                                    <polyline
                                        points="16 5 17.5 12 22 12"
                                    ></polyline>
                                    <line x1="2" y1="10" x2="17" y2="10"></line>
                                    <line x1="7" y1="5" x2="7" y2="10"></line>
                                    <line x1="12" y1="5" x2="12" y2="10"></line>
                                </svg>
                            </span>
                            <span class="nav-link-title"> Bus Schools </span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/admin/students">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"
                                ><!-- Download SVG icon from http://tabler-icons.io/i/home -->
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
                                    />
                                    <circle cx="12" cy="4" r="1" />
                                    <path d="M4 20h4l1.5 -3" />
                                    <path d="M17 20l-1 -5h-5l1 -7" />
                                    <path d="M4 10l4 -1l4 -1l4 1.5l4 1.5" />
                                </svg>
                            </span>
                            <span class="nav-link-title"> Students </span>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>
<style scoped></style>
