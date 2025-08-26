@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/members/show.css') }}" rel="stylesheet">
@endsection

@section('header')
<!-- Profile Header -->
<div class="profile-header rounded-xl text-white p-6 mb-6 shadow-lg">
    <div class="flex flex-col md:flex-row items-center">
        <div class="w-32 h-32 rounded-full bg-white bg-opacity-20 p-1 mb-4 md:mb-0">
            <img class="w-full h-full rounded-full object-cover border-4 border-white border-opacity-30"
                src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1160&q=80"
                alt="Profile Image">
        </div>
        <div class="md:ml-6 text-center md:text-left">
            <h1 class="text-3xl font-bold">{{ $user->full_name }}</h1>
            <p class="text-green-100 mt-1">{{ $user->status }} Member • Verified</p>
            <div class="flex flex-wrap items-center justify-center md:justify-start mt-4 gap-3">
                <div class="flex items-center bg-white bg-opacity-20 px-3 py-1 rounded-full">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $user->address }}</span>
                </div>
                <div class="flex items-center bg-white bg-opacity-20 px-3 py-1 rounded-full">
                    <i class="fas fa-phone mr-2"></i>
                    <span>{{ $user->phone }}</span>
                </div>
                <div class="flex items-center bg-white bg-opacity-20 px-3 py-1 rounded-full">
                    <i class="fas fa-envelope mr-2"></i>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
        </div>
        <div class="ml-auto mt-4 md:mt-0">
            <a href="{{ route('admin.attendance.show', $user->id) }}">
                <button
                    class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">
                    <i class="fas fa-calendar-check mr-2"></i>Attendance
                </button>
            </a>
            <a href="{{ route('admin.members.edit', $user->id) }}">
                <button
                    class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">
                    <i class="fas fa-edit mr-2"></i>Edit Profile
                </button>
            </a>

        </div>
    </div>
</div>
@endSection

@section('content')

    <div class="max-w-auto mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
            <!-- Left Column -->
            <div class="md:col-span-2 space-y-6">
                <!-- Personal Information Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 info-card transition-all duration-300">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-user text-green-500 mr-3"></i>Personal Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Full Name</p>
                            <p class="font-medium">{{ $user->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Birthdate</p>
                            <p class="font-medium">{{ $user->birthdate->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Sex</p>
                            <p class="font-medium">{{ $user->sex }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Marital Status</p>
                            <p class="font-medium">{{ $user->marital_status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Baptism Date</p>
                            <p class="font-medium">{{ $user->baptism_date }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 info-card transition-all duration-300">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-address-book text-green-500 mr-3"></i>Contact Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Email Address</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium">{{ $user->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">District</p>
                            <p class="font-medium">{{ $user->district }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Locale</p>
                            <p class="font-medium">{{ $user->locale }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Purok/Grupo</p>
                            <p class="font-medium">{{ $user->purok_grupo }}</p>
                        </div>
                    </div>
                </div>

                <!-- Address Card
                                                        <div class="bg-white rounded-xl shadow-sm p-6 info-card transition-all duration-300">
                                                            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                                                <i class="fas fa-home text-green-500 mr-3"></i>Address
                                                            </h2>
                                                            <div>
                                                                <p class="text-sm text-gray-500">Complete Address</p>
                                                                <p class="font-medium">{{ $user->address }}</p>
                                                            </div>
                                                            <div class="mt-4 h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                                                                <i class="fas fa-map-marked-alt text-4xl text-gray-400"></i>
                                                            </div>
                                                        </div>
                                                    </div> -->

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Member Status</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Account Status</span>
                                <span
                                    class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full status-badge">{{ $user->status }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Verification</span>
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full status-badge">Verified</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Email Confirmation</span>
                                <span
                                    class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full status-badge">{{ $user->email_verified}}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Account Details</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="font-medium">{{ $user->baptism_date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Last Profile Update</p>
                                <p class="font-medium">3 days ago</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">User ID</p>
                                <p class="font-medium"> {{ $user->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Documents</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                    <span>Baptismal Certificate.pdf</span>
                                </div>
                                <button class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file-image text-blue-500 text-xl mr-3"></i>
                                    <span>Valid ID.jpg</span>
                                </div>
                                <button class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <button
                            class="w-full mt-4 px-4 py-2 bg-green-50 text-green-600 rounded-lg font-medium hover:bg-green-100 transition">
                            <i class="fas fa-upload mr-2"></i>Upload Document
                        </button>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <button
                                class="w-full flex items-center justify-center px-4 py-2 bg-green-50 text-green-700 rounded-lg font-medium hover:bg-green-100 transition">
                                <i class="fas fa-envelope mr-2"></i>Send Message
                            </button>
                            <button
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition">
                                <i class="fas fa-calendar-plus mr-2"></i>Schedule Visit
                            </button>
                            <button
                                class="w-full flex items-center justify-center px-4 py-2 bg-purple-50 text-purple-700 rounded-lg font-medium hover:bg-purple-100 transition">
                                <i class="fas fa-file-invoice mr-2"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Simple tab functionality
            document.querySelectorAll('.flex.border-b button').forEach(button => {
                button.addEventListener('click', function () {
                    document.querySelectorAll('.flex.border-b button').forEach(btn => {
                        btn.classList.remove('tab-active');
                    });
                    this.classList.add('tab-active');
                });
            });
        </script>
@endsection