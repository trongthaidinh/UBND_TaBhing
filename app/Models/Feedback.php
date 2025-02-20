<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'type', 
        'content', 
        'status', 
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for different feedback types
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope for feedback status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Method to add additional metadata
    public function addMetadata($key, $value)
    {
        $metadata = $this->metadata ?? [];
        $metadata[$key] = $value;
        $this->metadata = $metadata;
        $this->save();
    }
}