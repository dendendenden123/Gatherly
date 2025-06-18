@extends('layouts.member')
@section('header')
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Announcements & Events</h1>
            <p class="text-sm text-gray-500">Stay updated with church activities</p>
        </div>
    </header>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="announcement max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="#" class="tab-active py-4 px-1 text-sm font-medium">
                    Upcoming Events
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                    Recent Announcements
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                    Event Calendar
                </a>
            </nav>
        </div>

        <!-- Upcoming Events Section -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Upcoming Events</h2>
                <button class="text-primary hover:text-secondary font-medium flex items-center">
                    <i class="bi bi-calendar-plus mr-1"></i> Add to Calendar
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Event 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden event-card transition">
                    <div class="relative h-40 bg-gradient-to-r from-primary to-secondary">
                        <div class="absolute top-4 left-4 bg-white text-primary text-sm font-bold px-3 py-1 rounded">
                            Jun 15-19
                        </div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold">Vacation Bible School</h3>
                            <p class="text-sm opacity-90">9:00 AM - 12:00 PM Daily</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">"Deep Sea Discovery" - A week of fun, games, and Bible lessons
                            for kids ages 4-12.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">Children</span>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                            <button class="text-primary hover:text-secondary text-sm font-medium flex items-center">
                                <i class="bi bi-info-circle mr-1"></i> Details
                            </button>
                            <button class="bg-primary hover:bg-secondary text-white px-3 py-1 rounded-md text-sm">
                                RSVP
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden event-card transition">
                    <div class="relative h-40 bg-gradient-to-r from-purple-500 to-purple-700">
                        <div class="absolute top-4 left-4 bg-white text-purple-700 text-sm font-bold px-3 py-1 rounded">
                            Jun 18
                        </div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold">Men's Breakfast</h3>
                            <p class="text-sm opacity-90">8:00 AM - 10:00 AM</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">Monthly gathering for men featuring guest speaker Pastor Mark
                            Johnson on "Biblical Manhood".</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">Men</span>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                            <button class="text-primary hover:text-secondary text-sm font-medium flex items-center">
                                <i class="bi bi-info-circle mr-1"></i> Details
                            </button>
                            <button class="bg-primary hover:bg-secondary text-white px-3 py-1 rounded-md text-sm">
                                RSVP
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden event-card transition">
                    <div class="relative h-40 bg-gradient-to-r from-blue-500 to-blue-700">
                        <div class="absolute top-4 left-4 bg-white text-blue-700 text-sm font-bold px-3 py-1 rounded">
                            Jun 25
                        </div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold">Church Picnic</h3>
                            <p class="text-sm opacity-90">4:00 PM - 8:00 PM</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">Annual summer picnic at Riverside Park. Food, games, and
                            fellowship for all ages!</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">All
                                Church</span>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                            <button class="text-primary hover:text-secondary text-sm font-medium flex items-center">
                                <i class="bi bi-info-circle mr-1"></i> Details
                            </button>
                            <button class="bg-primary hover:bg-secondary text-white px-3 py-1 rounded-md text-sm">
                                RSVP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Announcements Section -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Recent Announcements</h2>
                <button class="text-primary hover:text-secondary font-medium flex items-center">
                    <i class="bi bi-bell mr-1"></i> Notification Settings
                </button>
            </div>

            <div class="space-y-4">
                <!-- Announcement 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 announcement-card transition">
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full mr-4">
                            <i class="bi bi-megaphone text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">VBS Volunteer Meeting</h3>
                                    <p class="text-sm text-gray-500">Posted June 10 by Pastor Sarah</p>
                                </div>
                                <span
                                    class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">Important</span>
                            </div>
                            <p class="mt-2 text-gray-600">All Vacation Bible School volunteers are required to
                                attend a brief meeting this Wednesday at 6:30 PM in the Fellowship Hall. We'll go
                                over schedules, curriculum, and safety procedures.</p>
                            <div class="mt-4 flex items-center space-x-4 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-chat-left-text mr-1"></i> 3 Comments
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-share mr-1"></i> Share
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Announcement 2 -->
                <div class="bg-white rounded-lg shadow-md p-6 announcement-card transition">
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full mr-4">
                            <i class="bi bi-collection text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">New Discipleship Class Starting</h3>
                                    <p class="text-sm text-gray-500">Posted June 8 by Pastor John</p>
                                </div>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Opportunity</span>
                            </div>
                            <p class="mt-2 text-gray-600">Our new 8-week discipleship class "Foundations of Faith"
                                begins Sunday, June 18 at 9:00 AM. This class is perfect for new believers or anyone
                                wanting to strengthen their biblical foundation.</p>
                            <div class="mt-4 flex items-center space-x-4 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-chat-left-text mr-1"></i> 5 Comments
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-share mr-1"></i> Share
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Announcement 3 -->
                <div class="bg-white rounded-lg shadow-md p-6 announcement-card transition">
                    <div class="flex items-start">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full mr-4">
                            <i class="bi bi-heart text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">Food Pantry Donations Needed</h3>
                                    <p class="text-sm text-gray-500">Posted June 5 by Deacon Mark</p>
                                </div>
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Service</span>
                            </div>
                            <p class="mt-2 text-gray-600">Our food pantry is running low on canned vegetables,
                                pasta, and cereal. Please consider bringing donations this Sunday. The collection
                                bins are located in the main lobby.</p>
                            <div class="mt-4 flex items-center space-x-4 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-chat-left-text mr-1"></i> 2 Comments
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-share mr-1"></i> Share
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View More Button -->
                <div class="text-center mt-6">
                    <button
                        class="border border-primary text-primary hover:bg-primary hover:text-white px-6 py-2 rounded-md font-medium transition">
                        View All Announcements
                    </button>
                </div>
            </div>
        </div>
    </main>


    <script>
        // Tab functionality
        const tabs = document.querySelectorAll('announcement nav a');
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('tab-active'));
                tab.classList.add('tab-active');
                // Here you would typically load the content for the selected tab
            });
        });
    </script>
@endsection