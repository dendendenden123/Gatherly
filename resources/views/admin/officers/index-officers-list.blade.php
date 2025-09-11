<table>
    <thead>
        <tr>
            <th>Officer</th>
            <th>Role</th>
            <th>Term Start</th>
            <th>Status</th>
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
                    @if($officer->status == 'active')
                        <span class="status-active">
                            {{ $officer->status}}
                        </span>
                    @elseif($officer->status == 'partially-active')
                        <span class="status-partial">
                            {{ $officer->status}}
                        </span>
                    @else
                        <span class="status-inactive">
                            {{ $officer->status}}
                        </span>
                    @endif
                </td>
                <td>
                    <button id="{{ $officer->id }}" data-name='{{ $officer->full_name  }}' class="action-btn edit-btn">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <form method="POST" action="{{ route('admin.officers.destroy', $officer->id) }}"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn">
                            <i class="fas fa-user-minus"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>