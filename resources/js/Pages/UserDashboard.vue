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

            <!-- Task Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                >
                    <div class="flex items-center">
                        <div class="bg-orange-100 p-3 rounded-lg mr-4">
                            <svg
                                class="w-6 h-6 text-orange-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ pendingCount }}
                            </p>
                            <p class="text-sm text-gray-600">Pending</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                >
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ inProgressCount }}
                            </p>
                            <p class="text-sm text-gray-600">In Progress</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                >
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ completedCount }}
                            </p>
                            <p class="text-sm text-gray-600">Completed</p>
                        </div>
                    </div>
                </div>
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
                <div
                    v-for="task in tasks"
                    :key="task.id"
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    :class="getTaskBorderClass(task.status)"
                >
                    <!-- Task Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start justify-between mb-4">
                            <h3
                                class="text-lg font-semibold text-gray-900 flex-1 mr-3"
                            >
                                {{ task.title }}
                            </h3>
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full"
                                :class="getStatusBadgeClass(task.status)"
                            >
                                {{ task.status }}
                            </span>
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ task.description }}
                        </p>

                        <div
                            class="flex items-center text-sm text-gray-500 mb-4"
                        >
                            <svg
                                class="w-4 h-4 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            <span>{{ formatDate(task.deadline) }}</span>
                        </div>
                    </div>

                    <!-- Task Actions -->
                    <div class="px-6 pb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700"
                                >Status:</span
                            >
                            <select
                                v-model="task.status"
                                @change="updateStatus(task)"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                :class="getStatusSelectClass(task.status)"
                            >
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="px-6 pb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div
                                class="h-2 rounded-full transition-all duration-300"
                                :class="getProgressBarClass(task.status)"
                                :style="{
                                    width: getProgressWidth(task.status),
                                }"
                            ></div>
                        </div>
                    </div>
                </div>
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

        async updateStatus(task) {
            try {
                await axios.put(`/api/tasks/${task.id}/status`, {
                    status: task.status,
                });
                // Optionally show success message
            } catch (error) {
                console.error("Error updating task status:", error);
                // Revert the status change on error
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
