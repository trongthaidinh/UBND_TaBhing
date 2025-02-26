@extends('layouts.admin')

@section('title', 'Chỉnh sửa Nội dung')
@section('page_title', 'Chỉnh sửa Nội dung')

@section('content')
<div class="bg-white shadow-md rounded-lg">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Chỉnh sửa Nội dung</h2>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề Nội dung</label>
                <input type="text" name="title" id="title" 
                    value="{{ old('title', $post->title) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50" 
                    required>
            </div>

            <div class="mb-4">
                <label for="excerpt" class="block text-gray-700 text-sm font-bold mb-2">Mô tả ngắn</label>
                <textarea name="excerpt" id="excerpt" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:border-primary focus:ring focus:ring-primary/50"
                    placeholder="Nhập mô tả ngắn">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
                <select name="category_id" id="category_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50" 
                    required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung</label>
                <textarea name="content" id="content" rows="10"
                    class="">{{ old('content', $post->content) }}</textarea>
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700">Ảnh đại diện</label>
                <input type="file" name="featured_image" id="featured_image"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
                
                @if($post->featured_image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="Ảnh đại diện" 
                             class="h-32 w-auto object-cover rounded-md">
                    </div>
                @endif
            </div>

            <div>
                <label for="document" class="block text-sm font-medium text-gray-700">Tài liệu</label>
                <input type="file" name="document" id="document" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/50">
            </div>

            <div>
                <div class="flex items-center">
                    <input type="checkbox" 
                        name="is_draft" 
                        id="is_draft" 
                        value="1" 
                        {{ $post->status == 'draft' ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="is_draft" class="ml-2 block text-sm text-gray-900">
                        Lưu nháp (Không xuất bản ngay)
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Nếu không chọn, nội dung sẽ được đưa vào trạng thái chờ duyệt
                </p>
            </div>  

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                    Cập nhật Nội dung
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    tinymce.init({
        selector: '#content',
        setup: function(editor) {
            editor.on('init', function() {
                console.log('TinyMCE initialized');
            });
        },
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount spacing lineheight',
        toolbar: 'undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link image media | ' +
                 'forecolor backcolor removeformat | lineheight | ' +
                 'table tabledelete | code fullscreen preview',
        toolbar_mode: 'sliding',
        height: 500,
        min_height: 300,
        max_height: 700,
        menubar: true,
        statusbar: true,
        content_style: 'body { line-height: 1.5; }',
        lineheight_formats: '1 1.15 1.5 2 2.5 3',
        style_formats: [
            { title: 'Headings', items: [
                { title: 'Heading 1', format: 'h1' },
                { title: 'Heading 2', format: 'h2' },
                { title: 'Heading 3', format: 'h3' },
                { title: 'Heading 4', format: 'h4' }
            ]},
            { title: 'Inline', items: [
                { title: 'Bold', format: 'bold' },
                { title: 'Italic', format: 'italic' },
                { title: 'Underline', format: 'underline' },
                { title: 'Strikethrough', format: 'strikethrough' }
            ]},
            { title: 'Alignment', items: [
                { title: 'Left', format: 'alignleft' },
                { title: 'Center', format: 'aligncenter' },
                { title: 'Right', format: 'alignright' },
                { title: 'Justify', format: 'alignjustify' }
            ]}
        ]
    });
</script>

@endsection