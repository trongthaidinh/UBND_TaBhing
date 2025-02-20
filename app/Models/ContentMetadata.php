<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 
        'department', 
        'field', 
        'additional_info'
    ];

    protected $casts = [
        'additional_info' => 'array'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}