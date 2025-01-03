@extends('layouts.master')
@section('title', 'Public Chat')
@section('head')
    <link rel="stylesheet" href="/css/pubchat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/pubchat.js" defer></script>
@endsection
@section('main')
    <div class="w-3/4 p-4">
        <h2 class="text-xl mb-4">Public Chat</h2>

        <!-- تاریخچه چت (شما باید از دیتابیس برای نمایش این‌ها استفاده کنید) -->
        <div id="chat-history" class="mb-4">
            <!-- چت‌ها در اینجا نمایش داده می‌شود -->
            @foreach ($messages as $message)
                <div class="message">
                    <strong>{{ $message->user->name }}:</strong>
                    <p>{{ $message->content }}</p>
                </div>
            @endforeach
        </div>

        <!-- فرم ارسال پیام -->
        <form class="flex gap-4" id="chat-form">
            @csrf
            <textarea name="message" rows="3" placeholder="Press Enter to send message..."
                class="w-full p-2 border border-gray-300 rounded-md"></textarea>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                Send
            </button>
        </form>
    </div>
@endsection
