@extends('layouts.app')

@section('content')
<div class="max-w-[1200px] mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-[840px_320px] gap-0 md:gap-10">
        <div class="content-column">
            <article>
                <div>
                    @if ($post->category->name !== 'Trang tĩnh')
                        <div class="mb-4">
                            <span class="text-xs md:text-sm text-gray-600">
                                Chuyên mục: {{ $post->category->name }}
                            </span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span class="text-xs md:text-sm text-gray-500">
                                {{ $post->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    @endif
                    
                    <h1 class="text-xl md:text-3xl font-bold mb-4 md:mb-6">{{ $post->title }}</h1>
                    
                    @if($post->featured_image)
                        <div class="mb-4 md:mb-6">
                            <img 
                                src="{{ asset('storage/' . $post->featured_image) }}" 
                                alt="{{ $post->title }}" 
                                class="w-full h-auto object-cover rounded-lg"
                            >
                        </div>
                    @endif
                    
                    <div class="prose max-w-none text-sm md:text-base">
                        {!! $post->content !!}
                    </div>
                </div>
            </article>

            @if($relatedPosts->count() > 0 && $post->category->name !== 'Trang tĩnh')
                <section class="mt-6 md:mt-8">
                    <h2 class="text-lg md:text-xl font-bold mb-3 md:mb-4 pb-2 border-b-2 border-primary">Bài viết liên quan</h2>
                    <div class="space-y-4 md:space-y-6">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="flex flex-row bg-white rounded-lg shadow-md overflow-hidden">
                                @if($relatedPost->featured_image)
                                    <div class="w-24 md:w-64 h-24 md:h-48 flex-shrink-0">
                                        <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                             alt="{{ $relatedPost->title }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div class="p-3 md:p-6 flex-grow">
                                    <div class="flex items-center justify-between text-[8px] md:text-xs text-gray-600 mb-1 md:mb-3">
                                        <span class="mr-2 md:mr-4">
                                            {{ $relatedPost->category->name }}
                                        </span>
                                        <span>
                                            {{ $relatedPost->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-[10px] md:text-lg mb-1 md:mb-3">
                                        <a href="{{ route('posts.show', $relatedPost->slug) }}" 
                                           class="hover:text-primary line-clamp-2">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h3>
                                    <p class="text-[8px] md:text-xs text-gray-700 mb-1 md:mb-4 line-clamp-3 hidden md:block">
                                        {{ Str::limit($relatedPost->excerpt, 250) }}
                                    </p>
                                    <a href="{{ route('posts.show', $relatedPost->slug) }}" 
                                       class="inline-block text-[8px] md:text-xs text-primary hover:underline">
                                        Đọc thêm
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        <div class="sidebar-column hidden lg:block">
            <!-- Sidebar content -->
        </div>
    </div>
</div>
@endsection