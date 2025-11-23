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
                <th>Update status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('admin.members.show', $user->id) }}">
                            <div class="member-info">
                                <div class="profile_image">
                                    <img src="{{ $user->profile_image && !str_contains($user->profile_image, 'Default_pfp.jpg') ? asset('storage/' . $user->profile_image) : $user->profile_image }}"
                                        alt="{{ $user->full_name }}">
                                </div>
                                <div>
                                    <div class="member-name">{{ $user->full_name }}</div>
                                    <div class="member-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td id="status_{{ $user->id }}">{{ $user->status }}</td>
                    <td>{{ $user->locale}}</td>
                    <td>{{ $user->marital_status }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        <select class="member-status-select" data-user-id="{{ $user->id }}">
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="partially-active" {{ $user->status === 'partially-active' ? 'selected' : '' }}>
                                Partially-Active</option>
                            <option value="expelled" {{ $user->status === 'expelled' ? 'selected' : '' }}>Expelled</option>
                            <option value="transferred" {{ $user->status === 'transferred' ? 'selected' : '' }}>Transferred
                            </option>
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('admin.members.edit', $user->id) }}">
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </a>
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