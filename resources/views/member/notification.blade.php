@extends('layouts.member')

@section('header')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                <div class="flex items-center space-x-4">

                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')

    <!-- Tabs Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                @php
                    $activeClasses = 'border-b-2 border-primary text-primary';
                    $inactiveClasses = 'border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
                @endphp
                <a href="{{ route('member.notification', ['tab' => 'all']) }}"
                    class="{{ $tab === 'all' ? $activeClasses : $inactiveClasses }} font-medium py-4 text-sm whitespace-nowrap">
                    All Notifications
                </a>
                <a href="{{ route('member.notification', ['tab' => 'unread']) }}"
                    class="{{ $tab === 'unread' ? $activeClasses : $inactiveClasses }} font-medium py-4 text-sm whitespace-nowrap">
                    Unread
                </a>
                <a href="{{ route('member.notification', ['tab' => 'alerts']) }}"
                    class="{{ $tab === 'alerts' ? $activeClasses : $inactiveClasses }} font-medium py-4 text-sm whitespace-nowrap">
                    Alerts
                </a>
                <a href="{{ route('member.notification', ['tab' => 'reminder']) }}"
                    class="{{ $tab === 'reminder' ? $activeClasses : $inactiveClasses }} font-medium py-4 text-sm whitespace-nowrap">
                    Reminder
                </a>
                <a href="{{ route('member.notification', ['tab' => 'announcements']) }}"
                    class="{{ $tab === 'announcements' ? $activeClasses : $inactiveClasses }} font-medium py-4 text-sm whitespace-nowrap">
                    Announcements
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">


        <!-- Notifications List -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
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
                            <h3 class="text-lg font-medium text-gray-800">{{ $notif->subject }}</h3>
                            <span class="text-sm text-gray-500">{{ $notif->created_at?->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1 text-gray-600">{{ $notif->message }}</p>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <span
                                class="bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-md text-xs">{{ $notif->category }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-bell text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-700">No notifications found</h3>
                    <p class="mt-1 text-gray-500">Try switching tabs or check back later.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                @php
                    $from = $notfications->firstItem() ?? 0;
                    $to = $notfications->lastItem() ?? 0;
                    $total = $notfications->total() ?? 0;
                @endphp
                Showing <span class="font-medium">{{ $from }}</span> to <span class="font-medium">{{ $to }}</span> of <span
                    class="font-medium">{{ $total }}</span> results
            </div>
            <div>
                {{ $notfications->onEachSide(1)->links() }}
            </div>
        </div>
    </main>

@endsection