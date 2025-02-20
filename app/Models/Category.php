<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'show_on_home'
    ];

    protected $casts = [
        'show_on_home' => 'boolean'
    ];

    // Relationship with posts (published and active)
    public function posts()
    {
        return $this->hasMany(Post::class)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc');
    }

    // Generate unique slug
    public function generateSlug($name)
    {
        $slug = \Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    // Scope for home page categories
    public function scopeHomeVisible($query)
    {
        return $query->where('show_on_home', true);
    }
}