@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Kết Quả Tìm Kiếm: "{{ $query }}"</h1>

    @if($posts->isEmpty() && $categories->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Không tìm thấy kết quả!</strong>
            <span class="block sm:inline">Không có bài viết  nào phù hợp với từ khóa "{{ $query }}".</span>
        </div>
    @else

        @if(!$posts->isEmpty())
            <div>
                <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                    @foreach($posts as $post)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4">
                                <div class="mb-4 flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        {{ $post->category->name }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $post->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-sm font-semibold text-gray-800 hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                                <p class="text-xs text-gray-600 mt-2">
                                    {{ Str::limit($post->excerpt, 100) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $posts->appends(['query' => $query])->links() }}
                </div>
            </div>
        @endif
    @endif
</div>
@endsection