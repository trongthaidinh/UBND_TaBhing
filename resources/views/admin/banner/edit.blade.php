@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Banner')

@section('content')
<div class="bg-white shadow-md rounded-lg">
    <div class="flex justify-between items-center p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Chỉnh Sửa Banner</h2>
        <a href="{{ route('admin.banner.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Similar to create view, but with existing values -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tên Banner <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $banner->name) }}" 
                    required 
                    class="form-input w-full rounded-md @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ... other fields similar to create view ... -->

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
                
                @if(isset($banner->configuration['image_path']))
                    <div class="mt-2">
                        <p class="text-sm font-medium text-gray-700 mb-1">Hình ảnh hiện tại:</p>
                        <img 
                            src="{{ asset($banner->configuration['image_path']) }}" 
                            alt="{{ $banner->name }}" 
                            class="h-32 w-auto object-cover rounded"
                        >
                    </div>
                @endif
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
            >{{ old('description', $banner->configuration['description'] ?? '') }}</textarea>
        </div>

        <div class="form-group mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Trạng thái
            </label>
            <select 
                name="is_active" 
                class="form-select w-full rounded-md"
            >
                <option value="1" {{ old('is_active', $banner->is_active) == 1 ? 'selected' : '' }}>
                    Hoạt động
                </option>
                <option value="0" {{ old('is_active', $banner->is_active) == 0 ? 'selected' : '' }}>
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
                Cập Nhật
            </button>
        </div>
    </form>
</div>
@endsection