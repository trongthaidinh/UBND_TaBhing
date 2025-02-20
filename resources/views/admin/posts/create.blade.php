@extends('layouts.admin')

@section('title', 'Tạo Bài viết Mới')
@section('page_title', 'Tạo Bài viết Mới')

@section('content')
<div class="bg-white shadow-md rounded-lg">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Tạo Bài viết Mới</h2>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề Bài viết</label>
                <input type="text" name="title" id="title" 
                    value="{{ old('title') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50" 
                    required>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
                <select name="category_id" id="category_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50" 
                    required>
                    <option value="">Chọn Danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Nội dung</label>
                <textarea name="content" id="content" rows="10"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"
                    required>{{ old('content') }}</textarea>
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700">Ảnh đại diện</label>
                <input type="file" name="featured_image" id="featured_image"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
            </div>

            <div>
                <div class="flex items-center">
                    <input type="checkbox" 
                        name="is_draft" 
                        id="is_draft" 
                        value="1" 
                        class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="is_draft" class="ml-2 block text-sm text-gray-900">
                        Lưu nháp (Không xuất bản ngay)
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Nếu không chọn, bài viết sẽ được đưa vào trạng thái chờ duyệt
                </p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                    Tạo Bài viết
                </button>
            </div>
        </div>
    </form>
</div>
@endsection