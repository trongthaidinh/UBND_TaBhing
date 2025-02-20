@extends('layouts.admin')

@section('title', 'Thêm RSS Feed Mới')
@section('page_title', 'Thêm RSS Feed Mới')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Thêm RSS Feed Mới</h2>
    
    <form action="{{ route('admin.rss-feeds.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700">Tên RSS Feed</label>
            <input type="text" name="name" id="name" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"
                   value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="url" class="block text-sm font-medium text-gray-700">URL RSS</label>
            <input type="url" name="url" id="url" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50"
                   value="{{ old('url') }}" required>
        </div>

        <div class="form-group">
            <label for="category" class="block text-sm font-medium text-gray-700">Danh mục</label>
            <select name="category" id="category" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                <option value="">Chọn danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="is_active" class="block text-sm font-medium text-gray-700">Trạng thái</label>
            <select name="is_active" id="is_active" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" 
                    class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                Lưu RSS Feed
            </button>
            <a href="{{ route('admin.rss-feeds.index') }}" 
               class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection