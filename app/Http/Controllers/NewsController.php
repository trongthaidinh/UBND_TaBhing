<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách tin tức với phân trang và lọc
        $query = News::latest('published_at');

        // Lọc theo danh mục nếu có
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Lọc theo từ khóa nếu có
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        // Tăng lượt xem
        $news->incrementViewCount();

        return view('news.show', compact('news'));
    }

    // Các phương thức quản trị
    public function admin_index()
    {
        $news = News::latest()->paginate(20);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'required',
            'category' => 'nullable',
            'published_at' => 'nullable|date',
            'image_url' => 'nullable|url'
        ]);

        $news = News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được tạo');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'required',
            'category' => 'nullable',
            'published_at' => 'nullable|date',
            'image_url' => 'nullable|url'
        ]);

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được cập nhật');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được xóa');
    }
}