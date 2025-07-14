<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly Church | Loving God, Serving People</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2ecc71',
                        secondary: '#27ae60',
                        accent: '#e74c3c',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href={{ asset('css/welcome.css') }}>
</head>

<body class="font-sans antialiased text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="bi bi-church text-primary text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-primary">Gatherly</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about" class="text-gray-700 hover:text-primary transition">About</a>
                    <a href="#ministries" class="text-gray-700 hover:text-primary transition">Ministries</a>
                    <a href="#sermons" class="text-gray-700 hover:text-primary transition">Sermons</a>
                    <a href="#events" class="text-gray-700 hover:text-primary transition">Events</a>
                    <a href="#contact" class="text-gray-700 hover:text-primary transition">Contact</a>
                    <a href="{{ route('showLoginForm') }}" class="text-gray-700 hover:text-primary transition">Log
                        In</a>
                    <a href="{{ route('showRegisterForm') }}"
                        class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md transition">Register</a>
                </div>
                <div class="md:hidden flex items-center">
                    <button class="text-gray-700">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="md:flex items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">Welcome to <span class="text-primary">Grace
                            Community Church</span></h1>
                    <p class="text-lg text-gray-600 mb-8">A loving family of believers in Christ, serving our community
                        since 1985.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#services"
                            class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-md text-center font-medium transition">Service
                            Times</a>
                        <a href="#new"
                            class="border border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-md text-center font-medium transition">New
                            Here?</a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-white p-2 rounded-lg shadow-xl">
                        <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                            alt="Gatherly Church Building" class="rounded-lg w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Times -->
    <section id="services" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Join Us This Week</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We'd love to worship with you</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <!-- Sunday Service -->
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <div
                        class="bg-primary bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="bi bi-sun text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sunday Morning</h3>
                    <p class="text-gray-600 mb-2">9:00 AM - Sunday School</p>
                    <p class="text-gray-600 font-medium">10:30 AM - Worship Service</p>
                </div>

                <!-- Wednesday Service -->
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <div
                        class="bg-primary bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="bi bi-people text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Wednesday Night</h3>
                    <p class="text-gray-600 mb-2">6:00 PM - Bible Study</p>
                    <p class="text-gray-600 font-medium">7:00 PM - Prayer Meeting</p>
                </div>

                <!-- Online Service -->
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <div
                        class="bg-primary bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <i class="bi bi-camera-video text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Online</h3>
                    <p class="text-gray-600 mb-2">Live Stream Sundays at 10:30 AM</p>
                    <a href="#" class="text-primary hover:text-secondary font-medium">Watch Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10">
                    <h2 class="text-3xl font-bold mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-4">Founded in 1985, Gatherly Church began as a small Bible study
                        in a living room. Today, we're a vibrant congregation of over 500 members, committed to sharing
                        God's love in our community.</p>
                    <p class="text-gray-600 mb-6">Our mission is simple: <span class="font-semibold text-primary">"To
                            know Christ and make Him known."</span> We believe in the power of authentic relationships,
                        biblical teaching, and serving others.</p>
                    <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                        Learn more about our beliefs <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="md:w-1/2">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                            alt="Church volunteers" class="rounded-lg h-64 w-full object-cover">
                        <img src="https://images.unsplash.com/photo-1581368135155-a37b192ec71f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                            alt="Church worship" class="rounded-lg h-64 w-full object-cover">
                        <img src="https://images.unsplash.com/photo-1566669437687-7040a6926753?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                            alt="Pastor teaching" class="rounded-lg h-64 w-full object-cover">
                        <img src="https://images.unsplash.com/photo-1542403779-346d8f60b1f3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                            alt="Church baptism" class="rounded-lg h-64 w-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pastoral Staff -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Meet Our Pastoral Team</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Shepherds of Gatherly Church</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Senior Pastor -->
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                        alt="Pastor John Smith"
                        class="w-48 h-48 rounded-full object-cover mx-auto mb-4 border-4 border-primary border-opacity-25">
                    <h3 class="text-xl font-semibold">Pastor John Smith</h3>
                    <p class="text-secondary mb-2">Senior Pastor</p>
                    <p class="text-gray-600 text-sm">Serving since 2005. Married to Sarah with three children.</p>
                </div>

                <!-- Associate Pastor -->
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                        alt="Pastor Michael Johnson"
                        class="w-48 h-48 rounded-full object-cover mx-auto mb-4 border-4 border-primary border-opacity-25">
                    <h3 class="text-xl font-semibold">Pastor Michael Johnson</h3>
                    <p class="text-secondary mb-2">Associate Pastor</p>
                    <p class="text-gray-600 text-sm">Oversees youth and outreach ministries.</p>
                </div>

                <!-- Worship Pastor -->
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                        alt="Pastor Emily Davis"
                        class="w-48 h-48 rounded-full object-cover mx-auto mb-4 border-4 border-primary border-opacity-25">
                    <h3 class="text-xl font-semibold">Pastor Emily Davis</h3>
                    <p class="text-secondary mb-2">Worship Pastor</p>
                    <p class="text-gray-600 text-sm">Leads our worship ministry and creative arts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Sermons -->
    <section id="sermons" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Recent Sermons</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Messages to encourage and challenge you</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Sermon 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md sermon-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm text-gray-500">June 4, 2023</span>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs px-2 py-1 rounded">John
                                3:16</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">The Heart of the Gospel</h3>
                        <p class="text-gray-600 mb-4">Pastor John Smith explores the depth of God's love expressed in
                            this famous verse.</p>
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                                Watch <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-primary">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sermon 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md sermon-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm text-gray-500">May 28, 2023</span>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs px-2 py-1 rounded">Psalm
                                23</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">The Lord is My Shepherd</h3>
                        <p class="text-gray-600 mb-4">Pastor Michael Johnson shares comfort from this beloved Psalm.</p>
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                                Watch <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-primary">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sermon 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md sermon-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm text-gray-500">May 21, 2023</span>
                            <span class="bg-primary bg-opacity-10 text-primary text-xs px-2 py-1 rounded">Ephesians
                                2:8-9</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Saved by Grace</h3>
                        <p class="text-gray-600 mb-4">Pastor Emily Davis teaches on the foundation of our salvation.</p>
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                                Watch <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-primary">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center text-primary hover:text-secondary font-medium">
                    View All Sermons <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Ministries Section -->
    <section id="ministries" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Our Ministries</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Growing together in faith and service</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Children's Ministry -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                        alt="Children's Ministry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Kids for Christ</h3>
                        <p class="text-gray-600 mb-4">Sunday mornings and Wednesday nights for children ages 3-12. Fun,
                            safe environment where kids learn about Jesus.</p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Learn more <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Youth Ministry -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1549060279-7e168fcee0c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                        alt="Youth Ministry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Youth Alive</h3>
                        <p class="text-gray-600 mb-4">For teens in 7th-12th grade. Weekly meetings, retreats, and
                            mission opportunities.</p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Learn more <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Women's Ministry -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                        alt="Women's Ministry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Women of Grace</h3>
                        <p class="text-gray-600 mb-4">Monthly gatherings, Bible studies, and service projects for women
                            of all ages.</p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Learn more <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Men's Ministry -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                        alt="Men's Ministry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Men of Integrity</h3>
                        <p class="text-gray-600 mb-4">Saturday morning breakfasts and accountability groups to
                            strengthen men in faith.</p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Learn more <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Worship Ministry -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1501612780327-45045538702b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                        alt="Worship Ministry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Praise & Worship</h3>
                        <p class="text-gray-600 mb-4">Opportunities to serve through music, vocals, and technical arts.
                        </p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Learn more <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Outreach Ministry -->
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80"
                        alt="Outreach Ministry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Community Outreach</h3>
                        <p class="text-gray-600 mb-4">Food pantry, homeless ministry, and local mission opportunities.
                        </p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Learn more <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section id="events" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Upcoming Events</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Join us for these special gatherings</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Event 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="bg-primary text-white p-4 text-center">
                        <div class="text-2xl font-bold">15</div>
                        <div class="text-sm">JUNE</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Vacation Bible School</h3>
                        <p class="text-gray-600 mb-4">June 15-19 | 9:00 AM - 12:00 PM</p>
                        <p class="text-gray-600 mb-4">"Deep Sea Discovery" - A week of fun, games, and Bible lessons for
                            kids ages 4-12.</p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Register <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Event 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="bg-primary text-white p-4 text-center">
                        <div class="text-2xl font-bold">25</div>
                        <div class="text-sm">JUNE</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Summer Picnic</h3>
                        <p class="text-gray-600 mb-4">June 25 | 4:00 PM - 8:00 PM</p>
                        <p class="text-gray-600 mb-4">Church-wide picnic at Riverside Park. Food, games, and fellowship
                            for all ages.</p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Details <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Event 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="bg-primary text-white p-4 text-center">
                        <div class="text-2xl font-bold">07</div>
                        <div class="text-sm">JULY</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Mission Trip Meeting</h3>
                        <p class="text-gray-600 mb-4">July 7 | 6:30 PM</p>
                        <p class="text-gray-600 mb-4">Informational meeting for our upcoming mission trip to Guatemala.
                        </p>
                        <a href="#" class="text-primary hover:text-secondary font-medium flex items-center">
                            Sign up <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center text-primary hover:text-secondary font-medium">
                    View Full Calendar <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- New Here Section -->
    <section id="new" class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10">
                    <h2 class="text-3xl font-bold mb-6">New to Gatherly?</h2>
                    <p class="mb-6 opacity-90">We're so glad you're considering visiting our church! Here's what you can
                        expect:</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start">
                            <i class="bi bi-check-circle mr-2 mt-1"></i>
                            <span>Friendly people who'll greet you with a smile</span>
                        </li>
                        <li class="flex items-start">
                            <i class="bi bi-check-circle mr-2 mt-1"></i>
                            <span>Casual dress - come as you are</span>
                        </li>
                        <li class="flex items-start">
                            <i class="bi bi-check-circle mr-2 mt-1"></i>
                            <span>Engaging worship and practical Bible teaching</span>
                        </li>
                        <li class="flex items-start">
                            <i class="bi bi-check-circle mr-2 mt-1"></i>
                            <span>Safe, fun programs for your kids</span>
                        </li>
                    </ul>
                    <a href="#"
                        class="bg-white text-primary hover:bg-gray-100 px-6 py-3 rounded-md font-medium inline-block transition">Plan
                        Your Visit</a>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-white p-1 rounded-lg shadow-xl">
                        <img src="https://images.unsplash.com/photo-1541557435984-1c79685a082b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                            alt="Church welcome" class="rounded-lg w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Contact Us</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We'd love to hear from you</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-xl font-semibold mb-6">Get in Touch</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="bg-primary bg-opacity-10 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Address</h4>
                                <p class="text-gray-600">123 Faith Avenue<br>Springfield, MO 65804</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="bg-primary bg-opacity-10 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="bi bi-telephone text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Phone</h4>
                                <p class="text-gray-600">(417) 555-1234</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="bg-primary bg-opacity-10 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="bi bi-envelope text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Email</h4>
                                <p class="text-gray-600">info@gracecommunity.org</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="bg-primary bg-opacity-10 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                                <i class="bi bi-clock text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Office Hours</h4>
                                <p class="text-gray-600">Monday-Thursday: 9:00 AM - 4:00 PM<br>Friday: 9:00 AM - 12:00
                                    PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-6">Send Us a Message</h3>
                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" id="name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="subject"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"></textarea>
                        </div>
                        <button type="submit"
                            class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-md font-medium transition">Send
                            Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div class="h-96 w-full">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3172.465247894534!2d-93.2913846846943!3d37.33404597984245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87cf62dd87d6e81f%3A0x76db2ff4de702b77!2sSpringfield%2C%20MO%2C%20USA!5e0!3m2!1sen!2s!4v1620000000000!5m2!1sen!2s"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-church text-primary text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-white">Gatherly Church</span>
                    </div>
                    <p class="mb-4">Loving God, Serving People - Since 1985</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-youtube text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-spotify text-xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#ministries" class="hover:text-white transition">Ministries</a></li>
                        <li><a href="#sermons" class="hover:text-white transition">Sermons</a></li>
                        <li><a href="#events" class="hover:text-white transition">Events</a></li>
                        <li><a href="#" class="hover:text-white transition">Give</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Bible Reading Plan</a></li>
                        <li><a href="#" class="hover:text-white transition">Prayer Requests</a></li>
                        <li><a href="#" class="hover:text-white transition">Member Login</a></li>
                        <li><a href="#" class="hover:text-white transition">Church Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Volunteer</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-gray-500 text-center">
                <p>&copy; 2023 Gatherly Church. All rights reserved. | <a href="#"
                        class="hover:text-white transition">Privacy Policy</a> | <a href="#"
                        class="hover:text-white transition">Terms of Use</a></p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-6 right-6 bg-primary text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script>
        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Mobile menu toggle would go here
    </script>
</body>

</html>