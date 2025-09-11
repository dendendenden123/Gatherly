@extends('layouts.admin')
@section('content')
    <!-- Dashboard Widgets -->
    <div class="dashboard-widgets grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="widget bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="widget-header flex items-center justify-between">
                <div class="widget-title text-sm font-semibold text-gray-700">Total Members</div>
                <div class="h-9 w-9 rounded-full bg-primary/10 text-primary grid place-items-center">
                <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="widget-value text-3xl font-bold text-primary">{{ number_format($totalMembers ?? 0) }}</div>
            <div class="widget-footer flex items-center text-xs text-gray-500">
                <i class="fas fa-arrow-up text-primary mr-1"></i>
                <span class="text-primary">12% from last month</span>
            </div>
        </div>

        <div class="widget bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="widget-header flex items-center justify-between">
                <div class="widget-title text-sm font-semibold text-gray-700">Weekly Attendance</div>
                <div class="h-9 w-9 rounded-full bg-secondary/10 text-secondary grid place-items-center">
                <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="widget-value text-3xl font-bold text-secondary">{{ number_format($weeklyAttendance ?? 0) }}</div>
            <div class="widget-footer flex items-center text-xs text-gray-500">
                <i class="fas fa-arrow-up text-secondary mr-1"></i>
                <span class="text-secondary">5% from last week</span>
            </div>
        </div>

        <div class="widget bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="widget-header flex items-center justify-between">
                <div class="widget-title text-sm font-semibold text-gray-700">Upcoming Events</div>
                <div class="h-9 w-9 rounded-full bg-accent/10 text-accent grid place-items-center">
                <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="widget-value text-3xl font-bold text-accent">{{ number_format($upcomingEventsCount ?? 0) }}</div>
            <div class="widget-footer text-xs text-gray-500">
                <span>This week</span>
            </div>
        </div>

        <div class="widget bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="widget-header flex items-center justify-between">
                <div class="widget-title text-sm font-semibold text-gray-700">Volunteers</div>
                <div class="h-9 w-9 rounded-full bg-primary/10 text-primary grid place-items-center">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
            </div>
            <div class="widget-value text-3xl font-bold text-primary">{{ number_format($volunteersCount ?? 0) }}</div>
            <div class="widget-footer flex items-center text-xs text-gray-500">
                <span class="">Active volunteers</span>
            </div>
        </div>
    </div>
    <!-- Main Sections -->
    <div class="main-sections">
        <div class="section bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="section-header flex items-center justify-between">
                <div class="section-title text-base font-semibold text-gray-800">Member Status Breakdown</div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="status-card border-l-4 border-primary bg-primary/5 rounded-lg p-4">
                    <div class="status-label text-xs uppercase tracking-wide text-gray-600">Active</div>
                    <div class="status-value text-2xl font-bold text-primary">{{ number_format($activeCount ?? 0) }}</div>
                </div>
                <div class="status-card border-l-4 border-gray-300 bg-gray-50 rounded-lg p-4">
                    <div class="status-label text-xs uppercase tracking-wide text-gray-600">Inactive</div>
                    <div class="status-value text-2xl font-bold text-gray-700">{{ number_format($inactiveCount ?? 0) }}
                    </div>
                </div>
                <div class="status-card border-l-4 border-secondary bg-secondary/5 rounded-lg p-4">
                    <div class="status-label text-xs uppercase tracking-wide text-gray-600">Partially-Active</div>
                    <div class="status-value text-2xl font-bold text-secondary">
                        {{ number_format($partiallyActiveCount ?? 0) }}</div>
                </div>
                <div class="status-card border-l-4 border-accent bg-accent/5 rounded-lg p-4">
                    <div class="status-label text-xs uppercase tracking-wide text-gray-600">Expelled</div>
                    <div class="status-value text-2xl font-bold text-accent">{{ number_format($expelledCount ?? 0) }}</div>
                </div>
            </div>
        </div>

        <div class="section bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="section-header flex items-center justify-between">
                <div class="section-title text-base font-semibold text-gray-800">Recent Members</div>
                <div class="section-actions">
                    <a href="#" class="text-primary hover:text-dark-green text-sm">View All</a>
                </div>
            </div>

            <table class="members-table w-full text-sm">
                <thead class="text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="py-3">Name</th>
                        <th class="py-3">Join Date</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentMembers as $member)
                        <tr>
                            <td class="py-3">
                                <div class="member-info flex items-center gap-2">
                                    <div class="member-avatar h-8 w-8 rounded-full bg-gray-200"></div>
                                <div>
                                        <div class="member-name font-medium text-gray-800">{{ $member->full_name ?? (ucfirst($member->first_name) . ' ' . ucfirst($member->last_name)) }}</div>
                                        <div class="member-email text-xs text-gray-500">{{ $member->email }}</div>
                                </div>
                            </div>
                        </td>
                            <td class="py-3">{{ optional($member->created_at)->format('M d, Y') }}</td>
                            <td class="py-3">
                                @php $status = $member->status ?? 'active'; @endphp
                                <span class="px-2 py-1 rounded-full text-xs {{ $status === 'inactive' ? 'bg-accent/10 text-accent' : ($status === 'partially-active' ? 'bg-secondary/10 text-secondary' : ($status === 'expelled' ? 'bg-red-100 text-red-700' : 'bg-primary/10 text-primary')) }}">{{ ucfirst($status) }}</span>
                        </td>
                            <td class="py-3">
                                <button class="action-btn edit-btn text-primary border border-primary px-2 py-1 rounded">Edit</button>
                                <button class="action-btn delete-btn text-accent border border-accent px-2 py-1 rounded">Delete</button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">No recent members found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="section-header flex items-center justify-between">
                <div class="section-title text-base font-semibold text-gray-800">Recent Activity</div>
                <div class="section-actions">
                    <a href="#" class="text-primary hover:text-dark-green text-sm">View All</a>
                </div>
            </div>

            <ul class="activity-list divide-y divide-gray-100">
                <li class="activity-item flex items-start gap-3 py-3">
                    <div class="activity-icon h-9 w-9 rounded-full bg-primary/10 text-primary grid place-items-center">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-details">
                        <h4 class="text-sm font-medium text-gray-800">New Member Added</h4>
                        <p class="text-xs text-gray-500">Sarah Johnson joined the church</p>
                        <div class="activity-time text-[11px] text-gray-400">2 hours ago</div>
                    </div>
                </li>
                <li class="activity-item flex items-start gap-3 py-3">
                    <div class="activity-icon h-9 w-9 rounded-full bg-secondary/10 text-secondary grid place-items-center">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="activity-details">
                        <h4 class="text-sm font-medium text-gray-800">Sunday Service</h4>
                        <p class="text-xs text-gray-500">Attendance recorded: 876 members</p>
                        <div class="activity-time text-[11px] text-gray-400">1 day ago</div>
                    </div>
                </li>
                <li class="activity-item flex items-start gap-3 py-3">
                    <div class="activity-icon h-9 w-9 rounded-full bg-accent/10 text-accent grid place-items-center">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="activity-details">
                        <h4 class="text-sm font-medium text-gray-800">Notification Sent</h4>
                        <p class="text-xs text-gray-500">Weekly bulletin sent to all members</p>
                        <div class="activity-time text-[11px] text-gray-400">2 days ago</div>
                    </div>
                </li>
                <li class="activity-item flex items-start gap-3 py-3">
                    <div class="activity-icon h-9 w-9 rounded-full bg-gray-200 text-gray-700 grid place-items-center">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="activity-details">
                        <h4 class="text-sm font-medium text-gray-800">Officer Assignment</h4>
                        <p class="text-xs text-gray-500">Michael Brown assigned as Small Group Leader</p>
                        <div class="activity-time text-[11px] text-gray-400">3 days ago</div>
                    </div>
                </li>
                <li class="activity-item flex items-start gap-3 py-3">
                    <div class="activity-icon h-9 w-9 rounded-full bg-gray-200 text-gray-700 grid place-items-center">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div class="activity-details">
                        <h4 class="text-sm font-medium text-gray-800">Volunteer Signup</h4>
                        <p class="text-xs text-gray-500">5 new volunteers for Food Bank event</p>
                        <div class="activity-time text-[11px] text-gray-400">4 days ago</div>
                    </div>
                </li>
            </ul>

            <div class="quick-actions mt-4">
                <h3 class="section-title text-base font-semibold text-gray-800">Quick Actions</h3>
                <div class="action-buttons grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                    <button
                        class="action-button flex items-center justify-center gap-2 bg-primary hover:bg-dark-green text-white rounded-md px-3 py-2 transition">
                        <i class="fas fa-user-plus"></i>
                        <span class="text-sm">Add Member</span>
                    </button>
                    <button
                        class="action-button flex items-center justify-center gap-2 bg-secondary hover:bg-dark-green text-white rounded-md px-3 py-2 transition">
                        <i class="fas fa-calendar-plus"></i>
                        <span class="text-sm">Create Event</span>
                    </button>
                    <button
                        class="action-button flex items-center justify-center gap-2 bg-primary hover:bg-dark-green text-white rounded-md px-3 py-2 transition">
                        <i class="fas fa-envelope"></i>
                        <span class="text-sm">Send Message</span>
                    </button>
                    <button
                        class="action-button flex items-center justify-center gap-2 bg-accent hover:bg-red-600 text-white rounded-md px-3 py-2 transition">
                        <i class="fas fa-file-export"></i>
                        <span class="text-sm">Generate Report</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right column: Attendance trend, Upcoming Events, Birthdays -->
        <div class="section bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="section-header flex items-center justify-between">
                <div class="section-title text-base font-semibold text-gray-800">Attendance Trend</div>
            </div>
            <div>
                <canvas id="attendanceTrend" height="120"></canvas>
            </div>
        </div>

        <div class="section bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="section-header flex items-center justify-between">
                <div class="section-title text-base font-semibold text-gray-800">Upcoming Events</div>
                <div class="text-xs text-gray-500">Next 5</div>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($upcomingEvents as $occ)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded bg-primary/10 text-primary grid place-items-center">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-800">{{ $occ->event->event_name ?? 'Event' }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($occ->occurrence_date)->format('M d, Y') }} @ {{ $occ->start_time_formatted ?? '' }}</div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="py-6 text-center text-gray-500">No upcoming events.</li>
                @endforelse
            </ul>
        </div>

        <div class="section bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="section-header flex items-center justify-between">
                <div class="section-title text-base font-semibold text-gray-800">Birthdays This Week</div>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse($birthdaysThisWeek as $b)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full bg-secondary/10 text-secondary grid place-items-center">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-800">{{ $b->full_name ?? (ucfirst($b->first_name) . ' ' . ucfirst($b->last_name)) }}</div>
                                <div class="text-xs text-gray-500">{{ optional($b->birthdate)->format('M d') }}</div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="py-6 text-center text-gray-500">No birthdays this week.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
@section('styles')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendanceTrend');
            if (ctx) {
                const labels = @json($chartLabels ?? []);
                const values = @json($chartValues ?? []);
                if (labels.length && values.length) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: 'Present (weekly) ',
                                data: values,
                                borderColor: '#27ae60',
                                backgroundColor: 'rgba(39, 174, 96, 0.15)',
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 3,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { grid: { display: false } },
                                y: { grid: { color: '#ecf0f1' }, beginAtZero: true }
                            }
                        }
                    });
                }
            }
        });
    </script>
@endsection