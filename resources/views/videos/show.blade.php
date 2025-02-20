@extends('layouts.app')

@section('title', $video->title)
@section('meta_description', $video->description)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="aspect-w-16 aspect-h-9 mb-6">
            <iframe 
                src="https://www.youtube.com/embed/{{ substr(strrchr($video->youtube_url, '='), 1) }}" 
                title="{{ $video->title }}"
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen
                class="w-full h-full"
            ></iframe>
        </div>

        <h1 class="text-3xl font-bold text-primary mb-4">{{ $video->title }}</h1>
        <p class="text-gray-700 mb-6">{{ $video->description }}</p>
    </div>
</div>
@endsection