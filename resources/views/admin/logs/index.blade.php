<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs & Activity Tracker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#0ea5e9',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                        dark: '#1e293b',
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .slide-down {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        .log-type-login {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .log-type-create {
            background-color: #dcfce7;
            color: #166534;
        }

        .log-type-update {
            background-color: #fef3c7;
            color: #92400e;
        }

        .log-type-delete {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .log-type-system {
            background-color: #f3e8ff;
            color: #7e22ce;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">System Logs & Activity Tracker</h1>
                <p class="text-gray-600 mt-2">Monitor all system activities and user actions</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Last updated</p>
                    <p class="font-medium">Just now</p>
                </div>
                <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Total Logs</p>
                        <p class="text-2xl font-bold text-gray-800">12,458</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">+245 in last 7 days</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Active Users</p>
                        <p class="text-2xl font-bold text-gray-800">342</p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">+12 this week</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">Login Activities</p>
                        <p class="text-2xl font-bold text-gray-800">1,245</p>
                    </div>
                    <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">+89 today</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600">System Errors</p>
                        <p class="text-2xl font-bold text-gray-800">24</p>
                    </div>
                    <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">-5 from last week</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Column - Filters -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 sticky top-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Filters</h2>

                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Logs</label>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search by action, description..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Action Type Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Action Type</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="filter-login"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" checked>
                                <label for="filter-login" class="ml-2 text-sm text-gray-700">Login Activities</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="filter-create"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" checked>
                                <label for="filter-create" class="ml-2 text-sm text-gray-700">Create Actions</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="filter-update"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" checked>
                                <label for="filter-update" class="ml-2 text-sm text-gray-700">Update Actions</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="filter-delete"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" checked>
                                <label for="filter-delete" class="ml-2 text-sm text-gray-700">Delete Actions</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="filter-system"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" checked>
                                <label for="filter-system" class="ml-2 text-sm text-gray-700">System Actions</label>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                        <div class="space-y-3">
                            <div>
                                <label for="startDate" class="block text-xs text-gray-500 mb-1">From</label>
                                <input type="date" id="startDate"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label for="endDate" class="block text-xs text-gray-500 mb-1">To</label>
                                <input type="date" id="endDate"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- User Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                        <select id="userFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">All Users</option>
                            <option value="1">John Doe (Admin)</option>
                            <option value="2">Sarah Johnson</option>
                            <option value="3">Michael Brown</option>
                            <option value="4">Robert Wilson</option>
                            <option value="5">System</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button id="applyFilters"
                            class="flex-1 bg-primary hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Apply
                        </button>
                        <button id="resetFilters"
                            class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition duration-200">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column - Logs Table -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div
                        class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between">
                        <h2 class="text-lg font-bold text-gray-800">Activity Logs</h2>
                        <div class="mt-2 md:mt-0 flex items-center space-x-3">
                            <div class="text-sm text-gray-500">
                                Showing <span class="font-medium">1-10</span> of <span class="font-medium">12,458</span>
                            </div>
                            <div class="flex space-x-1">
                                <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="p-2 text-gray-500 hover:text-gray-700 rounded-lg">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <button
                                class="px-4 py-2 bg-primary hover:bg-blue-700 text-white rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-download mr-2"></i> Export
                            </button>
                        </div>
                    </div>

                    <!-- Logs Table -->
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User Agent</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Timestamp</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Log Entry 1 -->
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-medium text-sm mr-3">
                                                JD</div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">John Doe</div>
                                                <div class="text-xs text-gray-500">Admin</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="log-type-login px-2 py-1 rounded-full text-xs font-medium">User
                                            Login</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Successful login from IP 192.168.1.105</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-500 max-w-xs truncate">Mozilla/5.0 (Windows NT
                                            10.0; Win64; x64) AppleWebKit/537.36</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>Mar 20, 2023</div>
                                        <div class="text-xs">10:24 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary hover:text-blue-700 view-details">View</button>
                                    </td>
                                </tr>

                                <!-- Log Entry 2 -->
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-medium text-sm mr-3">
                                                SJ</div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Sarah Johnson</div>
                                                <div class="text-xs text-gray-500">Member</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="log-type-update px-2 py-1 rounded-full text-xs font-medium">Profile
                                            Update</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Updated personal information</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-500 max-w-xs truncate">Mozilla/5.0 (iPhone; CPU
                                            iPhone OS 15_4 like Mac OS X) AppleWebKit/605.1.15</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>Mar 20, 2023</div>
                                        <div class="text-xs">09:45 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary hover:text-blue-700 view-details">View</button>
                                    </td>
                                </tr>

                                <!-- Log Entry 3 -->
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-medium text-sm mr-3">
                                                MB</div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Michael Brown</div>
                                                <div class="text-xs text-gray-500">Member</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="log-type-create px-2 py-1 rounded-full text-xs font-medium">Create</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Created new share capital deposit request:
                                            ₱5,000.00</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-500 max-w-xs truncate">Mozilla/5.0 (Macintosh;
                                            Intel Mac OS X 10_15_7) AppleWebKit/537.36</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>Mar 19, 2023</div>
                                        <div class="text-xs">04:32 PM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary hover:text-blue-700 view-details">View</button>
                                    </td>
                                </tr>

                                <!-- Log Entry 4 -->
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-medium text-sm mr-3">
                                                SYS</div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">System</div>
                                                <div class="text-xs text-gray-500">Automated</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="logtype-system px-2 py-1 rounded-full text-xs font-medium">System</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Daily backup completed successfully</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-500 max-w-xs truncate">System/1.0</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>Mar 19, 2023</div>
                                        <div class="text-xs">02:15 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary hover:text-blue-700 view-details">View</button>
                                    </td>
                                </tr>

                                <!-- Log Entry 5 -->
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-medium text-sm mr-3">
                                                JD</div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">John Doe</div>
                                                <div class="text-xs text-gray-500">Admin</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="log-type-delete px-2 py-1 rounded-full text-xs font-medium">Delete</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Deleted expired event: Summer Picnic 2022
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-500 max-w-xs truncate">Mozilla/5.0 (Windows NT
                                            10.0; Win64; x64) AppleWebKit/537.36</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>Mar 18, 2023</div>
                                        <div class="text-xs">11:20 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary hover:text-blue-700 view-details">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span
                                class="font-medium">12,458</span> results
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                Previous
                            </button>
                            <button
                                class="px-3 py-1 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                1
                            </button>
                            <button
                                class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                2
                            </button>
                            <button
                                class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                3
                            </button>
                            <button
                                class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Details Modal -->
    <div id="logDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto slide-down">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Log Details</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Log ID</p>
                        <p class="font-medium">#24587</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Timestamp</p>
                        <p class="font-medium">Mar 20, 2023 at 10:24:35 AM</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">User</p>
                        <p class="font-medium">John Doe (Admin)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">User ID</p>
                        <p class="font-medium">#1</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Action</p>
                        <p class="font-medium"><span class="log-type-login px-2 py-1 rounded-full text-xs">User
                                Login</span></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">IP Address</p>
                        <p class="font-medium">192.168.1.105</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-600 mb-2">Description</p>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800">Successful login from IP address 192.168.1.105 using credentials
                            authentication.</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-600 mb-2">User Agent</p>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800 font-mono text-sm">Mozilla/5.0 (Windows NT 10.0; Win64; x64)
                            AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36</p>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button id="closeDetailsModal"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const applyFiltersBtn = document.getElementById('applyFilters');
        const resetFiltersBtn = document.getElementById('resetFilters');
        const viewDetailsButtons = document.querySelectorAll('.view-details');
        const logDetailsModal = document.getElementById('logDetailsModal');
        const closeModalBtn = document.getElementById('closeModal');
        const closeDetailsModalBtn = document.getElementById('closeDetailsModal');

        // Set default dates
        const today = new Date();
        const sevenDaysAgo = new Date();
        sevenDaysAgo.setDate(today.getDate() - 7);

        document.getElementById('startDate').value = sevenDaysAgo.toISOString().split('T')[0];
        document.getElementById('endDate').value = today.toISOString().split('T')[0];

        // Apply filters
        applyFiltersBtn.addEventListener('click', () => {
            // In a real application, this would make an API call with the filter parameters
            alert('Filters applied! In a real app, this would refresh the logs with the selected filters.');
        });

        // Reset filters
        resetFiltersBtn.addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = true;
            });
            document.getElementById('startDate').value = sevenDaysAgo.toISOString().split('T')[0];
            document.getElementById('endDate').value = today.toISOString().split('T')[0];
            document.getElementById('userFilter').value = '';
        });

        // View log details
        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', () => {
                logDetailsModal.classList.remove('hidden');
            });
        });

        // Close modal
        closeModalBtn.addEventListener('click', () => {
            logDetailsModal.classList.add('hidden');
        });

        closeDetailsModalBtn.addEventListener('click', () => {
            logDetailsModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === logDetailsModal) {
                logDetailsModal.classList.add('hidden');
            }
        });
    </script>
</body>

</html>