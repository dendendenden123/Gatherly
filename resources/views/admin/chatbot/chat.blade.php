@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/chat.css') }}" rel="stylesheet">
@endsection

@section('header')
<!-- Header -->
<header>
    <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="page-tite">
            <h1 class="text-xl font-semibold text-gray-900">AI Chat Assistant</h1>
            <p class="text-gray-500">
                Ask anything about the system — from member statistics to recent reports. Get instant, accurate
                insights.
            </p>

        </div>
        <div class="flex items-center space-x-4">

        </div>

    </div>
</header>
@endSection

@section('content')
    <div id="chat-box">
        <div class="welcome-msg">
            <i class="fas fa-robot"></i>
            <p>Hello! I'm your AI assistant. How can I help you today?</p> <br>
            <p> This AI make mistakes. Its responses are for informational purposes only and do not
                represent
                official church statements.</p>
        </div>
    </div>

    <div class="typing-indicator" id="typing">
        <span class="typing-dots">
            AI is typing <span>.</span><span>.</span><span>.</span>
        </span>
    </div>

    <div class="input-area">
        <input id="message" type="text" placeholder="Type a message..." autocomplete="off" />
        <button id="send">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>

    @vite("resources/js/chat.js")
@endsection