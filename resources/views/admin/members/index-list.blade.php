<!-- Members Stats -->
<div class="members-stats">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Total Members</div>
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $totalMembersCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Volunteers</div>
            <i class="fas fa-hands-helping"></i>
        </div>
        <div class="stat-value">{{ $volunteersMemberCount }}</div>
    </div>
</div>

<!-- Members Table -->
<div class="members-table-container">
    <table class="members-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Status</th>
                <th>Locale</th>
                <th>Martital Status</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('admin.members.show', $user->id) }}">
                            <div class="member-info">
                                <div class="member-avatar"></div>
                                <div>
                                    <div class="member-name">{{ $user->full_name }}</div>
                                    <div class="member-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->locale}}</td>
                    <td>{{ $user->marital_status }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        <button class="action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form method='POST' action="{{ route('admin.members.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    @php
        $containerClass = "index-list";
    @endphp
    <x-pagination :containerClass="$containerClass" :data="$users" />
</div>