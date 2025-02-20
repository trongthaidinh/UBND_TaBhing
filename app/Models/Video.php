<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'youtube_url', 
        'thumbnail_url',
        'status'
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Scope for published videos
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Helper method to extract YouTube thumbnail
    public function getThumbnailAttribute()
    {
        // Extract YouTube video ID and generate thumbnail URL
        preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->youtube_url, $matches);
        
        return $matches[1] 
            ? "https://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg" 
            : null;
    }
}