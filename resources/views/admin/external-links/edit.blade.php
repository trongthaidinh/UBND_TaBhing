@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Liên Kết Ngoài')
@section('page_title', 'Chỉnh Sửa Liên Kết')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.external-links.update', $externalLink) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên Liên Kết</label>
                <input type="text" name="name" id="name" value="{{ $externalLink->name }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700">Đường Dẫn URL</label>
                <input type="url" name="url" id="url" value="{{ $externalLink->url }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Danh Mục</label>
                <select name="category" id="category" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="government" {{ $externalLink->category == 'government' ? 'selected' : '' }}>Cổng Thông Tin Chính Phủ</option>
                    <option value="local" {{ $externalLink->category == 'local' ? 'selected' : '' }}>Địa Phương</option>
                    <option value="service" {{ $externalLink->category == 'service' ? 'selected' : '' }}>Dịch Vụ Công</option>
                </select>
            </div>

            <div>
                <label for="is_active" class="block text-sm font-medium text-gray-700">Trạng Thái</label>
                <select name="is_active" id="is_active"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="1" {{ $externalLink->is_active ? 'selected' : '' }}>Hoạt Động</option>
                    <option value="0" {{ !$externalLink->is_active ? 'selected' : '' }}>Ngừng Hoạt Động</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-600 transition">
                    Cập Nhật Liên Kết
                </button>
            </div>
        </div>
    </form>
</div>
@endsection