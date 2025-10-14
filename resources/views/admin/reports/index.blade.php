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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                        <select id="dateRangeSelect"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Year to date</option>
                            <option>Custom range</option>
                        </select>
                    </div>

                    <!-- Event Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                        <select id="eventTypeSelect"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="*">All Events</option>
                            <option value="Baptism">Baptism</option>
                            <option value="Charity Event">Charity Event</option>
                            <option value="Christian Family Organization (CFO) activity">Christian Family Organization
                                (CFO) activity</option>
                            <option value="Evangelical Mission">Evangelical Mission</option>
                            <option value="Inauguration of New Chapels/ Structure">Inauguration of New Chapels/
                                Structure</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Panata">Panata</option>
                            <option value="Weddings">Weddings</option>
                            <option value="Worship Service">Worship Service</option>

                        </select>
                    </div>

                    <!-- Age Group -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age Group`</label>
                        <select id="ministrySelect"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="*">All Members</option>
                            <option value="binhi">Binhi (Below 18)</option>
                            <option value="kadiwa">Kadiwa (18 and above, not married)</option>
                            <option value="buklod">Buklod (18 and above, married)</option>

                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button id="generateBtn"
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Generate Report
                        </button>
                        <button id="resetBtn"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
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
                    <div id="attendanceTrendChart" class="h-80"></div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const state = {
                currentTab: 'attendance',
                trendRange: 'weekly',
                tablePage: 1,
                pageSize: 5,
            };

            const el = {
                attendanceTabBtn: document.getElementById('attendanceTabBtn'),
                engagementTabBtn: document.getElementById('engagementTabBtn'),
                demographicTabBtn: document.getElementById('demographicTabBtn'),
                customTabBtn: document.getElementById('customTabBtn'),
                weeklyBtn: document.getElementById('weeklyBtn'),
                monthlyBtn: document.getElementById('monthlyBtn'),
                yearlyBtn: document.getElementById('yearlyBtn'),
                exportChartBtn: document.getElementById('exportChartBtn'),
                csvBtn: document.getElementById('csvBtn'),
                pdfBtn: document.getElementById('pdfBtn'),
                excelBtn: document.getElementById('excelBtn'),
                dataTableBody: document.getElementById('dataTableBody'),
                pagination: document.getElementById('pagination'),
                fromCount: document.getElementById('fromCount'),
                toCount: document.getElementById('toCount'),
                totalCount: document.getElementById('totalCount'),
                dateRangeSelect: document.getElementById('dateRangeSelect'),
                eventTypeSelect: document.getElementById('eventTypeSelect'),
                ministrySelect: document.getElementById('ministrySelect'),
                generateBtn: document.getElementById('generateBtn'),
                resetBtn: document.getElementById('resetBtn'),
            };

            const mock = {
                charts: {
                    attendance: {
                        weekly: {
                            x: ['Oct 2', 'Oct 9', 'Oct 16', 'Oct 23', 'Oct 30', 'Nov 6', 'Nov 13'],
                            series: [
                                { name: 'Sunday Services', data: [320, 335, 342, 310, 298, 325, 340] },
                                { name: 'Youth Events', data: [65, 72, 78, 70, 68, 75, 80] },
                                { name: 'Bible Studies', data: [40, 42, 45, 38, 35, 40, 44] },
                            ]
                        },
                        monthly: {
                            x: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                            series: [
                                { name: 'Sunday Services', data: [1250, 1320, 1390, 1410, 1470, 1500] },
                                { name: 'Youth Events', data: [300, 320, 350, 360, 380, 400] },
                                { name: 'Bible Studies', data: [180, 190, 200, 210, 220, 230] },
                            ]
                        },
                        yearly: {
                            x: ['2019', '2020', '2021', '2022', '2023', '2024'],
                            series: [
                                { name: 'Sunday Services', data: [12000, 9000, 11000, 13000, 14500, 15200] },
                                { name: 'Youth Events', data: [2600, 2400, 2800, 3200, 3800, 4200] },
                                { name: 'Bible Studies', data: [1500, 1300, 1600, 1800, 2100, 2300] },
                            ]
                        },
                        bars: {
                            attendance: ['Sunday AM', 'Sunday PM', 'Youth', 'Bible Study', 'Men\'s', 'Women\'s', 'Prayer'],
                            data: [342, 215, 78, 45, 32, 28, 15]
                        }
                    },
                    engagement: {
                        weekly: { x: ['W1', 'W2', 'W3', 'W4'], series: [{ name: 'Engagement', data: [70, 75, 78, 80] }] },
                        monthly: { x: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'], series: [{ name: 'Engagement', data: [68, 70, 72, 74, 78, 80] }] },
                        yearly: { x: ['2020', '2021', '2022', '2023', '2024'], series: [{ name: 'Engagement', data: [60, 65, 70, 75, 78] }] },
                        bars: { attendance: ['Groups', 'Volunteers', 'Donations'], data: [120, 85, 60] }
                    },
                    demographics: {
                        weekly: { x: ['Binhi', 'Kadiwa', 'Buklod'], series: [{ name: 'Count', data: [50, 80, 120] }] },
                        monthly: { x: ['Binhi', 'Kadiwa', 'Buklod'], series: [{ name: 'Count', data: [300, 420, 600] }] },
                        yearly: { x: ['Binhi', 'Kadiwa', 'Buklod'], series: [{ name: 'Count', data: [3600, 4600, 7200] }] },
                        bars: { attendance: ['Children', 'Youth', 'Adults', 'Seniors'], data: [90, 150, 320, 60] }
                    },
                    custom: {
                        weekly: { x: ['A', 'B', 'C', 'D'], series: [{ name: 'Metric', data: [10, 20, 15, 25] }] },
                        monthly: { x: ['A', 'B', 'C', 'D', 'E'], series: [{ name: 'Metric', data: [60, 70, 65, 80, 90] }] },
                        yearly: { x: ['2019', '2020', '2021', '2022', '2023'], series: [{ name: 'Metric', data: [100, 120, 150, 170, 190] }] },
                        bars: { attendance: ['X', 'Y', 'Z'], data: [12, 9, 20] }
                    }
                },
                tables: {
                    attendance: Array.from({ length: 47 }).map((_, i) => ({
                        name: `Event ${i + 1}`,
                        date: 'Oct 15, 2023',
                        type: ['Sunday Service', 'Youth Meeting', 'Bible Study', 'Prayer Meeting'][i % 4],
                        attendance: Math.floor(Math.random() * 400) + 20,
                        capacity: [60, 100, 300, 400][i % 4],
                        firstTimers: Math.floor(Math.random() * 20),
                        engagement: [64, 71.7, 75, 78, 85.5][i % 5]
                    })),
                    engagement: Array.from({ length: 24 }).map((_, i) => ({
                        name: `Member ${i + 1}`,
                        date: 'Nov 2024',
                        type: 'Engagement',
                        attendance: `${Math.floor(Math.random() * 12)}/14`,
                        capacity: '-',
                        firstTimers: '-',
                        engagement: `${60 + (i % 20)}%`
                    })),
                    demographics: Array.from({ length: 30 }).map((_, i) => ({
                        name: ['Binhi', 'Kadiwa', 'Buklod'][i % 3],
                        date: '—',
                        type: 'Group',
                        attendance: 20 + (i % 10),
                        capacity: '-',
                        firstTimers: '-',
                        engagement: `${70 + (i % 20)}%`
                    })),
                    custom: Array.from({ length: 12 }).map((_, i) => ({
                        name: `Custom Report Row ${i + 1}`,
                        date: '—',
                        type: 'Metric',
                        attendance: Math.floor(Math.random() * 100),
                        capacity: '-',
                        firstTimers: '-',
                        engagement: `${50 + (i % 40)}%`
                    })),
                }
            };

            let attendanceTrendChart;
            let eventComparisonChart;

            function initCharts() {
                const trendCfg = getTrendConfig();
                attendanceTrendChart = new ApexCharts(document.querySelector('#attendanceTrendChart'), trendCfg);
                attendanceTrendChart.render();

                const barCfg = getBarConfig();
                eventComparisonChart = new ApexCharts(document.querySelector('#eventComparisonChart'), barCfg);
                eventComparisonChart.render();
            }

            function getTrendConfig() {
                const tabCfg = mock.charts[state.currentTab][state.trendRange];
                const colors = ['#4f46e5', '#10b981', '#f59e0b'];
                return {
                    series: tabCfg.series,
                    chart: { height: '100%', type: 'line', zoom: { enabled: false }, toolbar: { show: false } },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    colors,
                    xaxis: { categories: tabCfg.x },
                    legend: { position: 'top' },
                    grid: { borderColor: '#e7e7e7', row: { colors: ['#f8fafc', 'transparent'], opacity: 0.5 } },
                };
            }

            function getBarConfig() {
                const bar = mock.charts[state.currentTab].bars;
                return {
                    series: [{ name: 'Value', data: bar.data }],
                    chart: { type: 'bar', height: '100%', toolbar: { show: false } },
                    plotOptions: { bar: { borderRadius: 4, horizontal: false, columnWidth: '55%' } },
                    dataLabels: { enabled: false },
                    colors: ['#4f46e5'],
                    xaxis: { categories: bar.attendance },
                    yaxis: { title: { text: 'Value' } },
                    grid: { borderColor: '#e7e7e7', row: { colors: ['#f8fafc', 'transparent'], opacity: 0.5 } },
                };
            }

            function updateCharts() {
                const trendCfg = mock.charts[state.currentTab][state.trendRange];
                attendanceTrendChart.updateOptions({ xaxis: { categories: trendCfg.x } });
                attendanceTrendChart.updateSeries(trendCfg.series);

                const bar = mock.charts[state.currentTab].bars;
                eventComparisonChart.updateOptions({ xaxis: { categories: bar.attendance }, yaxis: { title: { text: 'Value' } } });
                eventComparisonChart.updateSeries([{ name: 'Value', data: bar.data }]);
            }

            function renderTable() {
                const data = mock.tables[state.currentTab];
                const total = data.length;
                const start = (state.tablePage - 1) * state.pageSize;
                const end = Math.min(start + state.pageSize, total);
                const pageRows = data.slice(start, end);

                el.dataTableBody.innerHTML = pageRows.map(row => `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${row.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.date}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.type}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.attendance}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.capacity}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.firstTimers}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${Number((row.engagement + '').replace('%', '')) >= 75 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">${row.engagement}${typeof row.engagement === 'number' ? '%' : ''}</span>
                        </td>
                    </tr>
                `).join('');

                el.totalCount.textContent = String(total);
                el.fromCount.textContent = String(total === 0 ? 0 : start + 1);
                el.toCount.textContent = String(end);
                renderPagination(total);
            }

            function renderPagination(total) {
                const pages = Math.max(1, Math.ceil(total / state.pageSize));
                const prevDisabled = state.tablePage === 1;
                const nextDisabled = state.tablePage === pages;
                let html = '';
                html += `<a href="#" data-role="prev" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium ${prevDisabled ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'}"><i class="fas fa-chevron-left"></i></a>`;
                for (let p = 1; p <= pages; p++) {
                    const active = p === state.tablePage;
                    html += `<a href="#" data-page="${p}" class="${active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'} relative inline-flex items-center px-4 py-2 border text-sm font-medium">${p}</a>`;
                }
                html += `<a href="#" data-role="next" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium ${nextDisabled ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'}"><i class="fas fa-chevron-right"></i></a>`;
                el.pagination.innerHTML = html;
            }

            function bindPaginationEvents() {
                el.pagination.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = e.target.closest('a');
                    if (!target) return;
                    const total = mock.tables[state.currentTab].length;
                    const pages = Math.max(1, Math.ceil(total / state.pageSize));
                    if (target.dataset.page) {
                        state.tablePage = Number(target.dataset.page);
                    } else if (target.dataset.role === 'prev' && state.tablePage > 1) {
                        state.tablePage--;
                    } else if (target.dataset.role === 'next' && state.tablePage < pages) {
                        state.tablePage++;
                    } else {
                        return;
                    }
                    renderTable();
                });
            }

            function setActiveTabButton() {
                const map = {
                    attendance: el.attendanceTabBtn,
                    engagement: el.engagementTabBtn,
                    demographics: el.demographicTabBtn,
                    custom: el.customTabBtn,
                };
                [el.attendanceTabBtn, el.engagementTabBtn, el.demographicTabBtn, el.customTabBtn].forEach(b => {
                    b.classList.remove('border-indigo-500', 'text-indigo-600');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                const active = map[state.currentTab];
                active.classList.remove('border-transparent', 'text-gray-500');
                active.classList.add('border-indigo-500', 'text-indigo-600');
            }

            function updateTabContent() {
                const tableTitle = document.getElementById('tableTitle');
                const insightsTitle = document.getElementById('insightsTitle');
                const i1t = document.getElementById('insight1Title');
                const i1x = document.getElementById('insight1Text');
                const i2t = document.getElementById('insight2Title');
                const i2x = document.getElementById('insight2Text');
                const i3t = document.getElementById('insight3Title');
                const i3x = document.getElementById('insight3Text');

                const map = {
                    attendance: {
                        table: 'Event Attendance Details',
                        insights: 'Key Insights',
                        i1t: 'Top Event by Attendance', i1x: 'Sunday Morning Service (Oct 15) with 342 attendees',
                        i2t: 'Highest Engagement', i2x: 'Johnson Family - attended 12 of 14 events this month',
                        i3t: 'Growth Opportunity', i3x: 'Youth events show 15% growth in first-time visitors',
                    },
                    engagement: {
                        table: 'Member Engagement Details',
                        insights: 'Engagement Highlights',
                        i1t: 'Top Engaged Member', i1x: 'Jane Doe - 90% participation this month',
                        i2t: 'Active Groups', i2x: 'Small Groups participation rose by 12%',
                        i3t: 'Volunteer Trend', i3x: 'Volunteering hours up by 8%',
                    },
                    demographics: {
                        table: 'Demographic Breakdown',
                        insights: 'Demographic Insights',
                        i1t: 'Largest Cohort', i1x: 'Adults (Buklod) represent 52% of attendees',
                        i2t: 'Youth Growth', i2x: 'Kadiwa increased by 10% vs last period',
                        i3t: 'Children Attendance', i3x: 'Binhi stable at 18% of total',
                    },
                    custom: {
                        table: 'Custom Report Details',
                        insights: 'Custom Report Insights',
                        i1t: 'Top Metric', i1x: 'Metric A shows 25% improvement',
                        i2t: 'Anomaly Detected', i2x: 'Metric C dipped by 5% last week',
                        i3t: 'Forecast', i3x: 'Expected upward trend next month',
                    }
                };

                const cfg = map[state.currentTab];
                tableTitle.textContent = cfg.table;
                insightsTitle.textContent = cfg.insights;
                i1t.textContent = cfg.i1t; i1x.textContent = cfg.i1x;
                i2t.textContent = cfg.i2t; i2x.textContent = cfg.i2x;
                i3t.textContent = cfg.i3t; i3x.textContent = cfg.i3x;
            }

            function setActiveRangeButton() {
                [el.weeklyBtn, el.monthlyBtn, el.yearlyBtn].forEach(b => {
                    b.classList.remove('bg-indigo-100', 'text-indigo-700');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });
                const map = { weekly: el.weeklyBtn, monthly: el.monthlyBtn, yearly: el.yearlyBtn };
                const active = map[state.trendRange];
                active.classList.remove('bg-gray-100', 'text-gray-700');
                active.classList.add('bg-indigo-100', 'text-indigo-700');
            }

            function exportCSV(rows) {
                const headers = ['Event Name', 'Date', 'Type', 'Attendance', 'Capacity', 'First-Timers', 'Engagement'];
                const data = rows.map(r => [r.name, r.date, r.type, r.attendance, r.capacity, r.firstTimers, r.engagement]);
                const csv = [headers, ...data].map(r => r.join(',')).join('\n');
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `${state.currentTab}-report.csv`;
                a.click();
                URL.revokeObjectURL(url);
            }

            function fakeDownload(name, content, type) {
                const blob = new Blob([content], { type });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = name;
                a.click();
                URL.revokeObjectURL(url);
            }

            function bindEvents() {
                document.querySelector('.fa-print').closest('button').addEventListener('click', () => window.print());
                const newReportBtn = document.querySelector('button i.fa-plus').closest('button');
                let modal = document.getElementById('newReportModal');
                const openModal = () => modal.classList.remove('hidden');
                const closeModal = () => modal.classList.add('hidden');
                newReportBtn.addEventListener('click', openModal);
                document.getElementById('closeNewReport').addEventListener('click', closeModal);
                document.getElementById('createReport').addEventListener('click', () => { closeModal(); alert('Mock: Report created'); });

                el.attendanceTabBtn.addEventListener('click', () => { state.currentTab = 'attendance'; state.tablePage = 1; setActiveTabButton(); updateCharts(); renderTable(); updateTabContent(); });
                el.engagementTabBtn.addEventListener('click', () => { state.currentTab = 'engagement'; state.tablePage = 1; setActiveTabButton(); updateCharts(); renderTable(); updateTabContent(); });
                el.demographicTabBtn.addEventListener('click', () => { state.currentTab = 'demographics'; state.tablePage = 1; setActiveTabButton(); updateCharts(); renderTable(); updateTabContent(); });
                el.customTabBtn.addEventListener('click', () => { state.currentTab = 'custom'; state.tablePage = 1; setActiveTabButton(); updateCharts(); renderTable(); updateTabContent(); });

                el.weeklyBtn.addEventListener('click', () => { state.trendRange = 'weekly'; setActiveRangeButton(); updateCharts(); });
                el.monthlyBtn.addEventListener('click', () => { state.trendRange = 'monthly'; setActiveRangeButton(); updateCharts(); });
                el.yearlyBtn.addEventListener('click', () => { state.trendRange = 'yearly'; setActiveRangeButton(); updateCharts(); });

                el.generateBtn.addEventListener('click', () => { alert('Mock: Report generated for selected filters'); renderTable(); updateCharts(); });
                el.resetBtn.addEventListener('click', () => { el.dateRangeSelect.selectedIndex = 0; el.eventTypeSelect.selectedIndex = 0; el.ministrySelect.selectedIndex = 0; });

                el.exportChartBtn.addEventListener('click', () => {
                    const png = 'Mock chart export';
                    fakeDownload('chart-export.txt', png, 'text/plain');
                });

                el.csvBtn.addEventListener('click', () => exportCSV(mock.tables[state.currentTab]));
                el.pdfBtn.addEventListener('click', () => fakeDownload(`${state.currentTab}.pdf`, 'Mock PDF content', 'application/pdf'));
                el.excelBtn.addEventListener('click', () => fakeDownload(`${state.currentTab}.xlsx`, 'Mock Excel content', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));

                document.getElementById('mobilePrev').addEventListener('click', (e) => { e.preventDefault(); if (state.tablePage > 1) { state.tablePage--; renderTable(); } });
                document.getElementById('mobileNext').addEventListener('click', (e) => { e.preventDefault(); const total = mock.tables[state.currentTab].length; const pages = Math.ceil(total / state.pageSize); if (state.tablePage < pages) { state.tablePage++; renderTable(); } });

                bindPaginationEvents();
            }

            initCharts();
            setActiveTabButton();
            setActiveRangeButton();
            renderTable();
            updateTabContent();
            bindEvents();
        });
    </script>

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