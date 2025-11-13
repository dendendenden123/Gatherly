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
    <div class="content" style="padding-top: 0;">
        <!-- Filters -->
        <div class="filters-container">
            <form id="officerFilters" class="filter-form">
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" placeholder="Search by name or ID"
                        value="{{ request('search') }}" class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="filter-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="partially-active" {{ request('status') == 'partially-active' ? 'selected' : '' }}>Partially Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="expelled" {{ request('status') == 'expelled' ? 'selected' : '' }}>Expelled</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="filter-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="filter-input">
                </div>

                <div class="filter-group">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="filter-input">
                </div>
            </form>
        </div>

        <!-- Officer Table -->
        <div class="officer-table-container">
            <div class="table-header">
                <div class="table-title">Members Roles</div>
                <button class="btn btn-primary" id="addOfficerBtn">
                    <i class="fas fa-plus"></i> Add Officer
                </button>
            </div>
            <div class="officer-list" id="officersList">
                @include('admin.officers.index-officers-list')
            </div>
        </div>
    </div>

    <!-- Add Officer Modal -->
    <div class="modal" id="addOfficerModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add New Role</div>
                <button class="close-modal" id="closeAddOfficerModalBtn">&times;</button>
            </div>

            <form id="officerForm" method="POST" action="{{ route('admin.officers.store') }}">
                @csrf
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#3085d6',
                        });
                    </script>
                @elseif(session('error'))
                    <script>
                        Swal.fire({
                            icon: 'Error',
                            title: 'Failed!',
                            text: '{{ session('error') }}',
                            confirmButtonColor: '#d63030ff',
                        });
                    </script>
                @endif
                <div class="form-group relative max-w-md">
                    <label for="officerName" class="block font-medium">Search name or id</label>
                    <input type="text" id="officerName" value="" placeholder="Enter officer's full name" required
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="hidden" name="user_id" id="selectedUserId">
                    <!-- Autocomplete dropdown -->
                    <div id="autoCompleteNames" data-user='{{ $formattedUser }}'
                        class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-w-md hidden">
                        <ul class="divide-y divide-gray-200"></ul>
                    </div>
                </div>


                <div class="form-group">
                    <label class="block font-medium mb-2">Role</label>
                    <div class="role-list space-y-2">
                        @foreach ($roles as $role)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                    class="role-checkbox rounded text-blue-600">
                                <span>{{$role->name}}</span>
                            </label>
                        @endforeach
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