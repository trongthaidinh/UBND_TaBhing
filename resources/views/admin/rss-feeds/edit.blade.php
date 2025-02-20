@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chỉnh sửa RSS Feed</h1>
    <form action="{{ route('admin.rss-feeds.update', $rssFeed) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên RSS Feed</label>
            <input type="text" name="name" id="name" class="form-control" 
                   value="{{ old('name', $rssFeed->name) }}" required>
        </div>
        <div class="form-group">
            <label for="url">URL RSS</label>
            <input type="url" name="url" id="url" class="form-control" 
                   value="{{ old('url', $rssFeed->url) }}" required>
        </div>
        <div class="form-group">
            <label for="category">Danh mục</label>
            <select name="category" id="category" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ $rssFeed->category == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="is_active">Trạng thái</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ $rssFeed->is_active ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ !$rssFeed->is_active ? 'selected' : '' }}>Ngừng hoạt động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật RSS Feed</button>
    </form>
</div>
@endsection