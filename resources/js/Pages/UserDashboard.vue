<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">My Tasks</h1>
                <p class="text-gray-600">
                    Manage your tasks and track progress efficiently
                </p>
            </div>

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
                <p>No new notifications.</p>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="text-center py-12">
                <div
                    class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"
                ></div>
                <p class="text-gray-600">Loading your tasks...</p>
            </div>

            <!-- Empty State -->
            <div v-else-if="tasks.length === 0" class="text-center py-12">
                <div class="bg-white rounded-xl shadow-lg p-8 max-w-md mx-auto">
                    <svg
                        class="mx-auto h-16 w-16 text-gray-400 mb-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        No tasks yet
                    </h3>
                    <p class="text-gray-500">
                        Your tasks will appear here once they're assigned to
                        you.
                    </p>
                </div>
            </div>

            <!-- Tasks Grid -->
            <div
                v-else
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            >
                <!-- Your task cards — no changes -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tasks: [],
            notifications: [],
            isLoading: true,
        };
    },
    mounted() {
        this.fetchTasks();
        this.fetchNotifications();
    },
    methods: {
        async fetchTasks() {
            try {
                this.isLoading = true;
                const response = await axios.get("/api/tasks/my-tasks");
                this.tasks = response.data;
            } catch (error) {
                console.error("Error fetching tasks:", error);
            } finally {
                this.isLoading = false;
            }
        },
        async fetchNotifications() {
            try {
                // Replace with actual authenticated user ID
                const userId = 1;
                const response = await axios.get(
                    `/api/notifications/${userId}`
                );
                this.notifications = response.data.filter((n) => !n.read);
            } catch (error) {
                console.error("Error fetching notifications:", error);
            }
        },
        async markAsRead(id) {
            try {
                await axios.put(`/api/notifications/${id}/mark-as-read`);
                this.fetchNotifications();
            } catch (error) {
                console.error("Error marking as read:", error);
            }
        },
    },
};
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
