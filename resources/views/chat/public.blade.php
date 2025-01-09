@extends('layouts.master')
@section('title', 'Public Chat')
@section('head')
    <link rel="stylesheet" href="/css/pubchat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/pubchat.js" defer></script>
@endsection
@section('main')
    <!-- Invite Panel Toggle Button -->
    <button id="invitePanelToggle" class="fixed left-4 top-4 bg-[#fdcb6e] text-white p-2 rounded-full shadow-lg z-50">
        <i class="fas fa-user-plus"></i>
    </button>

    <!-- Invite Panel -->
    <div id="invitePanel" class="fixed left-4 top-16 bg-white p-4 rounded-lg shadow-lg z-50 w-64 hidden">
        <h3 class="text-lg font-bold text-[#fdcb6e] mb-4">Invite User</h3>
        <form id="inviteForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">User ID or Key</label>
                <input type="text" name="identifier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="Enter user ID or key">
            </div>
            <button type="submit" class="w-full bg-[#fdcb6e] text-white p-2 rounded hover:bg-[#f7b945]">
                Send Invite
            </button>
        </form>
    </div>

    <div class="flex">
        <!-- Users List -->
        <div class="w-1/4 p-4 border-r bg-white rounded-l shadow-lg">
            <h2 class="text-xl mb-4 text-[#fdcb6e]">Users</h2>
            <div id="users-list">
                @foreach ($users as $user)
                    <div class="user-item p-2 hover:bg-gray-100 cursor-pointer border-b" data-user-id="{{ $user->id }}"
                        data-user-name="{{ $user->name }} {{ $user->lastname }}">
                        <i class="fas fa-user mr-2 text-[#fdcb6e]"></i>
                        {{ $user->name }} {{ $user->lastname }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="w-3/4 p-4 bg-white rounded-r shadow-lg" id="chat-area">
            <h2 class="text-xl mb-4 text-[#fdcb6e]">Public Chat</h2>
            <div id="chat-history" class="mb-4 h-[60vh] overflow-y-auto">
                @foreach ($messages as $message)
                    <div class="message">
                        <strong>{{ $message->user->name }}:</strong>
                        <p>{{ $message->content }}</p>
                    </div>
                @endforeach
            </div>

            <form class="flex gap-4" id="chat-form">
                @csrf
                <textarea name="message" rows="3" placeholder="Press Enter to send message..."
                    class="w-full p-2 border border-gray-300 rounded-md"></textarea>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                    Send
                </button>
            </form>
        </div>
    </div>

    <!-- Notification Area -->
    <div id="notification-area" class="fixed top-4 right-4 z-50"></div>

    <!-- Embed users data in a hidden element -->
    <div id="users-data" style="display: none;">@json($users)</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('chat.status') }}")
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));

            // Example JavaScript code to dynamically add users to the user list
            const usersList = document.getElementById('users-list');
            const users = JSON.parse(document.getElementById('users-data').textContent); // Pass the users data from PHP to JavaScript

            usersList.innerHTML = ''; // Clear the current list
            users.forEach(user => {
                const userItem = document.createElement('div');
                userItem.classList.add('user-item', 'p-2', 'hover:bg-gray-100', 'cursor-pointer', 'border-b');
                userItem.dataset.userId = user.id;
                userItem.dataset.userName = `${user.name} ${user.lastname}`;
                userItem.innerHTML = `<i class="fas fa-user mr-2 text-[#fdcb6e]"></i> ${user.name} ${user.lastname}`;
                usersList.appendChild(userItem);
            });
        });
    </script>
@endsection
