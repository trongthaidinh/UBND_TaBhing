<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::published()->latest()->paginate(12);
        return view('videos.index', compact('videos'));
    }

    public function show(Video $video)
    {
        // Ensure only published videos can be viewed
        if ($video->status !== 'published') {
            abort(404);
        }
        return view('videos.show', compact('video'));
    }
}ư