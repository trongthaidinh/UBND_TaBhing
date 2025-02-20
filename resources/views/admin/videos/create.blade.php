@extends('layouts.admin')

@section('title', 'Thêm Video Mới')
@section('page_title', 'Thêm Video Mới')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.videos.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu Đề Video</label>
                <input type="text" name="title" id="title" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Mô Tả</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
            </div>

            <div>
                <label for="youtube_url" class="block text-sm font-medium text-gray-700">Đường Dẫn YouTube</label>
                <input type="url" name="youtube_url" id="youtube_url" placeholder="https://youtube.com/watch?v=..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Trạng Thái</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="published">Xuất Bản</option>
                    <option value="draft">Nháp</option>
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-blue-600 transition">
                    Tải Lên Video
                </button>
            </div>
        </div>
    </form>
</div>
@endsection