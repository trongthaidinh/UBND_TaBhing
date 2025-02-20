<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminPostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Post::query();

        // Lọc theo trạng thái
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Tìm kiếm theo tiêu đề
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp
        $query->orderBy('created_at', 'desc');

        // Phân trang
        $posts = $query->paginate(10);

        return view('admin.posts.index', [
            'posts' => $posts,
            'statuses' => [
                'draft' => 'Nháp',
                'pending' => 'Chờ duyệt',
                'published' => 'Đã xuất bản',
                'archived' => 'Đã lưu trữ'
            ]
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
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

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

        // Tạo bài viết
        $post = Post::create($validatedData);

        return redirect()->route('admin.posts.index')
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
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:draft,pending,published,archived',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
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

        // Cập nhật bài viết
        $post->update($validatedData);

        return redirect()->route('admin.posts.index')
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

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được duyệt thành công.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }
}