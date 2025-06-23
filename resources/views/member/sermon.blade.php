@extends('layouts.member')
@section('header')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Sermons</h1>
            <p class="text-sm text-gray-500">Explore our library of biblical teachings</p>
        </div>
    </header>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Featured Series -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Featured Series</h2>
                <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                    View All Series <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Series 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden sermon-card transition">
                    <div class="relative h-48 bg-gradient-to-br from-blue-500 to-blue-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center p-4 text-white">
                                <h3 class="text-xl font-bold mb-2">The Gospel of John</h3>
                                <p class="text-sm opacity-90">8-part series</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">Exploring the profound truths in John's account of Jesus' life and
                            ministry.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">In Progress</span>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="#"
                                class="text-primary hover:text-secondary font-medium flex items-center justify-center">
                                <i class="bi bi-collection-play mr-1"></i> View Series
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Series 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden sermon-card transition">
                    <div class="relative h-48 bg-gradient-to-br from-purple-500 to-purple-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center p-4 text-white">
                                <h3 class="text-xl font-bold mb-2">Fruit of the Spirit</h3>
                                <p class="text-sm opacity-90">9-part series</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">Discover how to cultivate the character of Christ in your daily life.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Completed</span>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="#"
                                class="text-primary hover:text-secondary font-medium flex items-center justify-center">
                                <i class="bi bi-collection-play mr-1"></i> View Series
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Series 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden sermon-card transition">
                    <div class="relative h-48 bg-gradient-to-br from-green-500 to-green-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center p-4 text-white">
                                <h3 class="text-xl font-bold mb-2">Sermon on the Mount</h3>
                                <p class="text-sm opacity-90">12-part series</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-600 mb-4">Jesus' revolutionary teaching on kingdom living and true
                            righteousness.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Completed</span>
                            <div class="flex space-x-2">
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="text-gray-400 hover:text-primary">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="#"
                                class="text-primary hover:text-secondary font-medium flex items-center justify-center">
                                <i class="bi bi-collection-play mr-1"></i> View Series
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Sermons -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Recent Sermons</h2>
                <div class="flex items-center space-x-4">
                    <select
                        class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-primary focus:border-primary">
                        <option>Sort by: Newest First</option>
                        <option>Sort by: Oldest First</option>
                        <option>Sort by: Most Popular</option>
                    </select>
                    <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                        View All <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Sermon 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden sermon-card transition">
                    <div class="relative video-thumbnail">
                        <div class="pt-[56.25%] bg-gray-200 relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="play-icon bi bi-play-circle text-4xl text-primary opacity-80 transition"></i>
                            </div>
                        </div>
                        <span class="absolute top-2 left-2 bg-primary text-white text-xs px-2 py-1 rounded">New</span>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">John
                                4:23-24</span>
                            <span class="text-xs text-gray-500">Jun 11, 2023</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">The Heart of Worship</h3>
                        <p class="text-sm text-gray-600 mb-4">Pastor John Smith explores what it means to worship God in
                            spirit and truth.</p>
                        <div class="flex justify-between items-center">
                            <a href="#" class="series-tag text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">The Gospel of
                                John</a>
                            <div class="flex space-x-3 text-sm">
                                <a href="#" class="text-gray-500 hover:text-primary">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sermon 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden sermon-card transition">
                    <div class="relative video-thumbnail">
                        <div class="pt-[56.25%] bg-gray-200 relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="play-icon bi bi-play-circle text-4xl text-primary opacity-80 transition"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">James
                                2:14-26</span>
                            <span class="text-xs text-gray-500">Jun 4, 2023</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Faith in Action</h3>
                        <p class="text-sm text-gray-600 mb-4">Pastor Michael Johnson teaches on the relationship between
                            faith and works in the Christian life.</p>
                        <div class="flex justify-between items-center">
                            <a href="#" class="series-tag text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">Practical
                                Christianity</a>
                            <div class="flex space-x-3 text-sm">
                                <a href="#" class="text-gray-500 hover:text-primary">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sermon 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden sermon-card transition">
                    <div class="relative video-thumbnail">
                        <div class="pt-[56.25%] bg-gray-200 relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="play-icon bi bi-play-circle text-4xl text-primary opacity-80 transition"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">Ephesians
                                2:8-9</span>
                            <span class="text-xs text-gray-500">May 28, 2023</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Saved by Grace</h3>
                        <p class="text-sm text-gray-600 mb-4">Pastor Emily Davis explains the foundational doctrine of
                            salvation by grace through faith.</p>
                        <div class="flex justify-between items-center">
                            <a href="#" class="series-tag text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">Core
                                Doctrines</a>
                            <div class="flex space-x-3 text-sm">
                                <a href="#" class="text-gray-500 hover:text-primary">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-primary">
                                    <i class="bi bi-share"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sermon Categories -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Browse by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="#"
                    class="bg-white rounded-lg shadow-sm p-4 text-center hover:bg-primary hover:text-white transition">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full inline-flex mb-2">
                        <i class="bi bi-book text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium">Book Studies</h3>
                </a>
                <a href="#"
                    class="bg-white rounded-lg shadow-sm p-4 text-center hover:bg-primary hover:text-white transition">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full inline-flex mb-2">
                        <i class="bi bi-collection text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium">Series</h3>
                </a>
                <a href="#"
                    class="bg-white rounded-lg shadow-sm p-4 text-center hover:bg-primary hover:text-white transition">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full inline-flex mb-2">
                        <i class="bi bi-calendar-event text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium">Seasonal</h3>
                </a>
                <a href="#"
                    class="bg-white rounded-lg shadow-sm p-4 text-center hover:bg-primary hover:text-white transition">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full inline-flex mb-2">
                        <i class="bi bi-people text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium">Family</h3>
                </a>
                <a href="#"
                    class="bg-white rounded-lg shadow-sm p-4 text-center hover:bg-primary hover:text-white transition">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full inline-flex mb-2">
                        <i class="bi bi-heart text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium">Relationships</h3>
                </a>
                <a href="#"
                    class="bg-white rounded-lg shadow-sm p-4 text-center hover:bg-primary hover:text-white transition">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full inline-flex mb-2">
                        <i class="bi bi-question-circle text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium">Apologetics</h3>
                </a>
            </div>
        </div>
    </main>
@endsection

<script>
    // Simple tab functionality if needed
    document.querySelectorAll('.series-tag').forEach(tag => {
        tag.addEventListener('click', function (e) {
            e.preventDefault();
            // Here you would typically filter sermons by series
            console.log('Filtering by series:', this.textContent);
        });
    });
</script>