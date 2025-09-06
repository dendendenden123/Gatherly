@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/officers/index.css') }}" rel="stylesheet">
@endsection

@section('header')
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Officer Management</h1>
        </div>
        <div class="user-avatar"></div>
    </div>
@endsection


@section('content')
    <!-- Main Content -->
    <div class="content">
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">Total Officers</div>
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-value">24</div>
                <div class="card-footer">5 added this quarter</div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">Active Roles</div>
                    <i class="fas fa-list"></i>
                </div>
                <div class="card-value">12</div>
                <div class="card-footer">Different positions</div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">Training Needed</div>
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="card-value">3</div>
                <div class="card-footer">Officers require training</div>
            </div>
        </div>

        <!-- Officer Table -->
        <div class="officer-table-container">
            <div class="table-header">
                <div class="table-title">Church Officers</div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search officers...">
                </div>
                <button class="btn btn-primary" id="addOfficerBtn">
                    <i class="fas fa-plus"></i> Add Officer
                </button>
            </div>

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
                    @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="officer-info">
                                            <div class="officer-avatar"></div>
                                            <div>
                                                <div class="officer-name">{{ $user->full_name }}</div>
                                                <div class="officer-email">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag">
                                            {{$user->officers->map(function ($officers) {
                        return $officers->role_description; })->implode(', ')}}</span>
                                    </td>
                                    <td>{{ optional(optional($user->officers->first())->created_at)->format('M d, Y')}}</td>
                                    <td>
                                        @if($user->status == 'active')
                                            <span class="status-active">
                                                {{ $user->status}}
                                            </span>
                                        @elseif($user->status == 'partially-active')
                                            <span class="status-partial">
                                                {{ $user->status}}
                                            </span>
                                        @else
                                            <span class="status-inactive">
                                                {{ $user->status}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="action-btn edit-btn" onclick="openModal()">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="action-btn remove-btn">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                    @endforeach

                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Deacon Michael Brown</div>
                                    <div class="officer-email">michael@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Deacon Board</span></td>
                        <td>Mar 2021</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Sarah Johnson</div>
                                    <div class="officer-email">sarah@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Worship Leader</span></td>
                        <td>Jun 2022</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Robert Wilson</div>
                                    <div class="officer-email">robert@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Treasurer</span></td>
                        <td>Jan 2020</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Officer Modal -->
    <div class="modal" id="addOfficerModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add New Officer</div>
                <button class="close-modal" id="closeAddOfficerModalBtn">&times;</button>
            </div>

            <form id="officerForm" method="POST" action="{{ route('admin.officers.store') }}">
                @csrf
                <div class="form-group relative max-w-md">
                    <label for="officerName" class="block font-medium">Search name or id</label>
                    <input type="text" id="officerName" name="full_name" value="" placeholder="Enter officer's full name"
                        required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="hidden" name="user_id" id="selectedUserId">
                    <!-- Autocomplete dropdown -->
                    <div id="autoCompleteNames" data-user='{{ $userList }}'
                        class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-w-md hidden">
                        <ul class="divide-y divide-gray-200"></ul>
                    </div>
                </div>


                <div class="form-group">
                    <label class="block font-medium mb-2">Role</label>

                    <div class="space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="pastor" class="rounded text-blue-600">
                            <span>Pastor</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="deacon" class="rounded text-blue-600">
                            <span>Deacon</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="elder" class="rounded text-blue-600">
                            <span>Elder</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="treasurer" class="rounded text-blue-600">
                            <span>Treasurer</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="secretary" class="rounded text-blue-600">
                            <span>Secretary</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="worship" class="rounded text-blue-600">
                            <span>Worship Leader</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="youth" class="rounded text-blue-600">
                            <span>Youth Pastor</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="roles[]" value="other" class="rounded text-blue-600">
                            <span>Other</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelAddOfficer">Cancel</button>
                    <button id='submitAddOfficerForm' type="submit" class="btn btn-primary">Save Officer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Officers Modal Backdrop -->
    <div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50"></div>

    <!--Edit Officers Modal Content -->
    <div id="roleModal"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-xl z-50 hidden w-11/12 max-w-md">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit User Roles</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- User Info -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-700" id="userName">John Doe</h4>
                <p class="text-sm text-gray-600 mt-1">
                    Current Roles: <span id="currentRoles" class="font-medium">Admin, Editor</span>
                </p>
            </div>

            <!-- Available Roles Checklist -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">Available Roles</h4>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="roles" value="admin" class="rounded text-blue-500 mr-2">
                        <span class="text-gray-700">Administrator</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="roles" value="editor" class="rounded text-blue-500 mr-2" checked>
                        <span class="text-gray-700">Editor</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="roles" value="author" class="rounded text-blue-500 mr-2">
                        <span class="text-gray-700">Author</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="roles" value="viewer" class="rounded text-blue-500 mr-2" checked>
                        <span class="text-gray-700">Viewer</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="roles" value="moderator" class="rounded text-blue-500 mr-2">
                        <span class="text-gray-700">Moderator</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    Cancel
                </button>
                <button onclick="saveRoles()"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
    <script>
        @vite("resources/js/admin-officers-index.js");
    </script>
@endsection