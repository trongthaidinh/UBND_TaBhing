@extends('layouts.admin')

@section('title', 'Tạo Khối Trang Chủ Mới')
@section('page_title', 'Tạo Khối Trang Chủ Mới')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tạo Khối Trang Chủ Mới</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.homepage-blocks.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên Khối</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="blockType" class="block text-gray-700 text-sm font-bold mb-2">Loại Khối</label>
            <select name="type" id="blockType" required 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="slider">Slider</option>
                <option value="news_lastest">Tin Tức Mới Nhất</option>
                <option value="banner">Banner</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="display_order" class="block text-gray-700 text-sm font-bold mb-2">Thứ Tự Hiển Thị</label>
            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 1) }}" required 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                <input type="checkbox" name="is_active" value="1" checked>
                Hoạt Động
            </label>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cấu Hình</label>
            <div id="configContainer" class="space-y-2">
                <!-- Initial configuration will be populated by JavaScript -->
            </div>
            <button type="button" id="addConfigItem" class="mt-2 bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 transition">
                + Thêm Thuộc Tính
            </button>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 transition">
                Tạo Khối
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

    // Initial configuration for slider
    function populateInitialConfig() {
        // Clear existing configuration
        configContainer.innerHTML = '';

        // Add default configuration for selected type
        const configs = defaultConfigs[blockTypeSelect.value] || [];
        configs.forEach(([key, value]) => {
            configContainer.appendChild(createConfigItemRow(key, value));
        });
    }

    // Populate initial configuration on page load
    populateInitialConfig();

    // Update configuration when block type changes
    blockTypeSelect.addEventListener('change', populateInitialConfig);
});
</script>
@endpush
@endsection