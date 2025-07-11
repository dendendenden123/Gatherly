@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/admin/reports.css') }}" rel="stylesheet">
@endsection

@section('header')
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

@endSection

@section('content')
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

@endSection

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