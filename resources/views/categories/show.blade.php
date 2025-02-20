@extends('layouts.app')

@section('title', $category->name)
@section('meta_description', $category->description)

@section('content')
<div class="container mx-auto">
    <div class="mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                {{ $category->name }}
            </h1>
            
            @if($category->description)
                <p class="text-gray-600 mb-6">
                    {{ $category->description }}
                </p>
            @endif
        </div>

        @if($posts->count() > 0)
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        @if($post->featured_image)
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <img 
                                    src="{{ asset('storage/' . $post->featured_image) }}" 
                                    alt="{{ $post->title }}" 
                                    class="w-full h-48 object-cover hover:opacity-90 transition"
                                >
                            </a>
                        @endif
                        
                        <div class="p-4">
                            <h2 class="text-sm font-semibold text-gray-900 mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-600 transition">
                                    {{ Str::limit($post->title, 60) }}
                                </a>
                            </h2>
                            
                            <p class="text-gray-600 mb-4 text-xs">
                                {{ Str::limit($post->excerpt, 60) }}
                            </p>
                            
                            <div class="flex items-center text-xs text-gray-500">
                                <span>{{ $post->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $posts->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-100 rounded-lg">
                <p class="text-gray-600 text-xl">
                    Chưa có bài viết nào trong danh mục này.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection