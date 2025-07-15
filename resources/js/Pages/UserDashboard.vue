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
                        class="bg-white rounded-lg shadow p-4"
                    >
                        {{ notification.message }}
                    </li>
                </ul>
            </div>

            <!-- Task Summary Cards -->
            <!-- (Your cards section here — no changes) -->

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
                <!-- (Your task cards — no changes) -->
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
    computed: {
        pendingCount() {
            return this.tasks.filter((task) => task.status === "Pending")
                .length;
        },
        inProgressCount() {
            return this.tasks.filter((task) => task.status === "In Progress")
                .length;
        },
        completedCount() {
            return this.tasks.filter((task) => task.status === "Completed")
                .length;
        },
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
                this.notifications = response.data;
            } catch (error) {
                console.error("Error fetching notifications:", error);
            }
        },
        async updateStatus(task) {
            try {
                await axios.put(`/api/tasks/${task.id}/status`, {
                    status: task.status,
                });
            } catch (error) {
                console.error("Error updating task status:", error);
                this.fetchTasks();
            }
        },
        getStatusBadgeClass(status) {
            const classes = {
                Pending: "bg-orange-100 text-orange-800",
                "In Progress": "bg-blue-100 text-blue-800",
                Completed: "bg-green-100 text-green-800",
            };
            return classes[status] || "bg-gray-100 text-gray-800";
        },
        getStatusSelectClass(status) {
            const classes = {
                Pending:
                    "border-orange-300 focus:ring-orange-500 focus:border-orange-500",
                "In Progress":
                    "border-blue-300 focus:ring-blue-500 focus:border-blue-500",
                Completed:
                    "border-green-300 focus:ring-green-500 focus:border-green-500",
            };
            return classes[status] || "border-gray-300";
        },
        getTaskBorderClass(status) {
            const classes = {
                Pending: "border-l-4 border-l-orange-500",
                "In Progress": "border-l-4 border-l-blue-500",
                Completed: "border-l-4 border-l-green-500",
            };
            return classes[status] || "border-l-4 border-l-gray-300";
        },
        getProgressBarClass(status) {
            const classes = {
                Pending: "bg-orange-500",
                "In Progress": "bg-blue-500",
                Completed: "bg-green-500",
            };
            return classes[status] || "bg-gray-300";
        },
        getProgressWidth(status) {
            const widths = {
                Pending: "25%",
                "In Progress": "60%",
                Completed: "100%",
            };
            return widths[status] || "0%";
        },
        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                month: "short",
                day: "numeric",
                year: "numeric",
            });
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
