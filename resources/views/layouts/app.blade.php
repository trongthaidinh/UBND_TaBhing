<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Trang Chủ') - {{ config('app.name', 'UBND Xã Tà Bhing') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-repeat" style="background-image: url('{{ asset('images/bgcontent.jpg') }}');">
        <div class="min-h-screen">
            <div class="mx-auto">
                <!-- Custom Header -->
                @include('layouts.header')

                <div class="bg-white max-w-[1200px] px-0 lg:px-4 mx-auto">
                    <!-- Slider Section (only on home page) -->
                    @if(request()->routeIs('home') && $sliderBlocks ?? false)
                        <section class="slider pt-2">
                            <div class="max-w-[1200px] mx-auto px-4 sm:px-0">
                                <div class="grid grid-cols-1 lg:grid-cols-[830px_310px] gap-[24px]">
                                    <!-- Slider Column -->
                                    <div class="bg-white">
                                    @php
                                        $configuration = is_string($sliderBlocks->configuration) 
                                            ? json_decode($sliderBlocks->configuration, true) 
                                            : $sliderBlocks->configuration;
                                        
                                        $sliderPosts = collect(); // Initialize as an empty collection
                                        
                                        if (isset($configuration['type']) && $configuration['type'] === 'post_slider' && isset($configuration['post_ids'])) {
                                            // Ensure post_ids is an array
                                            $postIds = is_string($configuration['post_ids']) 
                                                ? json_decode($configuration['post_ids'], true) 
                                                : $configuration['post_ids'];
                                            
                                            // Ensure $postIds is an array and not empty
                                            $postIds = is_array($postIds) ? $postIds : [];
                                            
                                            if (!empty($postIds)) {
                                                $sliderPosts = \App\Models\Post::whereIn('id', $postIds)
                                                    ->orderByRaw('FIELD(id, ' . implode(',', $postIds) . ')')
                                                    ->get();
                                            }
                                        }
                                    @endphp

                                        @if($sliderPosts->count() > 0)
                                            <div class="swiper homePageSlider">
                                                <div class="swiper-wrapper">
                                                    @foreach($sliderPosts as $post)
                                                        @if($post->featured_image)
                                                            <div class="swiper-slide relative">
                                                                <img 
                                                                    src="{{ asset('storage/' . $post->featured_image) }}" 
                                                                    alt="{{ $post->title }}" 
                                                                    class="w-full h-[300px] md:h-[420px] object-cover"
                                                                >
                                                                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                                                                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 text-white">
                                                                    <h2 class="text-xl md:text-3xl font-bold mb-2 md:mb-4">
                                                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-300 transition line-clamp-2">
                                                                            {{ $post->title }}
                                                                        </a>
                                                                    </h2>
                                                                    <a 
                                                                        href="{{ route('posts.show', $post->slug) }}" 
                                                                        class="inline-block px-4 py-2 md:px-6 md:py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition text-sm md:text-base"
                                                                    >
                                                                        Xem chi tiết
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="swiper-pagination"></div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Latest News Column - Mobile Horizontal Layout -->
                                    <div class="bg-white block lg:hidden">
                                        @if(isset($latestPosts) && $latestPosts->count() > 0)
                                            <div class="space-y-4">
                                                @foreach($latestPosts->take(5) as $post)
                                                    <div class="flex items-center space-x-4 border-b pb-4">
                                                        @if($post->featured_image)
                                                            <div class="w-1/3 flex-shrink-0 overflow-hidden rounded-lg">
                                                                <img 
                                                                    src="{{ asset('storage/' . $post->featured_image) }}" 
                                                                    alt="{{ $post->title }}" 
                                                                    class="w-full h-24 object-cover transform transition-transform duration-300 hover:scale-110"
                                                                >
                                                            </div>
                                                        @endif
                                                        <div class="w-2/3">
                                                            <h3 class="font-bold text-sm line-clamp-2 mb-1">
                                                                <a href="{{ route('posts.show', $post->slug) }}" class="text-gray-800 hover:text-primary">
                                                                    {{ $post->title }}
                                                                </a>
                                                            </h3>
                                                            <p class="text-xs text-gray-600 line-clamp-2 mb-2">
                                                                {{ $post->excerpt }}
                                                            </p>
                                                            <a 
                                                                href="{{ route('posts.show', $post->slug) }}" 
                                                                class="inline-block text-xs text-primary hover:underline"
                                                            >
                                                                Xem chi tiết
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-600 p-4">Chưa có tin mới</p>
                                        @endif
                                    </div>

                                    <!-- Desktop Latest News Column -->
                                    <div class="bg-white hidden lg:block">
                                        @if(isset($latestPosts) && $latestPosts->count() > 0)
                                            @php 
                                                $firstPost = $latestPosts->first();
                                                $remainingPosts = $latestPosts->slice(1, 3);
                                            @endphp

                                            <!-- First Post with Image -->
                                            <div class="mb-3 pb-3 border-b">
                                                @if($firstPost->featured_image)
                                                    <div class="mb-4 overflow-hidden">
                                                        <img 
                                                            src="{{ asset('storage/' . $firstPost->featured_image) }}" 
                                                            alt="{{ $firstPost->title }}" 
                                                            class="w-full h-48 object-cover transform transition-transform duration-300 hover:scale-110"
                                                        >
                                                    </div>
                                                @endif
                                                <h3 class="font-bold text-md line-clamp-2">
                                                    <a href="{{ route('posts.show', $firstPost->slug) }}" class="text-gray-800 hover:text-primary">
                                                        {{ $firstPost->title }}
                                                    </a>
                                                </h3>
                                            </div>

                                            <!-- Remaining Posts as Bulleted List -->
                                            <ul class="list-disc pl-5 space-y-2">
                                                @foreach($remainingPosts as $post)
                                                    <li>
                                                        <a 
                                                            href="{{ route('posts.show', $post->slug) }}" 
                                                            class="text-gray-800 hover:text-primary text-sm line-clamp-2"
                                                        >
                                                            {{ $post->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-gray-600 p-4">Chưa có tin mới</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>

                        @push('scripts')
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
                        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
                        <style>
                            .homePageSlider .swiper-pagination-bullet {
                                background-color: #c07812;
                                opacity: 0.7;
                                transition: all 0.3s ease;
                            }
                            .homePageSlider .swiper-pagination-bullet-active {
                                background-color: #c07812;
                                width: 20px;
                                border-radius: 10px;
                            }

                            .homePageSlider .swiper-button-prev,
                            .homePageSlider .swiper-button-next {
                                color: #c07812 !important;
                                transition: all 0.3s ease;
                            }
                            .homePageSlider .swiper-button-prev:hover,
                            .homePageSlider .swiper-button-next:hover {
                                opacity: 0.7;
                            }
                        </style>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                new Swiper('.homePageSlider', {
                                    loop: true,
                                    autoplay: {
                                        delay: 5000,
                                        disableOnInteraction: false,
                                    },
                                    pagination: {
                                        el: '.swiper-pagination',
                                        clickable: true
                                    },
                                    navigation: {
                                        nextEl: '.swiper-button-next',
                                        prevEl: '.swiper-button-prev',
                                    },
                                    effect: 'fade',
                                    fadeEffect: {
                                        crossFade: true
                                    }
                                });
                            });
                        </script>
                        @endpush
                    @endif

                    <!-- Main Content Area -->
                    <div class="bg-white max-w-[1200px] mx-auto px-4 sm:px-0 py-6">
                        <div class="grid grid-cols-1 lg:grid-cols-[830px_310px] gap-[24px]">
                            <!-- Main Content Column -->
                            <div class="bg-white">
                                @yield('content')
                            </div>

                            <!-- Sidebar Column -->
                            <div class="bg-white mb-6">
                                <!-- Announcements Section -->
                                <div class="bg-white mb-4">
                                    <h4 class="font-semibold mb-3 pb-2 border-b-2 border-primary text-lg">Thông báo</h4>
                                    @if(isset($notifications) && $notifications->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($notifications as $notification)
                                                <li class="border-b pb-2 last:border-b-0">
                                                    <a href="{{ route('posts.show', $notification->slug) }}" 
                                                    class="text-sm text-gray-800 hover:text-primary transition-colors duration-300 block">
                                                        <span class="font-medium line-clamp-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            {{ $notification->title }}
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-gray-600 text-sm">Không có thông báo mới</p>
                                    @endif
                                </div>

                                <!-- Documents Section -->
                                <div class="bg-white mb-6">
                                    <h4 class="font-semibold mb-3 pb-2 border-b-2 border-primary text-lg">Văn Bản</h4>
                                    @if(isset($documentPosts) && $documentPosts->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($documentPosts as $post)
                                                <li class="border-b pb-2 last:border-b-0">
                                                    <a href="{{ route('posts.show', $post->slug) }}" 
                                                    class="text-sm text-gray-800 hover:text-primary transition-colors duration-300 block">
                                                        <span class="font-medium line-clamp-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            {{ $post->title }}
                                                        </span>
                                                        <div class="flex justify-between">
                                                            <span class="text-xs text-gray-500 block">
                                                                {{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}
                                                            </span>
                                                            @if($post->document)
                                                                <span class="text-xs text-primary hover:underline">
                                                                    Tải tài liệu
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-gray-600 text-sm">Không có văn bản mới</p>
                                    @endif
                                </div>

                                <!-- External Links Section -->
                                @php
                                    $externalLinks = App\Models\ExternalLink::active()
                                        ->get()
                                        ->groupBy('category');
                                @endphp

                                <div class="external-links-section bg-white mb-6">
                                    <h3 class="text-lg font-bold mb-4 border-b-2 border-primary pb-2">Liên Kết Website</h3>
                                    
                                    @foreach(['government' => 'Cổng Thông Tin Chính Phủ', 'local' => 'Địa Phương', 'service' => 'Dịch Vụ Công'] as $category => $title)
                                        @if(isset($externalLinks[$category]))
                                            <div class="mb-4">
                                                <h4 class="font-semibold text-sm mb-2">{{ $title }}</h4>
                                                <ul class="space-y-2">
                                                    @foreach($externalLinks[$category] as $link)
                                                        <li>
                                                            <a href="{{ $link->url }}" 
                                                            target="_blank" 
                                                            class="text-primary hover:underline text-sm flex items-center">
                                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                                </svg>
                                                                {{ $link->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>


                                <!-- Map Section -->
                                <div class="mb-6">
                                    <h4 class="font-semibold mb-3 pb-2 border-b-2 border-primary text-lg">Bản đồ chỉ dẫn</h4>
                                    <div class="bg-gray-100 rounded-lg overflow-hidden shadow-inner">
                                        <iframe 
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3841.6855976687193!2d107.70058597459223!3d15.661721950219363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x316a0ce3658dbb1b%3A0x5b1db9046c6ac799!2sT%C3%A0%20B&#39;Hing%20Commune%20People&#39;s%20Committee!5e0!3m2!1sen!2s!4v1740706359337!5m2!1sen!2s" 
                                            width="100%" 
                                            height="250" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade"
                                            class="w-full"
                                        ></iframe>
                                    </div>
                                </div>

                                <!-- Visitor Statistics -->
                                <div>
                                    <h4 class="font-semibold mb-3 pb-2 border-b-2 border-primary text-lg">Thống kê truy cập</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-primary">
                                                    {{ $todayVisits ?? 0 }}
                                                </div>
                                                <div class="text-xs text-gray-600">Hôm nay</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-green-600">
                                                    {{ $totalVisits ?? 0 }}
                                                </div>
                                                <div class="text-xs text-gray-600">Tổng lượt truy cập</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Footer -->
                @include('layouts.footer')
            </div>

            @stack('scripts')
        </div>
    </body>
</html>