<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'document'
    ];

    protected $dates = ['published_at', 'created_at', 'updated_at'];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'string'
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với User (Author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Quan hệ với PostApproval
    public function approvals()
    {
        return $this->hasMany(PostApproval::class);
    }

    // Quan hệ với ContentMetadata
    public function metadata()
    {
        return $this->hasOne(ContentMetadata::class);
    }

    // Scope cho các trạng thái bài viết
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Kiểm tra trạng thái bài viết
    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Setter cho published_at
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ? Carbon::parse($value) : null;
    }

    // Getter cho trạng thái hiển thị
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Nháp',
            'pending' => 'Chờ duyệt',
            'published' => 'Đã xuất bản',
            'archived' => 'Đã lưu trữ'
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}
