<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Grace Community Church</title>
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
    <style>
        .chat-container {
            height: calc(100vh - 200px);
        }

        .conversation-list {
            height: calc(100% - 60px);
        }

        .message-container {
            height: calc(100% - 120px);
        }

        .unread-dot {
            width: 10px;
            height: 10px;
            background-color: #e74c3c;
            border-radius: 50%;
            display: inline-block;
        }

        .message-bubble {
            max-width: 70%;
        }

        .sent {
            background-color: #2ecc71;
            color: white;
            border-radius: 18px 18px 0 18px;
        }

        .received {
            background-color: #f3f4f6;
            color: #111827;
            border-radius: 18px 18px 18px 0;
        }

        .typing-indicator span {
            height: 8px;
            width: 8px;
            background-color: #9ca3af;
            border-radius: 50%;
            display: inline-block;
            animation: bounce 1.5s infinite ease-in-out;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900">Messages</h1>
                <div>
                    <a href="{{ route('member') }}"
                        class="text-gray-600 hover:text-gray-900 mr-4 hidden md:inline-block">
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    </a>
                    <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm">
                        <i class="bi bi-pencil-square mr-1"></i> New Message
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden chat-container flex">
                <!-- Conversations List -->
                <div class="w-1/3 border-r border-gray-200 flex flex-col">
                    <div class="p-4 border-b border-gray-200">
                        <div class="relative">
                            <input type="text" placeholder="Search conversations..."
                                class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 focus:ring-primary focus:border-primary">
                            <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="overflow-y-auto conversation-list">
                        <!-- Conversation 1 -->
                        <div class="p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer flex items-center">
                            <div class="relative mr-3">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                    alt="Pastor John" class="w-12 h-12 rounded-full object-cover">
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium">Pastor John Smith</h3>
                                    <span class="text-xs text-gray-500">2h ago</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Thanks for your prayer request, we'll be
                                    praying for...</p>
                            </div>
                        </div>

                        <!-- Conversation 2 (Unread) -->
                        <div
                            class="p-4 border-b border-gray-200 bg-primary bg-opacity-5 cursor-pointer flex items-center">
                            <div class="relative mr-3">
                                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                    alt="Michael Johnson" class="w-12 h-12 rounded-full object-cover">
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium flex items-center">
                                        Michael Johnson
                                        <span class="unread-dot ml-2"></span>
                                    </h3>
                                    <span class="text-xs text-gray-500">Yesterday</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Are you available to help with the food drive
                                    this...</p>
                            </div>
                        </div>

                        <!-- Conversation 3 -->
                        <div class="p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer flex items-center">
                            <div class="relative mr-3">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                    alt="Emily Davis" class="w-12 h-12 rounded-full object-cover">
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium">Emily Davis</h3>
                                    <span class="text-xs text-gray-500">Jun 10</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Here are the worship lyrics for Sunday's
                                    service...</p>
                            </div>
                        </div>

                        <!-- Conversation 4 -->
                        <div class="p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer flex items-center">
                            <div class="relative mr-3">
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="bi bi-people text-purple-600 text-xl"></i>
                                </div>
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium">Men's Bible Study</h3>
                                    <span class="text-xs text-gray-500">Jun 8</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Robert: I'll bring the breakfast casserole
                                    this week</p>
                            </div>
                        </div>

                        <!-- Conversation 5 -->
                        <div class="p-4 hover:bg-gray-50 cursor-pointer flex items-center">
                            <div class="relative mr-3">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="bi bi-chat-square-text text-blue-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium">Church Announcements</h3>
                                    <span class="text-xs text-gray-500">Jun 5</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Reminder: VBS volunteer meeting this Wednesday
                                    at...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="w-2/3 flex flex-col">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200 flex items-center">
                        <div class="relative mr-3">
                            <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                alt="Michael Johnson" class="w-12 h-12 rounded-full object-cover">
                            <span
                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium">Michael Johnson</h3>
                            <p class="text-sm text-gray-500">Small Group Leader</p>
                        </div>
                        <div class="flex space-x-3 text-gray-500">
                            <button class="hover:text-primary">
                                <i class="bi bi-telephone"></i>
                            </button>
                            <button class="hover:text-primary">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-4 message-container bg-gray-100">
                        <!-- Date divider -->
                        <div class="flex items-center justify-center my-4">
                            <div class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">
                                Today
                            </div>
                        </div>

                        <!-- Received message -->
                        <div class="flex mb-4">
                            <div class="mr-3">
                                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                    alt="Michael Johnson" class="w-8 h-8 rounded-full object-cover">
                            </div>
                            <div class="message-bubble received p-3">
                                <p>Hi there! Are you available to help with the food drive this Saturday from 9am-12pm?
                                </p>
                                <p class="text-xs text-gray-500 mt-1">10:32 AM</p>
                            </div>
                        </div>

                        <!-- Sent message -->
                        <div class="flex justify-end mb-4">
                            <div class="message-bubble sent p-3">
                                <p>Let me check my calendar and get back to you. What exactly would I be helping with?
                                </p>
                                <p class="text-xs text-white text-opacity-80 mt-1">10:35 AM <i
                                        class="bi bi-check2-all ml-1"></i></p>
                            </div>
                        </div>

                        <!-- Received message -->
                        <div class="flex mb-4">
                            <div class="mr-3">
                                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                    alt="Michael Johnson" class="w-8 h-8 rounded-full object-cover">
                            </div>
                            <div class="message-bubble received p-3">
                                <p>We need help organizing donations and assisting families as they come through. It
                                    would be great to have you on the team!</p>
                                <p class="text-xs text-gray-500 mt-1">10:37 AM</p>
                            </div>
                        </div>

                        <!-- Typing indicator -->
                        <div class="flex mb-4">
                            <div class="mr-3">
                                <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&q=80"
                                    alt="Michael Johnson" class="w-8 h-8 rounded-full object-cover">
                            </div>
                            <div class="typing-indicator p-3 bg-gray-200 rounded-full">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <button class="text-gray-500 hover:text-primary mr-2">
                                <i class="bi bi-paperclip text-xl"></i>
                            </button>
                            <input type="text" placeholder="Type a message..."
                                class="flex-1 border border-gray-300 rounded-full py-2 px-4 focus:ring-primary focus:border-primary">
                            <button class="ml-2 bg-primary hover:bg-secondary text-white p-2 rounded-full">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Simple functionality for demonstration
        document.querySelectorAll('.conversation-list > div').forEach(conv => {
            conv.addEventListener('click', function () {
                // In a real app, this would load the selected conversation
                document.querySelector('.chat-container .font-medium').textContent =
                    this.querySelector('.font-medium').textContent;

                // Update the avatar
                const avatar = this.querySelector('img') || this.querySelector('.bi-people');
                const chatAvatar = document.querySelector('.chat-container img');
                if (avatar) {
                    if (avatar.tagName === 'IMG') {
                        chatAvatar.src = avatar.src;
                        chatAvatar.alt = avatar.alt;
                    } else {
                        // Handle group icons
                        chatAvatar.src = '';
                        chatAvatar.className = avatar.className;
                        chatAvatar.parentElement.className = avatar.parentElement.className;
                    }
                }

                // Mark as read
                this.querySelector('.unread-dot')?.remove();
                this.classList.remove('bg-primary bg-opacity-5');
                this.classList.add('hover:bg-gray-50');
            });
        });
    </script>
</body>

</html>