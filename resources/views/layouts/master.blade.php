<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @yield('head')
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body x-data="{
    menuOpen: false,
    chatDropdown: false,
    camDropdown: false
}" class="flex h-screen bg-gray-100">

    <div class="flex flex-col w-full min-h-screen">
        <header>
            @yield('header')
        </header>

        <!-- Main content wrapper -->
        <div class="flex-grow" :class="{ 'mr-[20%]': menuOpen, 'mr-0': !menuOpen }"
            style="transition: margin-right 0.3s ease;">
            <main>
                @yield('main')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-[#fdcb6e] text-white" :class="{ 'mr-[20%]': menuOpen, 'mr-0': !menuOpen }"
            style="transition: margin-right 0.3s ease;">
            @yield('footer')
            <div class="text-center py-2">
                <p x-data="{ year: new Date().getFullYear() }">
                    © <span x-text="year"></span> ChatMe | All Rights Reserved
                </p>
            </div>
        </footer>
    </div>

    <!-- Sidebar -->
    <div class="fixed right-0 top-0 h-full z-50 transition-all duration-300"
        :class="{ 'w-[20%]': menuOpen, 'w-0': !menuOpen }">
        <!-- Hamburger Menu Button -->
        <button @click="menuOpen = !menuOpen"
            class="absolute left-[-40px] top-4 bg-[#eb2f06] text-white px-2 py-1 rounded-l-md flex flex-col space-y-1">
            <span class="w-6 h-0.5 bg-white"></span>
            <span class="w-6 h-0.5 bg-white"></span>
            <span class="w-6 h-0.5 bg-white"></span>
        </button>

        <!-- Menu -->
        <div class="bg-[#eb2f06] text-white h-full w-full overflow-y-auto" x-show="menuOpen" x-transition>
            <ul class="space-y-4 mt-6 px-4">
                <li class="text-xl py-2 hover:bg-white hover:text-[#eb2f06] rounded-md">
                    <a href="/home" class="block px-4">Home</a>
                </li>

                <!-- Chat Dropdown -->
                <li class="text-xl" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full text-left hover:bg-white hover:text-[#eb2f06] py-2 px-4 rounded-md flex justify-between items-center">
                        <span>Chat</span>
                        <span x-show="!open">▼</span>
                        <span x-show="open">▲</span>
                    </button>
                    <ul x-show="open" class="mt-2 mr-4 space-y-2">
                        <li class="hover:bg-white hover:text-[#eb2f06] rounded-md">
                            <a href="{{ route('chat.public') }}" class="block px-4 py-2">Global Chat</a>
                        </li>
                        <li class="hover:bg-white hover:text-[#eb2f06] rounded-md">
                            <a href="/private-chat" class="block px-4 py-2">Private Chat</a>
                        </li>
                    </ul>
                </li>

                <!-- Cam Dropdown -->
                <li class="text-xl" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full text-left hover:bg-white hover:text-[#eb2f06] py-2 px-4 rounded-md flex justify-between items-center">
                        <span>Cam</span>
                        <span x-show="!open">▼</span>
                        <span x-show="open">▲</span>
                    </button>
                    <ul x-show="open" class="mt-2 mr-4 space-y-2">
                        <li class="hover:bg-white hover:text-[#eb2f06 rounded-md">
                            <a href="/global-cam" class="block px-4 py-2">Global Cam</a>
                        </li>
                        <li class="hover:bg-white hover:text-[#eb2f06] rounded-md">
                            <a href="/private-cam" class="block px-4 py-2">Private Cam</a>
                        </li>
                    </ul>
                </li>

                <li class="text-xl py-2 hover:bg-white hover:text-[#eb2f06] rounded-md">
                    <a href="/music" class="block px-4">Music</a>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>
