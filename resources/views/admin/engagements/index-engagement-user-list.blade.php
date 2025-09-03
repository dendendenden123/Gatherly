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
            <th>Attendance</th>
            <th>Roles/ Duties</th>
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userEngagement as $engagement)
            <tr>
                <td>
                    <div class="member-info">
                        <div class="member-avatar"></div>
                        <div>
                            <div>{{ $engagement['user_name'] }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-light);">
                                Joined {{ $engagement['created_at'] }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>{{ $engagement['attendance'] }}%</td>
                <td>{{ $engagement['roles'] }}</td>
                <td>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $engagement['attendance'] }}%;"></div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>