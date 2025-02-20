@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Ảnh')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-primary mb-6">Chỉnh Sửa Ảnh</h1>

    <form action="{{ route('admin.photo-library.update', $photo) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Tiêu Đề</label>
            <input type="text" name="title" id="title" 
                   value="{{ old('title', $photo->title) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline 
                   @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô Tả (Tùy Chọn)</label>
            <textarea name="description" id="description" 
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline 
                      @error('description') border-red-500 @enderror">{{ old('description', $photo->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Ảnh</label>
            <input type="file" name="image" id="image" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline 
                   @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror

            @if($photo->image_path)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $photo->image_path) }}" 
                     alt="{{ $photo->title }}" 
                     class="h-48 w-auto object-cover rounded">
            </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Trạng Thái</label>
            <select name="status" id="status" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="published" {{ old('status', $photo->status) == 'published' ? 'selected' : '' }}>Xuất Bản</option>
                <option value="draft" {{ old('status', $photo->status) == 'draft' ? 'selected' : '' }}>Nháp</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-primary hover:bg-primary-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cập Nhật Ảnh
            </button>
            <a href="{{ route('admin.photo-library.index') }}" class="inline-block align-baseline font-bold text-sm text-primary hover:text-primary-800">
                Quay Lại
            </a>
        </div>
    </form>
</div>
@endsection