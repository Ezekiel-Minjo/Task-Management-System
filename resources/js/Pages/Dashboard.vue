<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

const notifications = ref([]);

const page = usePage();
const userId = page.props.auth.user.id;

const fetchNotifications = async () => {
    try {
        const response = await axios.get(`/api/notifications/${userId}`);
        notifications.value = response.data.filter((n) => !n.read);
    } catch (error) {
        console.error("Error fetching notifications:", error);
    }
};

const markAsRead = async (id) => {
    try {
        await axios.put(`/api/notifications/${id}/mark-as-read`);
        fetchNotifications();
    } catch (error) {
        console.error("Error marking as read:", error);
    }
};

onMounted(() => {
    fetchNotifications();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div
                class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-6 shadow-lg"
            >
                <h2 class="text-3xl font-bold text-white tracking-wide">
                    Dashboard
                </h2>
                <p class="text-blue-100 mt-2 text-sm">
                    Welcome back! Here's what's happening today.
                </p>
            </div>
        </template>

        <div class="py-8 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Notifications -->
                <div v-if="notifications.length" class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        Notifications
                    </h2>
                    <ul class="space-y-2">
                        <li
                            v-for="notification in notifications"
                            :key="notification.id"
                            class="bg-white rounded-lg shadow p-4 flex justify-between items-center"
                        >
                            <span>{{ notification.message }}</span>
                            <button
                                class="ml-4 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition"
                                @click="markAsRead(notification.id)"
                            >
                                Mark as Read
                            </button>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    <p class="text-gray-600">No new notifications.</p>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100"
                >
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Quick Actions
                    </h3>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <button
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200 group"
                        >
                            <div
                                class="bg-blue-500 rounded-lg p-2 mr-3 group-hover:bg-blue-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                    ></path>
                                </svg>
                            </div>
                            <span class="text-blue-700 font-medium"
                                >Create New Project</span
                            >
                        </button>

                        <button
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200 group"
                        >
                            <div
                                class="bg-green-500 rounded-lg p-2 mr-3 group-hover:bg-green-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    ></path>
                                </svg>
                            </div>
                            <span class="text-green-700 font-medium"
                                >View Reports</span
                            >
                        </button>

                        <button
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200 group"
                        >
                            <div
                                class="bg-purple-500 rounded-lg p-2 mr-3 group-hover:bg-purple-600 transition-colors"
                            >
                                <svg
                                    class="w-5 h-5 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    ></path>
                                </svg>
                            </div>
                            <span class="text-purple-700 font-medium"
                                >Settings</span
                            >
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
