@extends('layouts.app')

@section('title', $photo->title)
@section('meta_description', $photo->description ?? 'Chi tiết hình ảnh')

@section('content')
<div class="container mx-auto">
    <div class="mx-auto">
        <img src="{{ asset('storage/' . $photo->image_path) }}" 
             alt="{{ $photo->title }}" 
             class="w-full rounded-lg shadow-lg mb-6 object-cover">
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-primary mb-4">{{ $photo->title }}</h1>
            
            @if($photo->description)
            <p class="text-gray-700 mb-4">{{ $photo->description }}</p>
            @endif
            
            <div class="text-sm text-gray-500">
                <span>Ngày tải: {{ $photo->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection