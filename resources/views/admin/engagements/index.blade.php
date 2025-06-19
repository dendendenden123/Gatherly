<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly - Engagement Dashboard</title>
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

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-title h1 {
            font-size: 1.5rem;
            color: var(--primary-green);
        }

        /* Main Layout */
        .main-container {
            display: flex;
            flex-grow: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .nav-menu {
            margin-top: 30px;
        }

        .nav-item {
            padding: 12px 0;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .nav-item i {
            margin-right: 10px;
            width: 20px;
            color: var(--text-light);
        }

        .nav-item.active {
            color: var(--primary-green);
            font-weight: 500;
        }

        .nav-item.active i {
            color: var(--primary-green);
        }

        /* Main Content */
        .content {
            flex-grow: 1;
            padding: 30px;
        }

        /* Engagement Dashboard */
        .engagement-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .engagement-title h2 {
            font-size: 1.3rem;
            color: var(--text-dark);
        }

        .time-filter {
            display: flex;
            gap: 10px;
        }

        .time-filter-btn {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid var(--medium-gray);
            background-color: white;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .time-filter-btn.active {
            background-color: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }

        /* Engagement Metrics */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .metric-title {
            font-weight: 600;
            color: var(--text-dark);
        }

        .metric-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .metric-change {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .metric-change.up {
            color: var(--primary-green);
        }

        .metric-change.down {
            color: var(--accent-red);
        }

        /* Engagement Charts */
        .charts-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (min-width: 1200px) {
            .charts-container {
                grid-template-columns: 2fr 1fr;
            }
        }

        .chart-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .chart-legend {
            display: flex;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 5px;
        }

        .chart-placeholder {
            height: 300px;
            background-color: var(--light-gray);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
        }

        /* Engagement Leaders */
        .leaders-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .leaders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .leaders-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .leaders-table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid var(--medium-gray);
            color: var(--text-light);
            font-weight: 500;
        }

        td {
            padding: 15px 10px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .member-info {
            display: flex;
            align-items: center;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            margin-right: 10px;
            overflow: hidden;
        }

        .engagement-score {
            font-weight: 600;
        }

        .score-high {
            color: var(--primary-green);
        }

        .score-medium {
            color: var(--orange);
        }

        .score-low {
            color: var(--accent-red);
        }

        .progress-bar {
            height: 6px;
            background-color: var(--medium-gray);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary-green);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
            }

            .content {
                padding: 20px;
            }

            .engagement-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .time-filter {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Engagement Dashboard</h1>
        </div>
        <div class="user-avatar"></div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="nav-menu">
                <div class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-user-tie"></i>
                    <span>Officers</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Members</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </div>
                <div class="nav-item active">
                    <i class="fas fa-chart-line"></i>
                    <span>Engagement</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Engagement Header -->
            <div class="engagement-header">
                <div class="engagement-title">
                    <h2>Member Engagement Overview</h2>
                    <p>Track participation and involvement across your congregation</p>
                </div>
                <div class="time-filter">
                    <button class="time-filter-btn active">Last 30 Days</button>
                    <button class="time-filter-btn">Last 90 Days</button>
                    <button class="time-filter-btn">This Year</button>
                    <button class="time-filter-btn">All Time</button>
                </div>
            </div>

            <!-- Engagement Metrics -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-title">Weekly Attendance Rate</div>
                        <i class="fas fa-calendar-check" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="metric-value">78%</div>
                    <div class="metric-change up">
                        <i class="fas fa-arrow-up"></i> 5% from last period
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-title">Volunteer Participation</div>
                        <i class="fas fa-hands-helping" style="color: var(--blue);"></i>
                    </div>
                    <div class="metric-value">42%</div>
                    <div class="metric-change up">
                        <i class="fas fa-arrow-up"></i> 3% from last period
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-header">
                        <div class="metric-title">Small Group Involvement</div>
                        <i class="fas fa-user-friends" style="color: var(--purple);"></i>
                    </div>
                    <div class="metric-value">65%</div>
                    <div class="metric-change down">
                        <i class="fas fa-arrow-down"></i> 2% from last period
                    </div>
                </div>
            </div>

            <!-- Engagement Charts -->
            <div class="charts-container">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Engagement Trends</div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--primary-green);"></div>
                                <span>Attendance</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--blue);"></div>
                                <span>Volunteering</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--purple);"></div>
                                <span>Groups</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        [Line chart showing engagement trends over time]
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Engagement Distribution</div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--primary-green);"></div>
                                <span>High</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--orange);"></div>
                                <span>Medium</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--accent-red);"></div>
                                <span>Low</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        [Pie chart showing engagement distribution]
                    </div>
                </div>
            </div>

            <!-- Engagement Leaders -->
            <div class="leaders-container">
                <div class="leaders-header">
                    <div class="leaders-title">Top Engaged Members</div>
                    <button class="btn btn-outline">
                        <i class="fas fa-download"></i> Export Report
                    </button>
                </div>

                <table class="leaders-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Engagement Score</th>
                            <th>Attendance</th>
                            <th>Volunteering</th>
                            <th>Groups</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar"></div>
                                    <div>
                                        <div>Sarah Johnson</div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">Joined Jun 2022</div>
                                    </div>
                                </div>
                            </td>
                            <td class="engagement-score score-high">94</td>
                            <td>100%</td>
                            <td>12 hrs</td>
                            <td>3 groups</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 94%;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar"></div>
                                    <div>
                                        <div>Michael Brown</div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">Joined Mar 2021</div>
                                    </div>
                                </div>
                            </td>
                            <td class="engagement-score score-high">88</td>
                            <td>92%</td>
                            <td>8 hrs</td>
                            <td>2 groups</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 88%;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar"></div>
                                    <div>
                                        <div>Emily Davis</div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">Joined Jan 2020</div>
                                    </div>
                                </div>
                            </td>
                            <td class="engagement-score score-medium">76</td>
                            <td>85%</td>
                            <td>5 hrs</td>
                            <td>1 group</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 76%;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar"></div>
                                    <div>
                                        <div>Robert Wilson</div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">Joined Sep 2021</div>
                                    </div>
                                </div>
                            </td>
                            <td class="engagement-score score-medium">65</td>
                            <td>78%</td>
                            <td>3 hrs</td>
                            <td>1 group</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 65%;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar"></div>
                                    <div>
                                        <div>Jennifer Lee</div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">Joined May 2023</div>
                                    </div>
                                </div>
                            </td>
                            <td class="engagement-score score-low">42</td>
                            <td>60%</td>
                            <td>1 hr</td>
                            <td>0 groups</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 42%;"></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Time Filter Buttons
        document.querySelectorAll('.time-filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelector('.time-filter-btn.active').classList.remove('active');
                this.classList.add('active');
                // In a real app, this would filter the engagement data
            });
        });

        // In a full implementation, you would add:
        // 1. Chart.js integration for the data visualizations
        // 2. API calls to load real engagement data
        // 3. Member profile links from the leaders table
        // 4. Export functionality for reports
        // 5. Drill-down capabilities for detailed engagement analysis
    </script>
</body>

</html>