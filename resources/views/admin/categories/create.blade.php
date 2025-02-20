@extends('layouts.admin')

@section('title', 'Tạo Danh mục Mới')
@section('page_title', 'Thêm Danh mục')

@section('content')
<div class="bg-white shadow-md rounded-lg">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Thêm Danh mục Mới</h2>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên Danh mục</label>
                <input type="text" name="name" id="name" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50" 
                    required>
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">Đường dẫn (Slug)</label>
                <input type="text" name="slug" id="slug" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50" 
                    placeholder="Để trống để tự động tạo">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"
                ></textarea>
            </div>

            <div class="form-group mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="show_on_home" name="show_on_home" value="1">
                    <label class="form-check-label" for="show_on_home">
                        Hiển Thị Trên Trang Chủ
                    </label>
                    <small class="form-text text-muted">
                        Cho phép các bài viết thuộc danh mục này được hiển thị trên trang chủ
                    </small>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-600 transition">
                    Lưu Danh mục
                </button>
            </div>
        </div>
    </form>
</div>
@endsection