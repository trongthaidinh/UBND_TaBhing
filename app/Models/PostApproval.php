<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 
        'user_id', 
        'status', 
        'comments'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}