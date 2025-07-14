<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">
                        Admin Dashboard
                    </h1>
                    <p class="text-gray-600">
                        Manage users and assign tasks efficiently
                    </p>
                </div>

                <!-- Success/Error Messages -->
                <div v-if="message" class="mb-6">
                    <div
                        :class="
                            messageType === 'success'
                                ? 'bg-green-100 border-green-400 text-green-700'
                                : 'bg-red-100 border-red-400 text-red-700'
                        "
                        class="border px-4 py-3 rounded-lg shadow-sm"
                    >
                        {{ message }}
                    </div>
                </div>

                <!-- Dashboard Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Add New User Card -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                    >
                        <div class="flex items-center mb-6">
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
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                    />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-900">
                                Add New User
                            </h2>
                        </div>

                        <form @submit.prevent="addUser" class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Name</label
                                >
                                <input
                                    v-model="newUser.name"
                                    type="text"
                                    placeholder="Enter full name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Email</label
                                >
                                <input
                                    v-model="newUser.email"
                                    type="email"
                                    placeholder="Enter email address"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Password</label
                                >
                                <input
                                    v-model="newUser.password"
                                    type="password"
                                    placeholder="Enter password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    required
                                />
                            </div>

                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="newUser.is_admin"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label class="ml-2 block text-sm text-gray-700"
                                    >Admin privileges</label
                                >
                            </div>

                            <button
                                type="submit"
                                :disabled="loading"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                            >
                                <svg
                                    v-if="loading"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                {{ loading ? "Adding..." : "Add User" }}
                            </button>
                        </form>
                    </div>

                    <!-- Assign Task Card -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300"
                    >
                        <div class="flex items-center mb-6">
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
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                    />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-900">
                                Assign Task
                            </h2>
                        </div>

                        <form @submit.prevent="assignTask" class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Task Title</label
                                >
                                <input
                                    v-model="newTask.title"
                                    type="text"
                                    placeholder="Enter task title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Description</label
                                >
                                <textarea
                                    v-model="newTask.description"
                                    placeholder="Enter task description"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none"
                                    required
                                ></textarea>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Deadline</label
                                >
                                <input
                                    v-model="newTask.deadline"
                                    type="date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Assign to User</label
                                >
                                <select
                                    v-model="newTask.user_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                    required
                                >
                                    <option disabled value="">
                                        Select User
                                    </option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }} ({{ user.email }})
                                    </option>
                                </select>
                            </div>

                            <button
                                type="submit"
                                :disabled="loading"
                                class="w-full bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                            >
                                <svg
                                    v-if="loading"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                {{ loading ? "Assigning..." : "Assign Task" }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Users List -->
                <div class="mt-8">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="bg-purple-100 p-3 rounded-lg mr-4"
                                    >
                                        <svg
                                            class="w-6 h-6 text-purple-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2
                                            class="text-2xl font-semibold text-gray-900"
                                        >
                                            Users
                                        </h2>
                                        <p class="text-sm text-gray-600">
                                            {{ users.length }} total users
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search users..."
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            User
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Email
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Role
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="user in filteredUsers"
                                        :key="user.id"
                                        class="hover:bg-gray-50 transition-colors"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-10 w-10 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center"
                                                >
                                                    <span
                                                        class="text-white font-medium"
                                                        >{{
                                                            user.name
                                                                .charAt(0)
                                                                .toUpperCase()
                                                        }}</span
                                                    >
                                                </div>
                                                <div class="ml-4">
                                                    <div
                                                        class="text-sm font-medium text-gray-900"
                                                    >
                                                        {{ user.name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                        >
                                            {{ user.email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                :class="
                                                    user.is_admin
                                                        ? 'bg-red-100 text-red-800'
                                                        : 'bg-green-100 text-green-800'
                                                "
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                            >
                                                {{
                                                    user.is_admin
                                                        ? "Admin"
                                                        : "User"
                                                }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2"
                                        >
                                            <button
                                                @click="editUser(user)"
                                                class="text-blue-600 hover:text-blue-900 transition-colors"
                                            >
                                                <svg
                                                    class="w-4 h-4 inline mr-1"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                    />
                                                </svg>
                                                Edit
                                            </button>
                                            <button
                                                @click="deleteUser(user.id)"
                                                class="text-red-600 hover:text-red-900 transition-colors"
                                            >
                                                <svg
                                                    class="w-4 h-4 inline mr-1"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    />
                                                </svg>
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div
                                v-if="filteredUsers.length === 0"
                                class="text-center py-8"
                            >
                                <svg
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                    />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">
                                    No users found
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import axios from "axios";
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";

export default {
    components: { AuthenticatedLayout },
    data() {
        return {
            users: [],
            searchQuery: "",
            loading: false,
            message: "",
            messageType: "success",
            newUser: { name: "", email: "", password: "", is_admin: false },
            newTask: { title: "", description: "", deadline: "", user_id: "" },
        };
    },
    computed: {
        filteredUsers() {
            if (!this.searchQuery) return this.users;
            return this.users.filter(
                (user) =>
                    user.name
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase()) ||
                    user.email
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase())
            );
        },
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        showMessage(text, type = "success") {
            this.message = text;
            this.messageType = type;
            setTimeout(() => {
                this.message = "";
            }, 5000);
        },

        async fetchUsers() {
            try {
                const response = await axios.get("/api/users");
                this.users = response.data;
            } catch (error) {
                console.error("Error fetching users:", error);
                this.showMessage("Failed to load users", "error");
            }
        },

        async addUser() {
            this.loading = true;
            try {
                await axios.post("/api/users", this.newUser);
                this.newUser = {
                    name: "",
                    email: "",
                    password: "",
                    is_admin: false,
                };
                await this.fetchUsers();
                this.showMessage("User added successfully!", "success");
            } catch (error) {
                console.error("Error adding user:", error);
                this.showMessage("Failed to add user", "error");
            } finally {
                this.loading = false;
            }
        },

        async editUser(user) {
            const updatedName = prompt("Enter new name", user.name);
            if (updatedName && updatedName !== user.name) {
                this.loading = true;
                try {
                    await axios.put(`/api/users/${user.id}`, {
                        name: updatedName,
                    });
                    await this.fetchUsers();
                    this.showMessage("User updated successfully!", "success");
                } catch (error) {
                    console.error("Error editing user:", error);
                    this.showMessage("Failed to update user", "error");
                } finally {
                    this.loading = false;
                }
            }
        },

        async deleteUser(id) {
            if (
                confirm(
                    "Are you sure you want to delete this user? This action cannot be undone."
                )
            ) {
                this.loading = true;
                try {
                    await axios.delete(`/api/users/${id}`);
                    await this.fetchUsers();
                    this.showMessage("User deleted successfully!", "success");
                } catch (error) {
                    console.error("Error deleting user:", error);
                    this.showMessage("Failed to delete user", "error");
                } finally {
                    this.loading = false;
                }
            }
        },

        async assignTask() {
            this.loading = true;
            try {
                await axios.post("/api/tasks/assign", this.newTask);
                this.newTask = {
                    title: "",
                    description: "",
                    deadline: "",
                    user_id: "",
                };
                this.showMessage("Task assigned successfully!", "success");
            } catch (error) {
                console.error("Error assigning task:", error);
                this.showMessage("Failed to assign task", "error");
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
