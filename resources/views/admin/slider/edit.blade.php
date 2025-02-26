@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        @if($homepageBlock->type !== 'slider')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                Khối này không phải là slider. Không thể chỉnh sửa.
            </div>
        @else
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="ri-layout-grid-line mr-2 text-primary"></i>
                Cấu Hình Slider Trang Chủ
            </h1>

            <form action="{{ route('admin.slider.update', $homepageBlock->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="type" value="slider">
                <input type="hidden" name="configuration[keys][]" value="type">
                <input type="hidden" name="configuration[values][]" value="post_slider">
                <input type="hidden" name="configuration[keys][]" value="post_ids">

                <div class="mb-4">
                    <label for="postSelect" class="block text-gray-700 text-sm font-bold mb-2">
                        Chọn Bài Viết Slider
                    </label>
                    @php
                        $configuration = is_string($homepageBlock->configuration) 
                            ? json_decode($homepageBlock->configuration, true) 
                            : ($homepageBlock->configuration ?? []);
                        $selectedPostIds = $configuration['post_ids'] ?? [];
                    @endphp
                    <select name="configuration[values][1][]" id="postSelect" multiple="multiple" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach(App\Models\Post::where('status', 'published')->orderBy('published_at', 'desc')->get() as $post)
                            <option value="{{ $post->id }}" 
                                {{ in_array($post->id, $selectedPostIds) ? 'selected' : '' }}>
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
});
</script>
@endpush