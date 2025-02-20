@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa Tin tức</h1>

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Nhập tiêu đề tin tức">
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả ngắn</label>
                <textarea name="description" id="description" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Nhập mô tả ngắn">{{ old('description', $news->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Nội dung</label>
                <textarea name="content" id="content" rows="6" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Nhập nội dung chi tiết">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Danh mục</label>
                <select name="category" id="category"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Chọn danh mục</option>
                    <option value="Tin tức" {{ $news->category == 'Tin tức' ? 'selected' : '' }}>Tin tức</option>
                    <option value="Sự kiện" {{ $news->category == 'Sự kiện' ? 'selected' : '' }}>Sự kiện</option>
                    <option value="Thông báo" {{ $news->category == 'Thông báo' ? 'selected' : '' }}>Thông báo</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="published_at" class="block text-gray-700 text-sm font-bold mb-2">Ngày xuất bản</label>
                <input type="date" name="published_at" id="published_at" 
                    value="{{ old('published_at', 
                        $news->published_at ? 
                            (is_string($news->published_at) ? 
                                \Carbon\Carbon::parse($news->published_at)->format('Y-m-d') : 
                                $news->published_at->format('Y-m-d')) : 
                            '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="image_url" class="block text-gray-700 text-sm font-bold mb-2">Ảnh đại diện (URL)</label>
                <input type="url" name="image_url" id="image_url" 
                    value="{{ old('image_url', $news->image_url) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Nhập URL ảnh">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cập nhật Tin tức
                </button>
                <a href="{{ route('admin.news.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection