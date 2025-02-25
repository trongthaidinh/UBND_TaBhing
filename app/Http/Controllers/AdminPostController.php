<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Post::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        $query->orderBy('created_at', 'desc');

        // Pagination
        $posts = $query->paginate(10);
        $categories = Category::all();

        return view('admin.posts.index', [
            'posts' => $posts,
            'statuses' => [
                'draft' => 'Nháp',
                'pending' => 'Chờ duyệt',
                'published' => 'Đã xuất bản',
                'archived' => 'Đã lưu trữ'
            ],
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        // Add the excerpt to the validated data
        $validatedData['excerpt'] = $request->input('excerpt');

        // Xác định trạng thái
        $validatedData['status'] = $request->has('is_draft') ? 'draft' : 'pending';

        // Tạo slug
        $validatedData['slug'] = Str::slug($validatedData['title']);

        // Thêm author_id
        $validatedData['author_id'] = Auth::id();

        // Xử lý ảnh đại diện
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
            $validatedData['featured_image'] = $imagePath;
        }

        // Xử lý tài liệu
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
            $validatedData['document'] = $documentPath;
        }

        // Tạo bài viết
        $post = Post::create($validatedData);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Bài viết đã được tạo thành công.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:draft,pending,published,archived',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        // Cập nhật slug nếu tiêu đề thay đổi
        if ($post->title !== $validatedData['title']) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
        }

        // Xử lý ảnh đại diện
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
            $validatedData['featured_image'] = $imagePath;
        }

        // Xử lý tài liệu
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('documents', 'public');
            $validatedData['document'] = $documentPath;
        }

        // Cập nhật bài viết
        $post->update($validatedData);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    public function approve(Post $post)
    {
        // Ensure only admin or content managers can approve posts
        $this->authorize('approve', $post);

        // Update post status to published
        $post->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Bài viết đã được duyệt thành công.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }
}
