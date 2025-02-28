<div class="header-container bg-primary">
    <div class="flex items-center justify-between bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('images/trongdong.png') }}')">
        <div class="w-[1200px] mx-auto px-4 md:px-0 flex items-center justify-between relative">
            <div class="header-left flex items-center py-4 rounded-lg w-full">
                <div class="logo mr-4">
                    <img src="{{ asset('images/quochuy.png') }}" alt="Quốc Huy" class="h-[40px] md:h-[80px] w-auto">
                </div>
                <div class="header-text flex-grow">
                    <div class="text-[10px] md:text-sm font-bold text-white font-nunito uppercase">
                        Ủy Ban Nhân Dân Huyện Nam Giang
                    </div>
                    <div class="text-[12px] md:text-3xl font-bold text-white uppercase font-merriweather leading-tight">
                        Trang Thông Tin Điện Tử Xã Chà Vàl
                    </div>
                </div>
                
                <!-- Mobile Menu Toggle - Moved to this position -->
                <div x-data="{ mobileMenuOpen: false }" class="md:hidden ml-auto">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Mobile Slide-out Menu -->
                    <div x-show="mobileMenuOpen" 
                         x-transition:enter="transform transition ease-in-out duration-300" 
                         x-transition:enter-start="translate-x-full" 
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300" 
                         x-transition:leave-start="translate-x-0" 
                         x-transition:leave-end="translate-x-full"
                         class="fixed inset-y-0 right-0 w-full bg-white shadow-lg z-50 transform transition-transform duration-300 ease-in-out">
                        <div class="p-4 h-full flex flex-col">
                            <div class="flex justify-between items-center mb-6">
                                <div class="header-text">
                                    <div class="text-[10px] font-bold text-primary font-nunito uppercase">
                                        Ủy Ban Nhân Dân Huyện Nam Giang
                                    </div>
                                    <div class="text-[12px] font-bold text-primary uppercase font-merriweather leading-tight">
                                        Trang Thông Tin Điện Tử Xã Chà Vàl
                                    </div>
                                </div>
                                <button @click="mobileMenuOpen = false" class="text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex-grow">
                                <div class="space-y-4 mb-6">
                                    <h3 class="text-sm font-bold text-primary uppercase border-b pb-2">Danh Mục</h3>
                                    <div class="flex flex-col space-y-3">
                                        <a href="{{ route('home') }}" class="text-gray-700 tracking-wider {{ request()->routeIs('home') ? 'text-primary font-bold' : '' }}">Trang Chủ</a>
                                        <div x-data="{ isMediaOpen: false }">
                                            <a href="#" @click.prevent="isMediaOpen = !isMediaOpen" 
                                               class="text-gray-700 tracking-wider flex items-center justify-between {{ request()->is('gioi-thieu') ? 'text-primary font-bold' : '' }}">
                                                Giới thiệu
                                                <svg x-bind:class="{'rotate-180': isMediaOpen}" class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </a>
                                            <div x-show="isMediaOpen" x-collapse class="pl-4 space-y-3 mt-2">
                                                <a href="{{ route('posts.show', 'gioi-thieu-chung') }}" class="block text-gray-700 tracking-wider {{ 
                                                    request()->is('posts/gioi-thieu-chung') ? 'text-primary font-bold' : '' }}">
                                                    Giới Thiệu chung
                                                </a>
                                                <a href="{{ route('categories.show', 'dan-so-dia-gioi-hanh-chinh') }}" class="block text-gray-700 tracking-wider {{ 
                                                    request()->is('categories/dan-so-dia-gioi-hanh-chinh') ? 'text-primary font-bold' : '' }}">
                                                    Dân Số - Địa Giới Hành Chính
                                                </a>
                                                <a href="{{ route('posts.show', 'co-cau-to-chuc') }}" class="block text-gray-700 tracking-wider {{ 
                                                    request()->is('posts/co-cau-to-chuc') ? 'text-primary font-bold' : '' }}">
                                                    Cơ Cấu Tổ Chức
                                                </a>
                                                <a href="{{ route('categories.show', 'cac-di-tich-dia-diem-tham-quan') }}" class="block text-gray-700 tracking-wider {{ 
                                                    request()->is('categories/cac-di-tich-dia-diem-tham-quan') ? 'text-primary font-bold' : '' }}">
                                                    Các Di Tích - Địa Điểm Tham Quan
                                                </a>
                                            </div>
                                        </div>
                                        <a href="{{ route('categories.show', 'tin-tuc-su-kien') }}" class="text-gray-700 tracking-wider {{ 
                                            request()->is('categories/tin-tuc-su-kien') || 
                                            (isset($category) && $category->slug == 'tin-tuc-su-kien') 
                                            ? 'text-primary font-bold' : '' }}">Tin Tức Sự Kiện</a>
                                        <a href="{{ route('categories.show', 'quy-hoach-phat-trien') }}" class="text-gray-700 tracking-wider {{ 
                                            request()->is('categories/quy-hoach-phat-trien') || 
                                            (isset($category) && $category->slug == 'quy-hoach-phat-trien') 
                                            ? 'text-primary font-bold' : '' }}">Quy hoạch và phát triển</a>
                                        <a href="{{ route('categories.show', 'chi-dao-dieu-hanh') }}" class="text-gray-700 tracking-wider {{ 
                                            request()->is('categories/chi-dao-dieu-hanh') || 
                                            (isset($category) && $category->slug == 'chi-dao-dieu-hanh') 
                                            ? 'text-primary font-bold' : '' }}">Chỉ Đạo Điều Hành</a>
                                        <a href="{{ route('categories.show', 'van-ban') }}" class="text-gray-700 tracking-wider {{ 
                                            request()->is('categories/van-ban') || 
                                            (isset($category) && $category->slug == 'van-ban') 
                                            ? 'text-primary font-bold' : '' }}">Văn Bản</a>
                                        <div x-data="{ isMediaOpen: false }">
                                            <a href="#" @click.prevent="isMediaOpen = !isMediaOpen" 
                                               class="text-gray-700 tracking-wider flex items-center justify-between {{ 
                                                   request()->is('videos*') || request()->is('photo-library*') 
                                                   ? 'text-primary font-bold' : '' }}">
                                                Media
                                                <svg x-bind:class="{'rotate-180': isMediaOpen}" class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </a>
                                            <div x-show="isMediaOpen" x-collapse class="pl-4 space-y-3 mt-2">
                                                <a href="{{ route('videos.index') }}" class="block text-gray-700 tracking-wider {{ 
                                                    request()->is('videos*') ? 'text-primary font-bold' : '' }}">
                                                    Video
                                                </a>
                                                <a href="{{ route('photo-library.index') }}" class="block text-gray-700 tracking-wider {{ 
                                                    request()->is('photo-library*') ? 'text-primary font-bold' : '' }}">
                                                    Thư Viện Ảnh
                                                </a>
                                            </div>
                                        </div>
                                        <a href="{{ route('contact.index') }}" class="text-gray-700 tracking-wider {{ request()->routeIs('contact.index') ? 'text-primary font-bold' : '' }}">
                                            Liên Hệ
                                        </a>
                                    </div>
                                </div>

                                <div class="space-y-4 mb-6">
                                    <h3 class="text-sm font-bold text-primary uppercase border-b pb-2">Tiện Ích</h3>
                                    <div class="flex flex-col space-y-3">
                                        <a href="{{ route('sitemap') }}" class="text-gray-700 tracking-wider flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 13l-6-3"></path>
                                            </svg>
                                            Sơ Đồ Cổng
                                        </a>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="text-sm font-bold text-primary uppercase border-b pb-2">Tìm Kiếm</h3>
                                    <form action="{{ route('search') }}" method="GET" class="flex">
                                        <input type="text" 
                                            name="query" 
                                            placeholder="Nhập từ khóa tìm kiếm..." 
                                            class="flex-grow px-3 py-2 text-sm border border-primary-300 rounded-l-lg font-nunito focus:ring-primary-500 focus:border-primary-500">
                                        <button type="submit" 
                                                class="bg-primary text-white px-4 py-2 text-sm rounded-r-lg font-nunito hover:bg-primary-600">
                                            Tìm
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="header-right hidden md:flex flex-col items-end space-y-2">
                <a href="{{ route('sitemap') }}" class="btn px-3 py-1 text-xs rounded-full text-white border border-white hover:bg-white hover:text-primary transition duration-300 font-nunito uppercase tracking-wider whitespace-nowrap overflow-hidden text-ellipsis">
                    Sơ Đồ Cổng
                </a>
                <div x-data="{ isSearchOpen: false }" class="relative">
                    <button @click="isSearchOpen = !isSearchOpen" class="btn px-3 py-1 text-xs rounded-full text-white border border-white hover:bg-white hover:text-primary transition duration-300 font-nunito uppercase tracking-wider whitespace-nowrap overflow-hidden text-ellipsis">
                        Tìm Kiếm
                    </button>
                    
                    <div x-show="isSearchOpen" 
                        x-transition 
                        @click.outside="isSearchOpen = false"
                        class="absolute right-0 top-full mt-2 w-80 bg-white shadow-lg rounded-lg p-4 z-50">
                        <form action="{{ route('search') }}" method="GET" class="flex">
                            <input type="text" 
                                name="query" 
                                placeholder="Nhập từ khóa tìm kiếm..." 
                                class="flex-grow px-3 py-2 text-base border border-primary-300 rounded-l-lg font-nunito focus:ring-primary-500 focus:border-primary-500">
                            <button type="submit" 
                                    class="bg-primary text-white px-4 py-2 text-base rounded-r-lg font-nunito hover:bg-primary-600">
                                Tìm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Menu - Desktop Only -->
    <nav class="bg-white border-b-4 border-[#f2f2f2] hidden md:block">
        <div class="w-[1200px] mx-auto flex justify-between items-center">
            <ul class="flex space-x-6 relative py-3">
                <li class="group">
                    <a href="{{ route('home') }}" class="text-primary tracking-wider relative group {{ request()->routeIs('home') ? 'active-menu-item' : '' }}">
                        Trang Chủ
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('home') ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                </li>
                <li class="group relative">
                    <a href="#" class="text-primary tracking-wider relative group {{ 
                        request()->is('categories/gioi-thieu*') 
                        ? 'active-menu-item' : '' }}">
                        Giới Thiệu
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ 
                            request()->is('categories/gioi-thieu*') ? 'scale-x-100' : '' }} 
                            transition-transform duration-300 origin-left"></span>
                    </a>
                    <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-lg py-2 px-4 z-50 top-full left-0 min-w-[300px] mt-4 
                        before:absolute before:top-[-20px] before:left-0 before:w-full before:h-[20px] before:bg-transparent">
                        <a href="{{ route('posts.show', 'gioi-thieu-chung') }}" class="block py-2 text-gray-700 hover:text-primary {{ 
                            request()->is('posts/gioi-thieu-chung') ? 'text-primary font-bold' : '' }}">
                            Giới Thiệu Chung
                        </a>
                        <a href="{{ route('categories.show', 'dan-so-dia-gioi-hanh-chinh') }}" class="block py-2 text-gray-700 hover:text-primary {{ 
                            request()->is('categories/dan-so-dia-gioi-hanh-chinh') ? 'text-primary font-bold' : '' }}">
                            Dân Số - Địa Giới Hành Chính
                        </a>
                        <a href="{{ route('posts.show', 'co-cau-to-chuc') }}" class="block py-2 text-gray-700 hover:text-primary {{ 
                            request()->is('posts/co-cau-to-chuc') ? 'text-primary font-bold' : '' }}">
                            Cơ Cấu Tổ Chức
                        </a>
                        <a href="{{ route('categories.show', 'cac-di-tich-dia-diem-tham-quan') }}" class="block py-2 text-gray-700 hover:text-primary {{ 
                            request()->is('categories/cac-di-tich-dia-diem-tham-quan') ? 'text-primary font-bold' : '' }}">
                            Các Di Tích - Địa Điểm Tham Quan
                        </a>
                    </div>
                </li>
                <li class="group">
                    <a href="{{ route('categories.show', 'tin-tuc-su-kien') }}" class="text-primary tracking-wider relative group {{ 
                        request()->is('categories/tin-tuc-su-kien') || 
                        (isset($category) && $category->slug == 'tin-tuc-su-kien') 
                        ? 'active-menu-item' : '' }}">
                        Tin Tức Sự Kiện
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ 
                            request()->is('categories/tin-tuc-su-kien') || 
                            (isset($category) && $category->slug == 'tin-tuc-su-kien') 
                            ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                </li>
                <li class="group">
                    <a href="{{ route('categories.show', 'quy-hoach-phat-trien') }}" class="text-primary tracking-wider relative group {{ 
                        request()->is('categories/quy-hoach-phat-trien') || 
                        (isset($category) && $category->slug == 'quy-hoach-phat-trien') 
                        ? 'active-menu-item' : '' }}">
                        Quy Hoạch Và Phát Triển
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ 
                            request()->is('categories/quy-hoach-phat-trien') || 
                            (isset($category) && $category->slug == 'quy-hoach-phat-trien') 
                            ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                </li>
                <li class="group">
                    <a href="{{ route('categories.show', 'chi-dao-dieu-hanh') }}" class="text-primary tracking-wider relative group {{ 
                        request()->is('categories/chi-dao-dieu-hanh') || 
                        (isset($category) && $category->slug == 'chi-dao-dieu-hanh') 
                        ? 'active-menu-item' : '' }}">
                        Chỉ Đạo Điều Hành
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ 
                            request()->is('categories/chi-dao-dieu-hanh') || 
                            (isset($category) && $category->slug == 'chi-dao-dieu-hanh') 
                            ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                </li>
                <li class="group">
                    <a href="{{ route('categories.show', 'van-ban') }}" class="text-primary tracking-wider relative group {{ 
                        request()->is('categories/van-ban') || 
                        (isset($category) && $category->slug == 'van-ban') 
                        ? 'active-menu-item' : '' }}">
                        Văn Bản
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ 
                            request()->is('categories/van-ban') || 
                            (isset($category) && $category->slug == 'van-ban') 
                            ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                </li>
                <li class="group relative">
                    <a href="#" class="text-primary tracking-wider relative group {{ 
                        request()->is('videos*') || request()->is('photo-library*') 
                        ? 'active-menu-item' : '' }}">
                        Media
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ 
                            request()->is('videos*') || request()->is('photo-library*') 
                            ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                    <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-lg py-2 px-4 z-50 top-full left-0 min-w-[200px] mt-4 
                        before:absolute before:top-[-20px] before:left-0 before:w-full before:h-[20px] before:bg-transparent">
                        <a href="{{ route('videos.index') }}" class="block py-2 text-gray-700 hover:text-primary {{ 
                            request()->is('videos*') ? 'text-primary font-bold' : '' }}">
                            Video
                        </a>
                        <a href="{{ route('photo-library.index') }}" class="block py-2 text-gray-700 hover:text-primary {{ 
                            request()->is('photo-library*') ? 'text-primary font-bold' : '' }}">
                            Thư Viện Ảnh
                        </a>
                    </div>
                </li>
                <li class="group">
                    <a href="{{ route('contact.index') }}" class="text-primary tracking-wider relative group {{ request()->routeIs('contact.index') ? 'active-menu-item' : '' }}">
                        Liên Hệ
                        <span class="absolute bottom-[-14px] left-0 w-full h-[2px] bg-primary transform scale-x-0 group-hover:scale-x-100 {{ request()->routeIs('contact.index') ? 'scale-x-100' : '' }} transition-transform duration-300 origin-left"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

        <!-- Header with date, scrolling news, and weather -->
        <div class="bg-[#f9f9f9]">
        <div class="p-2 w-full max-w-[1200px] mx-auto">
            @php
                $thongBaoCategory = \App\Models\Category::where('slug', 'thong-bao')->first();
                $thongBaoPosts = $thongBaoCategory ? $thongBaoCategory->posts()->take(5)->get() : [];
            @endphp
            @if(!empty($thongBaoPosts))
                <div class="flex items-center justify-between text-sm">
                    <!-- Date and Time -->
                    <div class="flex items-center space-x-2 flex-shrink-0">
                        <i class="fas fa-calendar text-blue-600"></i>
                        <span id="current-date-time">
                            {{ \Carbon\Carbon::now()->locale('vi')->isoFormat('dddd, DD/MM/YYYY HH:mm:ss') }}
                        </span>
                    </div>

                    <!-- Scrolling News Ticker -->
                    <div class="news-ticker-container relative overflow-hidden flex-grow mx-4 h-6 hidden md:block">
                        <div class="news-ticker-wrapper absolute left-0 whitespace-nowrap">
                            <div class="news-ticker inline-block">
                                @foreach($thongBaoPosts as $post)
                                    <span class="news-ticker-item mx-4 text-gray-700">
                                        <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="hover:text-blue-600 transition-colors duration-300">
                                            • {{ $post->title }}
                                        </a>
                                    </span>
                                @endforeach
                                @foreach($thongBaoPosts as $post)
                                    <span class="news-ticker-item mx-4 text-gray-700">
                                        <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="hover:text-blue-600 transition-colors duration-300">
                                            • {{ $post->title }}
                                        </a>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                  <!-- Weather -->
                    <div class="flex items-center space-x-2 flex-shrink-0">
                        @php
                            $weatherService = new \App\Services\WeatherService();
                            $weather = $weatherService->getCurrentWeather();
                        @endphp
                        @if($weather)
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 0 0 4 4h9a5 5 0 1 0 -0.1 -9.999 5.002 5.002 0 1 0 -9.878 -2.492 4.501 4.501 0 0 0 -2.02 7.491z"></path>
                            </svg>
                            <span>Nam Giang: {{ $weather['temperature'] }}°C</span>
                        @else
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 0 0 4 4h9a5 5 0 1 0 -0.1 -9.999 5.002 5.002 0 1 0 -9.878 -2.492 4.501 4.501 0 0 0 -2.02 7.491z"></path>
                            </svg>
                            <span>Thời tiết không khả dụng</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .news-ticker-container {
        position: relative;
        overflow: hidden;
        width: 100%;
    }
    .news-ticker-wrapper {
        display: inline-block;
        white-space: nowrap;
        will-change: transform;
    }
    .news-ticker {
        display: inline-block;
        padding-left: 100%;
    }
    .news-ticker-item {
        display: inline-block;
        padding: 0 2rem;
    }
    @media (max-width: 768px) {
        .news-ticker-container {
            display: none; /* Hide news ticker on mobile */
        }
    }
    @keyframes ticker {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-100%);
        }
    }
    .news-ticker {
        display: inline-flex;
        animation: ticker 20s linear infinite;
    }
    .news-ticker-container:hover .news-ticker {
        animation-play-state: paused;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tickerContainer = document.querySelector('.news-ticker-container');
        const ticker = document.querySelector('.news-ticker');

        function animateTicker() {
            let position = 0;
            const tickerWidth = ticker.offsetWidth / 2;
            let isPaused = false;

            function step() {
                if (!isPaused) {
                    position -= 0.5; // Slower speed
                    if (Math.abs(position) >= tickerWidth / 2) {
                        position = 0;
                    }
                    ticker.style.transform = `translateX(${position}px)`;
                }
                requestAnimationFrame(step);
            }

            requestAnimationFrame(step);

            // Pause on hover
            tickerContainer.addEventListener('mouseenter', () => {
                isPaused = true;
            });

            tickerContainer.addEventListener('mouseleave', () => {
                isPaused = false;
            });

            // Prevent pause when hovering links
            const tickerLinks = ticker.querySelectorAll('a');
            tickerLinks.forEach(link => {
                link.addEventListener('mouseenter', (e) => {
                    e.stopPropagation();
                    isPaused = true;
                });
                link.addEventListener('mouseleave', (e) => {
                    e.stopPropagation();
                    isPaused = false;
                });
            });
        }

        animateTicker();
    });
</script>
<script>
    function updateDateTime() {
        const dateTimeElement = document.getElementById('current-date-time');
        const now = new Date();
        const options = { 
            weekday: 'long', 
            day: '2-digit', 
            month: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        dateTimeElement.textContent = now.toLocaleString('vi-VN', options);
    }
    
    // Update time every second
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
@endpush