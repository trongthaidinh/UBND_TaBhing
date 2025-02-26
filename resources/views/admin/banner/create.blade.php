@extends('layouts.admin')

@section('title', 'Thêm Banner Mới')

@section('content')
<div class="bg-white shadow-md rounded-lg">
    <div class="flex justify-between items-center p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Thêm Banner Mới</h2>
        <a href="{{ route('admin.banner.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tên Banner <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    class="form-input w-full rounded-md @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Thứ tự hiển thị <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="display_order" 
                    value="{{ old('display_order', 0) }}" 
                    required 
                    class="form-input w-full rounded-md @error('display_order') border-red-500 @enderror"
                >
                @error('display_order')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Đường liên kết
                </label>
                <input 
                    type="url" 
                    name="link_url" 
                    value="{{ old('link_url') }}" 
                    class="form-input w-full rounded-md @error('link_url') border-red-500 @enderror"
                >
                @error('link_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Hình ảnh Banner
                </label>
                <input 
                    type="file" 
                    name="image" 
                    accept="image/*"
                    class="form-input w-full rounded-md @error('image') border-red-500 @enderror"
                >
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Chỉ chấp nhận file ảnh, tối đa 2MB</p>
            </div>
        </div>

        <div class="form-group mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Mô tả
            </label>
            <textarea 
                name="description" 
                rows="3" 
                class="form-textarea w-full rounded-md"
            >{{ old('description') }}</textarea>
        </div>

        <div class="form-group mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Trạng thái
            </label>
            <select 
                name="is_active" 
                class="form-select w-full rounded-md"
            >
                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                    Hoạt động
                </option>
                <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>
                    Tạm dừng
                </option>
            </select>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a 
                href="{{ route('admin.banner.index') }}" 
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
            >
                Hủy
            </a>
            <button 
                type="submit" 
                class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition"
            >
                Tạo Banner
            </button>
        </div>
    </form>
</div>
@endsection