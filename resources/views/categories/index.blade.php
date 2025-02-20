@extends('layouts.app')

@section('title', 'Danh Mục Bài Viết')
@section('meta_description', 'Khám phá các danh mục bài viết')

@section('content')
<div class="container mx-auto">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            Danh Mục Bài Viết
        </h1>

        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
            @foreach($categories as $category)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="hover:text-primary-600 transition">
                                {{ $category->name }}
                            </a>
                        </h2>
                        
                        @if($category->description)
                            <p class="text-gray-600 mb-4">
                                {{ Str::limit($category->description, 100) }}
                            </p>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                {{ $category->posts_count }} Bài Viết
                            </span>
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="text-primary-600 hover:text-primary-800 transition text-sm">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-12 bg-gray-100 rounded-lg">
                <p class="text-gray-600 text-xl">
                    Chưa có danh mục nào được tạo.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection