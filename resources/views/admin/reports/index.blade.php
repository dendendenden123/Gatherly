<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Management System - Report Module</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        .apexcharts-tooltip {
            background: #f8fafc !important;
            color: #1e293b;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-church text-white"></i>
                    </div>
                    <h1 class="ml-3 text-xl font-bold text-gray-900">Grace Community Church</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium">Admin User</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
                        <p class="text-gray-600 mt-1">Generate insights from event attendance and member engagement</p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-print mr-2"></i> Print
                        </button>
                        <button
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                            <i class="fas fa-plus mr-2"></i> New Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Report Tabs -->
            <div class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button id="attendanceTabBtn" data-tab="attendance"
                            class="border-b-2 border-indigo-500 text-indigo-600 py-4 px-1 text-sm font-medium">
                            Attendance Reports
                        </button>
                        <button id="engagementTabBtn" data-tab="engagement"
                            class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            Member Engagement
                        </button>
                        <button id="demographicTabBtn" data-tab="demographics"
                            class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            Demographic Insights
                        </button>
                        <button id="customTabBtn" data-tab="custom"
                            class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            Custom Reports
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <form action="{{ route('admin.reports') }}" method="GET" id="filter-form"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <!-- Date Range -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- From Date -->
                            <div>
                                <!-- <label for="from_date" class="block text-xs text-gray-500 mb-1">From</label> -->
                                <input type="date" id="from_date" name="from_date"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                            </div>

                            <!-- To Date -->
                            <div>
                                <!-- <label for="to_date" class="block text-xs text-gray-500 mb-1">To</label> -->
                                <input type="date" id="to_date" name="to_date"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Event Type -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                        <select id="eventTypeSelect" name="event_type"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Events</option>
                            <option value="Baptism">Baptism</option>
                            <option value="Charity Event">Charity Event</option>
                            <option value="Christian Family Organization (CFO) activity">
                                Christian Family Organization (CFO) activity
                            </option>
                            <option value="Evangelical Mission">Evangelical Mission</option>
                            <option value="Inauguration of New Chapels/ Structure">Inauguration of New Chapels/Structure
                            </option>
                            <option value="Meeting">Meeting</option>
                            <option value="Panata">Panata</option>
                            <option value="Weddings">Weddings</option>
                            <option value="Worship Service">Worship Service</option>
                        </select>
                    </div>

                    <!-- Age Group -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age Group</label>
                        <select id="ministrySelect" name="age_group"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="*">All Members</option>
                            <option value="binhi">Binhi (Below 18)</option>
                            <option value="kadiwa">Kadiwa (18 and above, not married)</option>
                            <option value="buklod">Buklod (18 and above, married)</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-span-1 flex items-end space-x-2">
                        <button id="generateBtn"
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Generate Report
                        </button>
                        <button type="reset" id="resetBtn"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </form>
            </div>


            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Attendance</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">1,247</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 12.5%
                        </span>
                        <span class="text-gray-500 ml-2">vs last period</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Unique Individuals</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">892</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-user-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 8.3%
                        </span>
                        <span class="text-gray-500 ml-2">vs last period</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600">First-Time Visitors</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">42</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-user-plus text-purple-600"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-red-600 flex items-center">
                            <i class="fas fa-arrow-down mr-1"></i> 5.2%
                        </span>
                        <span class="text-gray-500 ml-2">vs last period</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Engagement Rate</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">78%</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <i class="fas fa-chart-line text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 3.7%
                        </span>
                        <span class="text-gray-500 ml-2">vs last period</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Attendance Trends -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Attendance Trends</h2>
                        <div class="flex space-x-2">
                            <button id="weeklyBtn"
                                class="text-sm px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg">Weekly</button>
                            <button id="monthlyBtn"
                                class="text-sm px-3 py-1 bg-gray-100 text-gray-700 rounded-lg">Monthly</button>
                            <button id="yearlyBtn"
                                class="text-sm px-3 py-1 bg-gray-100 text-gray-700 rounded-lg">Yearly</button>
                        </div>
                    </div>
                    <div id="attendanceTrendChart" class="h-80" data-attendance="{{ $month }}"></div>
                </div>

                <!-- Event Type Comparison -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Event Type Comparison</h2>
                        <button id="exportChartBtn" class="text-sm text-indigo-600 font-medium flex items-center">
                            <i class="fas fa-download mr-1"></i> Export
                        </button>
                    </div>
                    <div id="eventComparisonChart" class="h-80"></div>
                </div>
            </div>

            <!-- Detailed Data Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 id="tableTitle" class="text-lg font-semibold text-gray-900">Event Attendance Details</h2>
                    <div class="flex space-x-2">
                        <button id="csvBtn"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-file-csv mr-2"></i> CSV
                        </button>
                        <button id="pdfBtn"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-file-pdf mr-2"></i> PDF
                        </button>
                        <button id="excelBtn"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-file-excel mr-2"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Attendance</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Capacity</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    First-Timers</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Engagement</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a id="mobilePrev" href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous </a>
                        <a id="mobileNext" href="#"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span id="fromCount" class="font-medium">1</span> to <span id="toCount"
                                    class="font-medium">5</span> of
                                <span id="totalCount" class="font-medium">0</span> results
                            </p>
                        </div>
                        <div>
                            <nav id="pagination" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insights Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h2 id="insightsTitle" class="text-lg font-semibold text-gray-900 mb-6">Key Insights</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 id="insight1Title" class="text-sm font-medium text-blue-800">Top Event by Attendance
                                </h3>
                                <p id="insight1Text" class="mt-1 text-sm text-blue-700">Sunday Morning Service (Oct 15)
                                    with 342 attendees
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-friends text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 id="insight2Title" class="text-sm font-medium text-green-800">Highest Engagement
                                </h3>
                                <p id="insight2Text" class="mt-1 text-sm text-green-700">Johnson Family - attended 12 of
                                    14 events this
                                    month</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 id="insight3Title" class="text-sm font-medium text-purple-800">Growth Opportunity
                                </h3>
                                <p id="insight3Text" class="mt-1 text-sm text-purple-700">Youth events show 15% growth
                                    in first-time
                                    visitors</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="newReportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">New Report</h3>
            <div class="space-y-3">
                <input type="text" placeholder="Report title"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <select
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option>Attendance</option>
                    <option>Engagement</option>
                    <option>Demographics</option>
                    <option>Custom</option>
                </select>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button id="closeNewReport"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button id="createReport"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Create</button>
            </div>
        </div>
    </div>
</body>

</html>
@vite("resources/js/admin-reports-index.js")