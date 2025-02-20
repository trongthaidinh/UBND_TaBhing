<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Trang Quản Trị') - {{ config('app.name', 'UBND Website') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg z-50 transition-all duration-300 ease-in-out">
            <div class="flex items-center justify-center h-16 border-b">
                <h1 class="text-2xl font-bold text-primary">UBND Admin</h1>
            </div>

            <nav class="py-4">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-dashboard-line mr-3 text-xl"></i>
                            Bảng điều khiển
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.posts.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-article-line mr-3 text-xl"></i>
                            Quản lý Bài viết
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-folder-line mr-3 text-xl"></i>
                            Quản lý Chuyên mục
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.homepage-blocks.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.homepage-blocks.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-layout-grid-line mr-3 text-xl"></i>
                            Quản lý Khối Trang Chủ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-user-line mr-3 text-xl"></i>
                            Quản lý Người dùng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.photo-library.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.photo-library.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-image-line mr-3 text-xl"></i>
                            Quản lý Thư viện Ảnh
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.videos.index') }}" 
                        class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.videos.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-video-line mr-3 text-xl"></i>
                            Quản lý Video
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.external-links.index') }}" 
                        class="flex items-center px-6 py-3 hover:bg-gray-100 {{ request()->routeIs('admin.external-links.*') ? 'bg-gray-100 text-primary' : 'text-gray-700' }}">
                            <i class="ri-link mr-3 text-xl"></i>
                            Quản lý Liên Kết
                        </a>
                    </li>
                    <li class="border-t mt-4 pt-4">
                        <a href="{{ route('home') }}" 
                           class="flex items-center px-6 py-3 hover:bg-gray-100 text-gray-700">
                            <i class="ri-home-4-line mr-3 text-xl"></i>
                            Về Trang chủ
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-md h-16 flex items-center justify-between px-6">
                <div class="flex items-center">
                    <button id="toggleSidebar" class="mr-4 text-gray-600 hover:text-primary">
                        <i class="ri-menu-line text-2xl"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">@yield('page_title')</h2>
                </div>

                <!-- User Dropdown -->
                <div class="relative">
                    <button id="userDropdownToggle" class="flex items-center space-x-2 text-primary hover:text-primary-dark group">
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                        <i class="ri-arrow-down-s-line text-primary group-hover:rotate-180 transition-transform"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-primary hover:text-primary-dark rounded-lg transition">
                                <i class="ri-logout-box-r-line mr-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Existing JavaScript, just modify the dropdown part -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const userDropdownToggle = document.getElementById('userDropdownToggle');
                    const userDropdownMenu = document.getElementById('userDropdownMenu');

                    userDropdownToggle.addEventListener('click', function(event) {
                        event.stopPropagation();
                        userDropdownMenu.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!userDropdownToggle.contains(event.target)) {
                            userDropdownMenu.classList.add('hidden');
                        }
                    });
                });
            </script>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar and Dropdown Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('aside');
            const toggleButton = document.getElementById('toggleSidebar');

            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            // User Dropdown Toggle
            const userDropdownBtn = document.querySelector('[class*="user-dropdown"]');
            const userDropdownMenu = userDropdownBtn?.nextElementSibling;

            userDropdownBtn?.addEventListener('click', function() {
                userDropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userDropdownBtn?.contains(event.target)) {
                    userDropdownMenu?.classList.add('hidden');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>