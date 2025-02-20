@extends('layouts.admin')

@section('title', 'Sửa Khối Trang Chủ')
@section('page_title', 'Sửa Khối Trang Chủ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh Sửa Khối Trang Chủ</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.homepage-blocks.update', $homepageBlock) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên Khối</label>
            <input type="text" name="name" id="name" value="{{ old('name', $homepageBlock->name) }}" required 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Loại Khối</label>
            <select name="type" id="blockType" required 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="slider" {{ $homepageBlock->type == 'slider' ? 'selected' : '' }}>Slider</option>
                <option value="news_lastest" {{ $homepageBlock->type == 'news_lastest' ? 'selected' : '' }}>Tin Tức Mới Nhất</option>
                <option value="banner" {{ $homepageBlock->type == 'banner' ? 'selected' : '' }}>Banner</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="display_order" class="block text-gray-700 text-sm font-bold mb-2">Thứ Tự Hiển Thị</label>
            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $homepageBlock->display_order) }}" required 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $homepageBlock->is_active) ? 'checked' : '' }}>
                Hoạt Động
            </label>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cấu Hình</label>
            <div id="configContainer" class="space-y-2">
                @php
                    // Ensure $configuration is an array
                    $configuration = is_string($homepageBlock->configuration) 
                        ? json_decode($homepageBlock->configuration, true) 
                        : ($homepageBlock->configuration ?? []);
                @endphp
                @foreach($configuration as $key => $value)
                    <div class="flex items-center space-x-2 config-item">
                        <input type="text" name="configuration[keys][]" value="{{ $key }}" placeholder="Khóa" 
                            class="w-1/3 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <input type="text" name="configuration[values][]" value="{{ is_array($value) ? json_encode($value) : $value }}" placeholder="Giá trị" 
                            class="w-1/2 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <button type="button" class="remove-config-item text-red-500 hover:text-red-700 px-2">✖</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="addConfigItem" class="mt-2 bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 transition">
                + Thêm Thuộc Tính
            </button>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 transition">
                Cập Nhật Khối
            </button>
            <a href="{{ route('admin.homepage-blocks.index') }}" class="text-gray-600 hover:text-gray-800">
                Hủy
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const configContainer = document.getElementById('configContainer');
    const addConfigItemBtn = document.getElementById('addConfigItem');
    const blockTypeSelect = document.getElementById('blockType');

    // Function to create a new configuration item row
    function createConfigItemRow(key = '', value = '') {
        const row = document.createElement('div');
        row.className = 'flex items-center space-x-2 config-item';
        row.innerHTML = `
            <input type="text" name="configuration[keys][]" value="${key}" placeholder="Khóa" 
                   class="w-1/3 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <input type="text" name="configuration[values][]" value="${value}" placeholder="Giá trị" 
                   class="w-1/2 shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button type="button" class="remove-config-item text-red-500 hover:text-red-700 px-2">✖</button>
        `;

        // Add remove functionality
        row.querySelector('.remove-config-item').addEventListener('click', function() {
            row.remove();
        });

        return row;
    }

    // Add new configuration item
    addConfigItemBtn.addEventListener('click', function() {
        configContainer.appendChild(createConfigItemRow());
    });

    // Remove configuration item (event delegation)
    configContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-config-item')) {
            e.target.closest('.config-item').remove();
        }
    });

    // Default configurations based on block type
    const defaultConfigs = {
        slider: [
            ['type', 'post_slider'],
            ['post_ids', '[]']
        ],
        news: [
            ['items_to_show', '6'],
            ['category_filter', '']
        ],
        banner: [
            ['image_path', ''],
            ['description', ''],
            ['link_url', '']
        ]
    };

    // Update configuration when block type changes
    blockTypeSelect.addEventListener('change', function() {
        // Clear existing configuration
        configContainer.innerHTML = '';

        // Add default configuration for selected type
        const configs = defaultConfigs[this.value] || [];
        configs.forEach(([key, value]) => {
            configContainer.appendChild(createConfigItemRow(key, value));
        });
    });
});
</script>
@endpush
@endsection