<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PhotoLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPhotoLibraryController extends Controller
{
    public function index()
    {
        $photos = PhotoLibrary::latest()->paginate(20);
        return view('admin.photo-library.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.photo-library.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'image' => 'required|image|max:5120',
            'status' => 'required|in:published,draft'
        ]);

        $imagePath = $request->file('image')->store('photo-library', 'public');

        PhotoLibrary::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'status' => $validated['status']
        ]);

        return redirect()->route('admin.photo-library.index')
            ->with('success', 'Ảnh đã được tải lên thành công.');
    }

    public function edit(PhotoLibrary $photo)
    {
        return view('admin.photo-library.edit', compact('photo'));
    }

    public function update(Request $request, PhotoLibrary $photo)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'image' => 'nullable|image|max:5120', 
            'status' => 'required|in:published,draft'
        ]);

        if ($request->hasFile('image')) {
            if ($photo->image_path) {
                Storage::disk('public')->delete($photo->image_path);
            }

            $imagePath = $request->file('image')->store('photo-library', 'public');
            $validated['image_path'] = $imagePath;
        }

        $photo->update($validated);

        return redirect()->route('admin.photo-library.index')
            ->with('success', 'Ảnh đã được cập nhật thành công.');
    }

    public function destroy(PhotoLibrary $photo)
    {
        if ($photo->image_path) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return redirect()->route('admin.photo-library.index')
            ->with('success', 'Ảnh đã được xóa thành công.');
    }
}