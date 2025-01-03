@extends('layouts.master')
@section('head')
    <title>ChatMe - Connect Globally, Stay Private</title>
    <link rel="stylesheet" href="/css/home.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('header')
    <h1 class="text-4xl font-bold text-[#fdcb6e] text-center py-8">Welcome to ChatMe</h1>
@endsection

@section('main')
    <div class="container mx-auto px-4 py-8 transition-all duration-300">
        <!-- Hero Section -->
        {{-- Place a welcoming image here showing people connecting globally --}}
        <div>
            <img src="{{ asset('asset/images/6238849.jpg') }}" alt="Global Connection"
                class="w-full rounded-lg shadow-lg mb-8">
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-[#fdcb6e] mb-4">Connect With The World</h2>
            <p class="text-gray-700">Join our growing community of global citizens connecting securely without data storage
                concerns.</p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-[#fdcb6e]">
                <i class="fas fa-comments text-[#fdcb6e] text-3xl mb-3"></i>
                <h3 class="text-xl font-semibold mb-3">Global Chat</h3>
                <p class="text-gray-600">Connect with people from all corners of the world in our public chat rooms.</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-[#fdcb6e]">
                <i class="fas fa-envelope text-[#fdcb6e] text-3xl mb-3"></i>
                <h3 class="text-xl font-semibold mb-3">Private Messages</h3>
                <p class="text-gray-600">Have secure, private conversations with friends and family.</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-[#fdcb6e]">
                <i class="fas fa-video text-[#fdcb6e] text-3xl mb-3"></i>
                <h3 class="text-xl font-semibold mb-3">Global Cam</h3>
                <p class="text-gray-600">Meet new people face-to-face through our secure video platform.</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-[#fdcb6e]">
                <i class="fas fa-users text-[#fdcb6e] text-3xl mb-3"></i>
                <h3 class="text-xl font-semibold mb-3">Private Video Sessions</h3>
                <p class="text-gray-600">Schedule private video calls with your loved ones.</p>
            </div>
        </div>
    </div>
@endsection
