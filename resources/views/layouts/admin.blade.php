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
    <script src="https://cdn.tiny.cloud/1/n0qx2b928zblbwkchy4kfs2zan8lsjwh2n2w7g4fm5pao1s3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-white shadow-lg z-50 transition-all duration-300 ease-in-out relative">
            <div class="flex flex-col items-center justify-center py-4 border-b border-white/10">
                <img src="{{ asset('images/quochuy.png') }}" alt="Logo" class="h-10 mr-2">
                <h1 class="text-xl font-bold flex items-center py-2">
                    UBND XÃ ĐẮC TÔI
                </h1>
            </div>

            <nav class="py-4">
                <div class="px-4 text-xs uppercase font-semibold mb-2 opacity-70">Quản Lý Nội Dung</div>
                <ul class="mb-4">
                    <li>
                        <a href="{{ route('admin.posts.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.posts.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-article-line mr-3 text-xl"></i>
                            Nội dung
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-folder-line mr-3 text-xl"></i>
                            Chuyên Mục
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.photo-library.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.photo-library.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-image-line mr-3 text-xl"></i>
                            Thư Viện Ảnh
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.videos.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.videos.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-video-line mr-3 text-xl"></i>
                            Video
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.rss-feeds.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.rss-feeds.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                           <i class="ri-link mr-3 text-xl"></i>
                            RSS URL
                        </a>
                    </li>
                </ul>

                <div class="px-4 text-xs uppercase font-semibold mb-2 opacity-70">Cấu Hình Trang</div>
                <ul class="mb-4">
                    <li>
                        <a href="{{ route('admin.homepage-blocks.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.homepage-blocks.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-layout-grid-line mr-3 text-xl"></i>
                            Khối Trang Chủ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.external-links.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.external-links.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-link mr-3 text-xl"></i>
                            Liên Kết
                        </a>
                    </li>
                </ul>

                <div class="px-4 text-xs uppercase font-semibold mb-2 opacity-70">Quản Trị</div>
                <ul>
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-6 py-3 hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
                            <i class="ri-user-line mr-3 text-xl"></i>
                            Người Dùng
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