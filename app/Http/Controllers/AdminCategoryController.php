<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name',
            'description' => 'nullable',
            'type' => 'nullable'
        ]);

        $validated['slug'] = (new Category())->generateSlug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
            'type' => 'nullable'
        ]);

        $validated['slug'] = (new Category())->generateSlug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa');
    }

    public function toggleHomeVisibility(Category $category)
{
    $category->show_on_home = !$category->show_on_home;
    $category->save();

    return response()->json([
        'success' => true,
        'show_on_home' => $category->show_on_home
    ]);
}
}