<?php

namespace App\Http\Controllers;

use App\Models\PhotoLibrary;
use Illuminate\Http\Request;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        $photos = PhotoLibrary::published()
            ->latest()
            ->paginate(16);
        
        return view('photo-library.index', compact('photos'));
    }

    public function show(PhotoLibrary $photo)
    {
        // Ensure only published photos can be viewed
        if ($photo->status !== 'published') {
            abort(404);
        }
        
        return view('photo-library.show', compact('photo'));
    }
}