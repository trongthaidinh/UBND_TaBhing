@extends('layouts.app')

@section('title', 'Thư Viện Ảnh')
@section('meta_description', 'Bộ sưu tập hình ảnh của Huyện Nam Giang')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold text-primary mb-6">Thư Viện Ảnh</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @forelse($photos as $photo)
        <div class="bg-white shadow-md rounded-lg overflow-hidden group">
            <a href="{{ route('photo-library.show', $photo) }}" class="block relative">
                <img src="{{ asset('storage/' . $photo->image_path) }}" 
                     alt="{{ $photo->title }}" 
                     class="w-full h-36 object-cover group-hover:scale-105 transition duration-300">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-300 
                    flex items-center justify-center">
                    <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition duration-300" 
                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </a>
            <div class="p-2">
                <h3 class="text-sm font-semibold truncate">{{ $photo->title }}</h3>
                @if($photo->description)
                <p class="text-xs text-gray-500 truncate">{{ $photo->description }}</p>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-600 text-xl">Hiện chưa có ảnh nào được tải lên.</p>
        </div>
        @endforelse
    </div>

    @if($photos->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $photos->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush