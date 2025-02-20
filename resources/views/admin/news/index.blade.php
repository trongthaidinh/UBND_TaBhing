@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý Tin tức</h1>
        <a href="{{ route('admin.news.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Thêm Tin mới
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tiêu đề</th>
                    <th class="py-3 px-6 text-center">Danh mục</th>
                    <th class="py-3 px-6 text-center">Ngày xuất bản</th>
                    <th class="py-3 px-6 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($news as $item)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">{{ Str::limit($item->title, 50) }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                            {{ $item->category ?? 'Chưa phân loại' }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $item->published_at ? 
                            (is_string($item->published_at) ? 
                                \Carbon\Carbon::parse($item->published_at)->format('d/m/Y') : 
                                $item->published_at->format('d/m/Y')) : 
                            'Chưa xuất bản' }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('admin.news.edit', $item) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa tin này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($news->isEmpty())
            <div class="text-center py-6 text-gray-500">
                Chưa có tin tức nào. <a href="{{ route('admin.news.create') }}" class="text-blue-500">Thêm tin ngay</a>
            </div>
        @endif

        <div class="px-6 py-4">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection