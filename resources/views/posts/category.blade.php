@extends('layouts.app')

@section('content')
<div class="max-w-[1200px] mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 pb-2 border-b-2 border-primary">
        Bài viết trong chuyên mục: {{ $category->name }}
    </h1>
    
    <div class="grid md:grid-cols-4 gap-6">
        @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-600">
                            {{ $category->name }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $post->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                    <h3 class="font-bold text-sm mb-2 line-clamp-2">
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="hover:text-primary">
                            {{ $post->title }}
                        </a>
                    </h3>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection