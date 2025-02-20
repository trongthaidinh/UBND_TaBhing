@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container mx-auto px-4">
    <article class="max-w-2xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">{{ $news->title }}</h1>
        
        <div class="flex items-center mb-6 text-gray-600">
            <span class="mr-4">{{ $news->author }}</span>
            <span>{{ $news->published_at->format('d/m/Y H:i') }}</span>
        </div>

        @if($news->image_url)
            <img src="{{ $news->image_url }}" 
                 alt="{{ $news->title }}" 
                 class="w-full mb-6 rounded-lg">
        @endif

        <div class="prose max-w-none">
            {!! $news->content !!}
        </div>

        <div class="mt-6 text-gray-600">
            <strong>Nguồn:</strong> {{ $news->source ?? 'Không rõ' }}
        </div>
    </article>
</div>
@endsection