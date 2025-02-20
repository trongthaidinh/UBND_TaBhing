@extends('layouts.app')

@section('title', 'Thư Viện Video')
@section('meta_description', 'Bộ sưu tập video của Huyện Nam Giang')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold text-primary mb-6">Thư Viện Video</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($videos as $video)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <a href="{{ route('videos.show', $video) }}" class="block">
                <div class="relative">
                    <img src="{{ $video->thumbnail }}" 
                         alt="{{ $video->title }}" 
                         class="w-full h-36 object-cover hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </a>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2 truncate">{{ $video->title }}</h3>
                <p class="text-gray-600 text-sm line-clamp-2">{{ $video->description }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-600 text-xl">Hiện chưa có video nào được tải lên.</p>
        </div>
        @endforelse
    </div>

    @if($videos->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $videos->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush