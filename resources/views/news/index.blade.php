@extends('layouts.app')

@section('title', 'Tin tức')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tin tức</h1>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($news as $item)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                @if($item->image_url)
                    <img src="{{ $item->image_url }}" 
                         alt="{{ $item->title }}" 
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('news.show', $item) }}" 
                           class="hover:text-primary">
                            {{ $item->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($item->description, 150) }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            {{ $item->published_at->diffForHumans() }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $item->category }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $news->links() }}
</div>
@endsection