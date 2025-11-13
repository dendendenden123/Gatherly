<table>
    <thead>
        <tr>
            <th>Officer</th>
            <th>Role</th>
            <th>Term Start</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($officers as $officer)
            <tr>
                <td>
                    <div class="officer-info">
                        <div class="officer-avatar"></div>
                        <div>
                            <div class="officer-name">{{ $officer->full_name }}</div>
                            <div class="officer-email">{{ $officer->email }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="role-tag">
                        {{$officer->officers->map(function ($officers) {
            return $officers->role->name; })->implode(', ')}}</span>
                </td>
                <td>{{ optional(optional($officer->officers->first())->created_at)->format('M d, Y')}}</td>
                <td>

                    <!-- Edit Button -->
                    <button id="{{ $officer->id }}" data-name='{{ $officer->full_name }}'
                        class="edit-btn px-3 py-1.5 rounded-md bg-blue-600 text-white text-sm font-medium inline-flex items-center gap-1 hover:bg-blue-700 transition shadow-sm hover:shadow-md">
                        <i class="fas fa-edit"></i> Edit
                    </button>

                    @if($officer->status === 'pending')
                        <!-- Approve Button -->
                        <form method="POST" action="{{ route('admin.officers.approve', $officer->id) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-3 py-1.5 rounded-md bg-green-600 text-white text-sm font-medium inline-flex items-center gap-1 hover:bg-green-700 transition shadow-sm hover:shadow-md">
                                <i class="fas fa-check"></i> Approve
                            </button>
                        </form>
                    @endif
                </td>

            </tr>
        @endforeach
    </tbody>
</table>