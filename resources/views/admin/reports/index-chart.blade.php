<div class="report-cards">
    <div class="report-card max-w-md" id="membershipGrowthCard">
        <div class="report-card-header">
            <div>
                <div class="report-card-title">Membership Growth</div>
                <div class="report-card-desc">New members this year</div>
            </div>
            <div class="report-card-icon icon-blue">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <!-- membership growth -->
        <div style="height: 300px">
            <x-chart :chartData="$memberShipGrowthChartData"></x-chart>
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
        <div style="height: 300px">
            <x-chart :chartData="$demographicChartData"></x-chart>
        </div>
    </div>
</div>

<!-- Detailed Reports Section -->
<div class="chart-container">
    <div class="chart-header">
        <div class="chart-title">Monthly Attendance Comparison</div>
        <div class="chart-actions">
            <a id="viewFullReportLink" href="{{ route('admin.reports') }}">View Full Report</a>
        </div>
    </div>

    <!-- attendance -->
    <div style="height: 300px">
        <x-chart :chartData="$attendanceChartData"></x-chart>
    </div>

</div>

<!-- Data Export Section -->
<div class="report-table-container">
    <div class="chart-header">
        <div class="chart-title">Raw Data Export</div>
        <div class="chart-actions">
            <select id="exportFormat">
                <option value="csv">CSV</option>
                <option value="excel">Excel</option>
                <option value="pdf">PDF</option>
            </select>
            <button class="btn btn-primary" id="rawExportBtn"
                data-csv="{{ route('admin.reports.attendance.export.csv') }}"
                data-excel="{{ route('admin.reports.attendance.export.excel') }}" style="margin-left: 10px;">
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