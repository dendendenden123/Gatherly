@extends('layouts.member')

@section('header')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                <div class="flex items-center space-x-4">
                    <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-bell-slash mr-2"></i> Mute All
                    </button>
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </button>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')

    <!-- Tabs Navigation -->
    <!-- Tabs Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('member.notification', ['tab' => 'all']) }}"
                    class="border-b-2 border-primary text-primary font-medium py-4 text-sm whitespace-nowrap tab-link active"
                    data-tab="all">
                    All Notifications
                </a>
                <a href="{{ route('member.notification', ['tab' => 'unread']) }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium py-4 text-sm whitespace-nowrap tab-link"
                    data-tab="unread">
                    Unread <span class="ml-1 bg-accent text-white text-xs px-2 py-1 rounded-full">3</span>
                </a>
                <a href="{{ route('member.notification', ['tab' => 'alert']) }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium py-4 text-sm whitespace-nowrap tab-link"
                    data-tab="alerts">
                    Alerts
                </a>
                <a href="{{ route('member.notification', ['tab' => 'announcement']) }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium py-4 text-sm whitespace-nowrap tab-link"
                    data-tab="announcements">
                    Announcements
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Filter and Search -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
            <div class="relative w-full sm:w-64">
                <input type="text" placeholder="Search notifications..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <div class="flex space-x-2">
                <select
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <option>Sort by: Newest</option>
                    <option>Sort by: Oldest</option>
                </select>
                <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- All Notifications Tab -->
            <div class="tab-content active" id="all-tab">
                @forelse ($notfications as $notif)
                    <!-- Notification Item -->
                    <div
                        class="border-b border-gray-200 px-6 py-4 flex items-start hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex-shrink-0 mt-1">
                            <div class="h-10 w-10 bg-primary bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-bullhorn text-primary"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-800">{{  $notif->subject }}</h3>
                                <span class="text-sm text-gray-500">{{  $notif->created_at?->diffForHumans() }}</span>
                            </div>
                            <p class="mt-1 text-gray-600">{{  $notif->message }}</p>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <span
                                    class="bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-md text-xs">{{  $notif->category }}</span>
                                <span class="ml-3"><i class="fas fa-users mr-1"></i> {{  $notif->message }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Unread Notifications Tab (hidden by default) -->
                    <div class="tab-content hidden" id="unread-tab">
                        <!-- Unread notifications would be displayed here -->
                        <div class="px-6 py-8 text-center">
                            <i class="fas fa-bell text-4xl text-gray-300 mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-700">No unread notifications</h3>
                            <p class="mt-1 text-gray-500">You're all caught up!</p>
                        </div>
                    </div>
                @endforelse


                <!-- Notification Item -->
                <div
                    class="border-b border-gray-200 px-6 py-4 flex items-start hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex-shrink-0 mt-1">
                        <div class="h-10 w-10 bg-accent bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-accent"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-800">Security Alert</h3>
                            <span class="text-sm text-gray-500">Yesterday</span>
                        </div>
                        <p class="mt-1 text-gray-600">We detected a login attempt from a new device. If this wasn't you,
                            please secure your account immediately.</p>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <span class="bg-accent bg-opacity-10 text-accent px-2 py-1 rounded-md text-xs">Alert</span>
                            <span class="ml-3"><i class="fas fa-user mr-1"></i> Personal</span>
                        </div>
                    </div>
                </div>

                <!-- Notification Item -->
                <div
                    class="border-b border-gray-200 px-6 py-4 flex items-start hover:bg-gray-50 transition-colors duration-150 bg-blue-50">
                    <div class="flex-shrink-0 mt-1">
                        <div class="h-10 w-10 bg-blue-500 bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-800">New Feature Released</h3>
                            <span class="text-sm text-gray-500">2 days ago</span>
                        </div>
                        <p class="mt-1 text-gray-600">We've released a new dashboard feature to help you track your activity
                            more efficiently. Check it out!</p>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <span class="bg-blue-500 bg-opacity-10 text-blue-500 px-2 py-1 rounded-md text-xs">Update</span>
                            <span class="ml-3"><i class="fas fa-users mr-1"></i> All Members</span>
                        </div>
                    </div>
                </div>

                <!-- Notification Item -->
                <div
                    class="border-b border-gray-200 px-6 py-4 flex items-start hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex-shrink-0 mt-1">
                        <div class="h-10 w-10 bg-secondary bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-secondary"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-800">Event Reminder</h3>
                            <span class="text-sm text-gray-500">Last week</span>
                        </div>
                        <p class="mt-1 text-gray-600">Don't forget about the annual member meeting next Friday at 3:00 PM in
                            the main conference room.</p>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <span
                                class="bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-md text-xs">Event</span>
                            <span class="ml-3"><i class="fas fa-users mr-1"></i> All Members</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unread Notifications Tab (hidden by default) -->
            <div class="tab-content hidden" id="unread-tab">
                <!-- Unread notifications would be displayed here -->
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-bell text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-700">No unread notifications</h3>
                    <p class="mt-1 text-gray-500">You're all caught up!</p>
                </div>
            </div>

            <!-- Alerts Tab (hidden by default) -->
            <div class="tab-content hidden" id="alerts-tab">
                <!-- Alert notifications would be displayed here -->
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-exclamation-triangle text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-700">No alerts at this time</h3>
                    <p class="mt-1 text-gray-500">You have no alert notifications.</p>
                </div>
            </div>

            <!-- Announcements Tab (hidden by default) -->
            <div class="tab-content hidden" id="announcements-tab">
                <!-- Announcement notifications would be displayed here -->
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-bullhorn text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-700">No announcements</h3>
                    <p class="mt-1 text-gray-500">There are no announcements at this time.</p>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span
                    class="font-medium">24</span> results
            </div>
            <div class="flex space-x-2">
                <button
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    Previous
                </button>
                <button
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Next
                </button>
            </div>
        </div>
    </main>

@endsection