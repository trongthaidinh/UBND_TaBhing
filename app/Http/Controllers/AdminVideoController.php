<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'youtube_url' => 'nullable|url',
            'status' => 'in:draft,published'
        ]);

        $video = Video::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? '',
            'youtube_url' => $request->input('youtube_url'),
            'status' => $validatedData['status'] ?? 'draft'
        ]);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video đã được tải lên thành công.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'youtube_url' => 'nullable|url',
            'status' => 'in:draft,published'
        ]);

        $video->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? '',
            'youtube_url' => $request->input('youtube_url'),
            'status' => $validatedData['status'] ?? 'draft'
        ]);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video đã được cập nhật thành công.');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video đã được xóa thành công.');
    }
}