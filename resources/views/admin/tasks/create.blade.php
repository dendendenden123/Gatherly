@extends('layouts.admin')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href={{ asset('css/admin/notifications/create.css') }}>
@endsection

@section('header')
    <!-- Creation Header -->
    <div class="create-header">
        <div class="create-title">
            <h1>Create New Task</h1>
            <p>Send messages to your church members</p>
        </div>
    </div>
@endsection

@section('content')

    <!-- Main Content -->
    <!-- Notification Creation Form -->
    <form id="notificationForm" method="POST" action="{{ route('admin.tasks.store') }}" class="creation-form">
        @csrf
        @method('POST')
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
        <!-- Basic Info Section -->
        <div class="form-section">
            <div class="section-title">Task Details</div>

            <div class="form-group">
                <label for="notificationSubject">Title *</label>
                <input type="text" id="taskTitle" name="title" placeholder="Enter task title..." value="{{ old('title') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="taskDescription">Description *</label>
                <textarea id="taskDescription" name="description" placeholder="Type your description here..."
                    required> {{ old('description') }} </textarea>
            </div>

            <div class="form-group">
                <label for="due_date">Due Date *</label>
                <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}"
                    class="form-control @error('due_date') is-invalid @enderror" required>
            </div>

            <div class="form-group">
                <label for="taskPriority">Priority</label>
                <select id="taskPriority" name="priority" class="form-control @error('priority') is-invalid @enderror">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
        </div>

        <!-- Recipients Section -->
        <div class="form-section">
            <div class="section-title">Assignee</div>

            <div class="form-group">
                <label for="recipientType">Assign To *</label>
                <select id="recipientType" name="assignee" class="form-control @error('assignee') is-invalid @enderror"
                    required>
                    <option value="">Select recipient group...</option>
                    <option value="all" {{ old('assignee') == 'all' ? 'selected' : '' }}>All Members</option>
                    <option value="volunteers" {{ old('assignee') == 'volunteers' ? 'selected' : '' }}>All Officers/Volunteer
                    </option>
                    <option value="buklod" {{ old('assignee') == 'buklod' ? 'selected' : '' }}>Buklod</option>
                    <option value="kadiwa" {{ old('assignee') == 'kadiwa' ? 'selected' : '' }}>Kadiwa</option>
                    <option value="binhi" {{ old('assignee') == 'binhi' ? 'selected' : '' }}>Binhi</option>

                    @forelse ($roleNames as $roleName)
                        <option value="{{ $roleName }}" {{ old('assignee') == $roleName ? 'selected' : '' }}>
                            {{ $roleName }}
                        </option>
                    @empty
                        <option value="">No more...</option>
                    @endforelse
                </select>

                @error('assignee')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500"> {{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('admin.tasks.index') }}">
                <button type="button" class="btn btn-outline" id="backBtn">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Submit
            </button>
        </div>
    </form>
    @vite("resources/js/admin-tasks-create.js")
@endsection