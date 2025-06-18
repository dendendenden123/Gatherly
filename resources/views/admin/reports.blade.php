<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly - Reports Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --accent-red: #e74c3c;
            --light-gray: #f5f5f5;
            --medium-gray: #ecf0f1;
            --dark-gray: #95a5a6;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --purple: #9b59b6;
            --blue: #3498db;
            --orange: #e67e22;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--light-gray);
            color: var(--text-dark);
        }

        /* Mobile Header */
        .mobile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        .mobile-logo {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-green);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            display: none;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 99;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.active {
            transform: translateX(0);
            display: flex;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            margin-top: 65px;
        }

        /* Reports Header */
        .reports-header {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .reports-title h1 {
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .report-controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 15px;
        }

        @media (min-width: 768px) {
            .report-controls {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .report-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-group label {
            font-size: 0.9rem;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            background-color: white;
        }

        .report-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary-green);
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
        }

        /* Report Cards */
        .report-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .report-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .report-cards {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .report-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .report-card:hover {
            transform: translateY(-5px);
        }

        .report-card-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .report-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .icon-green {
            background-color: var(--primary-green);
        }

        .icon-blue {
            background-color: var(--blue);
        }

        .icon-purple {
            background-color: var(--purple);
        }

        .icon-orange {
            background-color: var(--orange);
        }

        .icon-red {
            background-color: var(--accent-red);
        }

        .report-card-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .report-card-desc {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        /* Chart Containers */
        .chart-container {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .chart-actions a {
            color: var(--primary-green);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .chart-placeholder {
            height: 300px;
            background-color: var(--medium-gray);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
        }

        /* Report Tables */
        .report-table-container {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid var(--medium-gray);
            color: var(--text-light);
            font-weight: 500;
        }

        .report-table td {
            padding: 12px 10px;
            border-bottom: 1px solid var(--medium-gray);
        }

        /* Responsive Adjustments */
        @media (min-width: 768px) {
            .mobile-header {
                display: none;
            }

            .sidebar {
                display: flex;
                position: relative;
                transform: translateX(0);
                height: auto;
            }

            .main-content {
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <button class="mobile-menu-btn" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="mobile-logo">Gatherly</div>
        <div class="mobile-user-avatar"></div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h2>Gatherly</h2>
            <span>Church Management System</span>
        </div>

        <div class="nav-menu">
            <div class="nav-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-users"></i>
                <span>Members</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-calendar-check"></i>
                <span>Attendance</span>
            </div>
            <div class="nav-item active">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Reports Header -->
        <div class="reports-header">
            <div class="reports-title">
                <h1>Reports Dashboard</h1>
                <p>Analyze and export church data and metrics</p>
            </div>

            <div class="report-controls">
                <div class="report-filters">
                    <div class="filter-group">
                        <label>Report Type:</label>
                        <select id="reportType">
                            <option>All Reports</option>
                            <option>Attendance</option>
                            <option>Membership</option>
                            <option>Financial</option>
                            <option>Events</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Time Period:</label>
                        <select id="timePeriod">
                            <option>Last 30 Days</option>
                            <option>Last 90 Days</option>
                            <option>This Year</option>
                            <option>Custom Range</option>
                        </select>
                    </div>

                    <div class="filter-group" id="customDateRange" style="display: none;">
                        <input type="date" id="startDate">
                        <span>to</span>
                        <input type="date" id="endDate">
                    </div>
                </div>

                <div class="report-actions">
                    <button class="btn btn-outline">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button class="btn btn-primary" id="generateReportBtn">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Report Cards -->
        <div class="report-cards">
            <div class="report-card" id="attendanceTrendsCard">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">Attendance Trends</div>
                        <div class="report-card-desc">Weekly service attendance</div>
                    </div>
                    <div class="report-card-icon icon-green">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="chart-placeholder">
                    [Line chart would display here]
                </div>
            </div>

            <div class="report-card" id="membershipGrowthCard">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">Membership Growth</div>
                        <div class="report-card-desc">New members this year</div>
                    </div>
                    <div class="report-card-icon icon-blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="chart-placeholder">
                    [Bar chart would display here]
                </div>
            </div>

            <div class="report-card" id="givingReportCard">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">Giving Report</div>
                        <div class="report-card-desc">Monthly donations</div>
                    </div>
                    <div class="report-card-icon icon-purple">
                        <i class="fas fa-donate"></i>
                    </div>
                </div>
                <div class="chart-placeholder">
                    [Donut chart would display here]
                </div>
            </div>

            <div class="report-card" id="eventParticipationCard">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">Event Participation</div>
                        <div class="report-card-desc">Top 5 events by attendance</div>
                    </div>
                    <div class="report-card-icon icon-orange">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <div class="chart-placeholder">
                    [Horizontal bar chart would display here]
                </div>
            </div>

            <div class="report-card" id="volunteerHoursCard">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">Volunteer Hours</div>
                        <div class="report-card-desc">Monthly service hours</div>
                    </div>
                    <div class="report-card-icon icon-red">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                </div>
                <div class="chart-placeholder">
                    [Area chart would display here]
                </div>
            </div>

            <div class="report-card" id="demographicsCard">
                <div class="report-card-header">
                    <div>
                        <div class="report-card-title">Demographics</div>
                        <div class="report-card-desc">Age and gender distribution</div>
                    </div>
                    <div class="report-card-icon icon-blue">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
                <div class="chart-placeholder">
                    [Pie chart would display here]
                </div>
            </div>
        </div>

        <!-- Detailed Reports Section -->
        <div class="chart-container">
            <div class="chart-header">
                <div class="chart-title">Monthly Attendance Comparison</div>
                <div class="chart-actions">
                    <a href="#">View Full Report</a>
                </div>
            </div>
            <div class="chart-placeholder">
                [Comparative line chart would display here]
            </div>
        </div>

        <!-- Data Export Section -->
        <div class="report-table-container">
            <div class="chart-header">
                <div class="chart-title">Raw Data Export</div>
                <div class="chart-actions">
                    <select id="exportFormat">
                        <option>CSV</option>
                        <option>Excel</option>
                        <option>PDF</option>
                    </select>
                    <button class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Service Type</th>
                        <th>Total Attendance</th>
                        <th>First Timers</th>
                        <th>Volunteers</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jun 25, 2023</td>
                        <td>Sunday Service</td>
                        <td>245</td>
                        <td>12</td>
                        <td>32</td>
                        <td>Guest speaker</td>
                    </tr>
                    <tr>
                        <td>Jun 18, 2023</td>
                        <td>Sunday Service</td>
                        <td>231</td>
                        <td>8</td>
                        <td>28</td>
                        <td>Father's Day</td>
                    </tr>
                    <tr>
                        <td>Jun 11, 2023</td>
                        <td>Sunday Service</td>
                        <td>218</td>
                        <td>5</td>
                        <td>30</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Show/hide custom date range
        document.getElementById('timePeriod').addEventListener('change', function () {
            const customRange = document.getElementById('customDateRange');
            if (this.value === 'Custom Range') {
                customRange.style.display = 'flex';
            } else {
                customRange.style.display = 'none';
            }
        });

        // Generate Report Button
        document.getElementById('generateReportBtn').addEventListener('click', function () {
            const reportType = document.getElementById('reportType').value;
            alert(`Generating ${reportType} report...`);
            // In a real app, this would generate and download a report
        });

        // Report card clicks
        document.querySelectorAll('.report-card').forEach(card => {
            card.addEventListener('click', function () {
                const reportTitle = this.querySelector('.report-card-title').textContent;
                alert(`Loading detailed ${reportTitle} report...`);
            });
        });
    </script>
</body>

</html>