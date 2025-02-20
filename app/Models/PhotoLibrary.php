<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoLibrary extends Model
{
    protected $fillable = [
        'title', 
        'image_path', 
        'description',
        'status'
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Scope for published photos
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}