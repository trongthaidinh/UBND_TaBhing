@extends('layouts.admin')

@section('title', 'Quản Lý Slider')
@section('page_title', 'Danh Sách Slider')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="ri-layout-grid-line mr-2 text-primary"></i>
                Danh Sách Slider
            </h2>
            <a href="{{ route('admin.homepage-blocks.create') }}" 
               class="px-4 py-2 bg-primary text-white rounded hover:bg-primary-600 transition flex items-center">
                <i class="ri-add-line mr-1"></i>
                Thêm Slider Mới
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Tên Slider</th>
                        <th class="py-3 px-6 text-center">Số Bài Viết</th>
                        <th class="py-3 px-6 text-center">Trạng Thái</th>
                        <th class="py-3 px-6 text-right">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($homepageBlocks->where('type', 'slider') as $block)
                        @php
                            // Safely parse configuration
                            $configuration = null;
                            try {
                                $configuration = is_string($block->configuration) 
                                    ? json_decode($block->configuration, true) 
                                    : ($block->configuration ?? []);
                                $postIds = is_array($configuration) && isset($configuration['post_ids']) 
                                    ? $configuration['post_ids'] 
                                    : [];
                            } catch (\Exception $e) {
                                $configuration = [];
                                $postIds = [];
                            }
                        @endphp
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $block->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span class="bg-primary/10 font-medium text-primary px-3 py-1 rounded-full">
                                    {{ is_array($postIds) ? count($postIds) : 0 }} Bài Viết
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if($block->is_active)
                                    <span class="font-medium bg-green-100 text-green-600 px-3 py-1 rounded-full">
                                        Hoạt Động
                                    </span>
                                @else
                                    <span class="font-medium bg-red-100 text-red-600 px-3 py-1 rounded-full">
                                        Không Hoạt Động
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-right">
                                <div class="flex item-center justify-end space-x-2">
                                    <a href="{{ route('admin.homepage-blocks.edit', $block) }}" 
                                       class="text-blue-500 hover:text-blue-700 mr-2">
                                        <i class="ri-edit-line text-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.homepage-blocks.destroy', $block) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa slider này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ri-layout-grid-line text-4xl text-gray-300 mb-4"></i>
                                    <p>Chưa có slider nào được tạo</p>
                                    <a href="{{ route('admin.homepage-blocks.create') }}" 
                                       class="mt-4 px-4 py-2 bg-primary text-white rounded hover:bg-primary-600 transition">
                                        Tạo Slider Đầu Tiên
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection