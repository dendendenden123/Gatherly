@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/engagements/index.css') }}">
@endsection


@section("header")
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
@endsection

@section('content')
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
@endsection

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