<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::with('category')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related posts from the same category
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $posts = Post::where('category_id', $category->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('posts.category', compact('posts', 'category'));
    }
}
