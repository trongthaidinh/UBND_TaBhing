@extends('layouts.app')

@section('content')
<div class="max-w-[1200px]">
    <div class="grid grid-cols-1 lg:grid-cols-[840px_320px] gap-0 lg:gap-10">
        <div class="content-column">
            <!-- Quick Access Buttons -->
            <section class="quick-access-buttons grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <a href="https://dichvucong.quangnam.gov.vn/" target="_blank" class="block">
                    <img src="{{ asset('images/dvc-truc-tuyen.png') }}" alt="Dịch Vụ Công Trực Tuyến" class="w-full h-auto rounded-lg shadow-md hover:opacity-80 transition-opacity">
                </a>
                <a href="https://dichvucong.quangnam.gov.vn/vi/procedure/search" target="_blank" class="block">
                    <img src="{{ asset('images/bo-tthc.png') }}" alt="Bộ Thủ Tục Hành Chính" class="w-full h-auto rounded-lg shadow-md hover:opacity-80 transition-opacity">
                </a>
                <a href="https://dichvucong.quangnam.gov.vn/vi/dossier/public-qni" target="_blank" class="block">
                    <img src="{{ asset('images/tra-cuu-hso.jpg') }}" alt="Tra Cứu Hồ Sơ" class="w-full h-auto rounded-lg shadow-md hover:opacity-80 transition-opacity">
                </a>
            </section>

            <!-- Latest Posts Section -->
            <!-- <section class="latest-posts mb-8">
                <h2 class="text-lg sm:text-xl font-bold mb-4 pb-2 border-b-2 border-primary">Tin tức mới nhất</h2>
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($latestPosts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-36 object-cover">
                        @endif
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[8px] lg:text-sm text-gray-600">
                                    {{ $post->category ? $post->category->name : 'Không phân loại' }}
                                </span>
                                <span class="text-[8px] lg:text-sm text-gray-500">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="font-bold text-[10px] lg:text-sm mb-2 line-clamp-2">{{ $post->title }}</h3>
                            <a href="{{ route('posts.show', $post->slug) }}" 
                               class="text-primary hover:underline text-[8px] lg:text-sm">
                                Đọc thêm
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center text-gray-600">
                        Chưa có bài viết nào
                    </div>
                    @endforelse
                </div>
            </section> -->

            

            <!-- Banners Above Categories Section -->
            @php
                $topBanner = $banners->where('display_order', 1)->first();
            @endphp
            @if($topBanner && isset($topBanner->configuration['image_path']) && $topBanner->configuration['image_path'])
                <section class="top-banner mb-6">
                    <div class="banner-item">
                        <a href="{{ $topBanner->configuration['link_url'] ?? '#' }}" class="block">
                            <img 
                                src="{{ asset($topBanner->configuration['image_path']) }}" 
                                alt="{{ $topBanner->name }}" 
                                class="w-full h-auto object-cover rounded-lg shadow-md"
                            >
                        </a>
                    </div>
                </section>
            @endif

            <!-- Categories with Posts Section -->
            <section class="category-posts space-y-8 mb-6">
                @forelse($categories as $category)
                    @if($category->show_on_home && $category->posts->count() > 0)
                        <div class="category-section">
                            <h2 class="text-lg sm:text-xl font-bold mb-4 pb-2 border-b-2 border-primary">{{ $category->name }}</h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                                <!-- Left Column: Main Post with Image -->
                                @php
                                    $mainPost = $category->posts->first();
                                    $remainingPosts = $category->posts->slice(1);
                                @endphp
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <a href="{{ route('posts.show', $mainPost->slug) }}" class="hover:text-primary">
                                        @if($mainPost->featured_image)
                                            <img src="{{ asset('storage/' . $mainPost->featured_image) }}" 
                                                alt="{{ $mainPost->title }}" 
                                                class="w-full h-48 lg:h-auto object-cover">
                                        @endif
                                        <div class="p-4">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-xs text-gray-600">
                                                    {{ $category->name }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $mainPost->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            <h3 class="font-bold text-base mb-2 line-clamp-3">
                                                
                                                    {{ $mainPost->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                                {{ Str::limit($mainPost->excerpt, 150) }}
                                            </p>
                                            <a href="{{ route('posts.show', $mainPost->slug) }}" 
                                            class="text-primary hover:underline text-xs">
                                                Đọc thêm
                                            </a>
                                        </div>
                                    </a>
                                </div>

                                <!-- Right Column: List of Remaining Posts -->
                                <div class="bg-white rounded-lg p-4">
                                    <ul class="space-y-3">
                                        @foreach($remainingPosts as $post)
                                            <li class="border-b pb-3 last:border-b-0">
                                                <a href="{{ route('posts.show', $post->slug) }}" 
                                                   class="text-sm font-semibold text-gray-800 hover:text-primary line-clamp-2">
                                                    {{ $post->title }}
                                                </a>
                                                <div class="flex justify-between items-center mt-1">
                                                    <span class="text-xs text-gray-500">
                                                        {{ $post->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="text-right mt-4">
                                <a href="{{ route('categories.show', $category->slug) }}" 
                                   class="text-primary hover:underline text-sm">
                                    Xem tất cả bài viết trong {{ $category->name }}
                                </a>
                            </div>
                        </div>

                        @if(!$loop->last)
                            <hr class="border-t border-gray-200">
                        @endif
                    @endif
                @empty
                    <p class="text-center text-gray-600">Chưa có chuyên mục và bài viết</p>
                @endforelse
            </section>

            <!-- Banners Below Categories Section -->
            @php
                $bottomBanner = $banners->where('display_order', 2)->first();
            @endphp
            @if($bottomBanner && isset($bottomBanner->configuration['image_path']) && $bottomBanner->configuration['image_path'])
                <section class="bottom-banner my-6">
                    <div class="banner-item">
                        <a href="{{ $bottomBanner->configuration['link_url'] ?? '#' }}" class="block">
                            <img 
                                src="{{ asset($bottomBanner->configuration['image_path']) }}" 
                                alt="{{ $bottomBanner->name }}" 
                                class="w-full h-auto object-cover rounded-lg shadow-md"
                            >
                        </a>
                    </div>
                </section>
            @endif

            <!-- Video Block Section -->
            <section class="video-block mb-8">
                <h2 class="text-lg sm:text-xl font-bold mb-4 pb-2 border-b-2 border-primary">Video</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($videos as $video)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="{{ $video->thumbnail }}" 
                                    alt="{{ $video->title }}" 
                                    class="w-full h-auto object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                    <a href="{{ $video->youtube_url }}" target="_blank" class="text-white">
                                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-semibold line-clamp-2 mb-2">{{ $video->title }}</h3>
                                <span class="text-xs text-gray-500">{{ $video->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-600">
                            Chưa có video
                        </div>
                    @endforelse
                </div>
            </section>  

            <!-- Photo Library Section -->
            <section class="photo-library mb-8">
                <h2 class="text-lg sm:text-xl font-bold mb-4 pb-2 border-b-2 border-primary">Thư Viện Ảnh</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($photoLibrary as $photo)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" 
                                     alt="{{ $photo->title }}" 
                                     class="w-full h-48 object-cover hover:opacity-80 transition-opacity">
                            </a>
                        </div>
                    @empty
                        <div class="col-span-4 text-center text-gray-600">
                            Chưa có ảnh nào trong thư viện
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection