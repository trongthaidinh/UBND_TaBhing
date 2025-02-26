@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6">
        @if($homepageBlock->type !== 'slider')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                Khối này không phải là slider. Không thể chỉnh sửa.
            </div>
        @else
            @php
                // Safely parse configuration
                $configuration = is_string($homepageBlock->configuration) 
                    ? json_decode($homepageBlock->configuration, true) 
                    : ($homepageBlock->configuration ?? []);
                
                $selectedPostIds = is_array($configuration) && isset($configuration['post_ids']) 
                    ? $configuration['post_ids'] 
                    : [];

                // Ensure $selectedPostIds is an array
                $selectedPostIds = is_array($selectedPostIds) ? $selectedPostIds : [];
            @endphp

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Chỉnh Sửa Slider
            </h1>

            <form action="{{ route('admin.homepage-blocks.update', $homepageBlock) }}" method="POST" id="sliderForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="type" value="slider">
                <input type="hidden" name="configuration[keys][]" value="type">
                <input type="hidden" name="configuration[values][]" value="post_slider">
                <input type="hidden" name="configuration[keys][]" value="post_ids">

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên Slider</label>
                    <input type="text" name="name" id="name" 
                        value="{{ old('name', $homepageBlock->name ?? 'Slider Trang Chủ') }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="display_order" class="block text-gray-700 text-sm font-bold mb-2">Thứ Tự Hiển Thị</label>
                    <input type="number" name="display_order" id="display_order" 
                        value="{{ old('display_order', $homepageBlock->display_order ?? 1) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('display_order')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <input type="checkbox" name="is_active" value="1" 
                            {{ old('is_active', $homepageBlock->is_active ?? true) ? 'checked' : '' }}>
                        Hoạt Động
                    </label>
                </div>

                <div class="mb-4">
                    <label for="postSelect" class="block text-gray-700 text-sm font-bold mb-2">
                        Chọn Bài Viết Slider
                    </label>
                    <select name="post_ids[]" id="postSelect" multiple="multiple" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach(App\Models\Post::where('status', 'published')->orderBy('published_at', 'desc')->get() as $post)
                            <option value="{{ $post->id }}" 
                                {{ in_array((string)$post->id, array_map('strval', $selectedPostIds)) ? 'selected' : '' }}>
                                {{ $post->title }} ({{ $post->category->name }}) - {{ $post->published_at->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        Chọn các bài viết để hiển thị trong slider. Tối đa 5 bài viết được khuyến nghị.
                    </p>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" 
                        class="bg-primary hover:bg-primary-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cập Nhật Slider
                    </button>
                    <a href="{{ route('admin.homepage-blocks.index') }}" 
                       class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Quay lại
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#postSelect').select2({
        placeholder: "Chọn bài viết cho slider",
        allowClear: true,
        width: '100%',
        maximumSelectionLength: 5
    });

    $('#sliderForm').on('submit', function(e) {
        var selectedPosts = $('#postSelect').val() || [];
        
        $(this).find('input[name="configuration[keys][]"][value="post_ids"]').nextAll('input[name="configuration[values][]"]').remove();
        
        $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'configuration[values][]')
            .val(selectedPosts.join(','))
            .insertAfter($(e.target).find('input[name="configuration[keys][]"][value="post_ids"]'));

        console.log('Selected Post IDs:', selectedPosts);
    });
});
</script>
@endpush