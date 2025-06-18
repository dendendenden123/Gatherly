@extends('layouts.member')
@section('content')

    <body class="bg-gray-50 font-sans antialiased">
        <div class="min-h-screen">
            @section('header')
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">Family Attendance</h1>
                            <p class="text-sm text-gray-500">Track your family's participation</p>
                        </div>
                        <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm">
                            <i class="bi bi-plus mr-1"></i> Add Family Member
                        </button>
                    </div>
                </header>
            @endsection

            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <!-- Family Member Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Family Member 1 -->
                    <div class="bg-white rounded-lg shadow-md p-6 text-center family-member-card">
                        <div class="relative mx-auto w-20 h-20 mb-4">
                            <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80"
                                alt="John Smith" class="w-full h-full rounded-full object-cover">
                            <span
                                class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <h3 class="text-lg font-medium">John Smith</h3>
                        <p class="text-sm text-gray-500 mb-3">Head of Household</p>
                        <div class="flex justify-center mb-3">
                            <div class="relative w-16 h-16">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3"
                                        stroke-dasharray="100" stroke-dashoffset="15" class="progress-ring__circle">
                                    </circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-sm font-bold">85%</div>
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:text-secondary text-sm font-medium">
                            View Attendance <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Family Member 2 -->
                    <div class="bg-white rounded-lg shadow-md p-6 text-center family-member-card">
                        <div class="relative mx-auto w-20 h-20 mb-4">
                            <img src="https://images.unsplash.com/photo-1554151228-14d9def656e4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80"
                                alt="Sarah Smith" class="w-full h-full rounded-full object-cover">
                            <span
                                class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <h3 class="text-lg font-medium">Sarah Smith</h3>
                        <p class="text-sm text-gray-500 mb-3">Spouse</p>
                        <div class="flex justify-center mb-3">
                            <div class="relative w-16 h-16">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3"
                                        stroke-dasharray="100" stroke-dashoffset="25" class="progress-ring__circle">
                                    </circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-sm font-bold">75%</div>
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:text-secondary text-sm font-medium">
                            View Attendance <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Family Member 3 -->
                    <div class="bg-white rounded-lg shadow-md p-6 text-center family-member-card">
                        <div class="relative mx-auto w-20 h-20 mb-4">
                            <img src="https://images.unsplash.com/photo-1549060279-7e168fcee0c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80"
                                alt="Emily Smith" class="w-full h-full rounded-full object-cover">
                            <span
                                class="absolute bottom-0 right-0 w-4 h-4 bg-yellow-500 rounded-full border-2 border-white"></span>
                        </div>
                        <h3 class="text-lg font-medium">Emily Smith</h3>
                        <p class="text-sm text-gray-500 mb-3">Daughter (Age 12)</p>
                        <div class="flex justify-center mb-3">
                            <div class="relative w-16 h-16">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3"
                                        stroke-dasharray="100" stroke-dashoffset="40" class="progress-ring__circle">
                                    </circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-sm font-bold">60%</div>
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:text-secondary text-sm font-medium">
                            View Attendance <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <!-- Family Member 4 -->
                    <div class="bg-white rounded-lg shadow-md p-6 text-center family-member-card">
                        <div class="relative mx-auto w-20 h-20 mb-4">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80"
                                alt="Michael Smith" class="w-full h-full rounded-full object-cover">
                            <span
                                class="absolute bottom-0 right-0 w-4 h-4 bg-red-500 rounded-full border-2 border-white"></span>
                        </div>
                        <h3 class="text-lg font-medium">Michael Smith</h3>
                        <p class="text-sm text-gray-500 mb-3">Son (Age 15)</p>
                        <div class="flex justify-center mb-3">
                            <div class="relative w-16 h-16">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3"
                                        stroke-dasharray="100" stroke-dashoffset="55" class="progress-ring__circle">
                                    </circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-sm font-bold">45%</div>
                            </div>
                        </div>
                        <a href="#" class="text-primary hover:text-secondary text-sm font-medium">
                            View Attendance <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Family Attendance Summary -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Family Attendance Summary</h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Monthly Comparison -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-md font-medium mb-3">Monthly Comparison</h3>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>June 2023</span>
                                            <span class="font-medium">72%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary h-2 rounded-full" style="width: 72%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>May 2023</span>
                                            <span class="font-medium">65%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>April 2023</span>
                                            <span class="font-medium">58%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary h-2 rounded-full" style="width: 58%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Type Breakdown -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-md font-medium mb-3">Service Type Attendance</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                            <span class="text-sm">Sunday AM</span>
                                        </div>
                                        <span class="text-sm font-medium">85%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                            <span class="text-sm">Wednesday PM</span>
                                        </div>
                                        <span class="text-sm font-medium">62%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm">Special Events</span>
                                        </div>
                                        <span class="text-sm font-medium">45%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Family Member Comparison -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-md font-medium mb-3">Family Member Comparison</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 text-sm">John</div>
                                            <div class="w-full mx-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-primary h-2 rounded-full" style="width: 85%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium">85%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 text-sm">Sarah</div>
                                            <div class="w-full mx-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-primary h-2 rounded-full" style="width: 75%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium">75%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 text-sm">Emily</div>
                                            <div class="w-full mx-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-primary h-2 rounded-full" style="width: 60%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium">60%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 text-sm">Michael</div>
                                            <div class="w-full mx-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-primary h-2 rounded-full" style="width: 45%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium">45%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Family Attendance -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold">Recent Family Attendance</h2>
                        <div class="flex items-center space-x-2">
                            <select
                                class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring-primary focus:border-primary">
                                <option>Last 30 Days</option>
                                <option>Last 3 Months</option>
                                <option>Last 6 Months</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        John</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sarah</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Emily</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Michael</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Sun, Jun 11</div>
                                        <div class="text-sm text-gray-500">10:30 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Sunday Service</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Wed, Jun 7</div>
                                        <div class="text-sm text-gray-500">7:00 PM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Bible Study</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Sun, Jun 4</div>
                                        <div class="text-sm text-gray-500">10:30 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Sunday Service</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Fri, Jun 2</div>
                                        <div class="text-sm text-gray-500">6:00 PM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Youth Night</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">N/A</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">N/A</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Sun, May 28</div>
                                        <div class="text-sm text-gray-500">10:30 AM</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Sunday Service</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span
                                class="font-medium">12</span> records
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <script>
            // Simulate loading progress
            setTimeout(() => {
                const progressCircles = document.querySelectorAll('.progress-ring__circle');
                progressCircles.forEach((circle, index) => {
                    if (index === 0) circle.style.strokeDashoffset = '15';
                    if (index === 1) circle.style.strokeDashoffset = '25';
                    if (index === 2) circle.style.strokeDashoffset = '40';
                    if (index === 3) circle.style.strokeDashoffset = '55';
                });
            }, 500);
        </script>
    </body>

    </html>
@endsection