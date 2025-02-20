<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories with published post count
        $categories = Category::withCount(['posts' => function($query) {
            $query->where('status', 'published');
        }])
        ->orderBy('posts_count', 'desc')
        ->get();

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function show($slug)
    {
        // Find the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch published posts for this category with pagination
        $posts = $category->posts()
            ->latest()
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}