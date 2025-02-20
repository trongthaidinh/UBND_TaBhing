<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    // Tắt timestamps nếu không muốn sử dụng
    public $timestamps = true;

    // Cho phép mass assignment
    protected $fillable = [
        'rss_feed_id',      // Liên kết nguồn RSS
        'title',            // Tiêu đề tin
        'slug',             // Đường dẫn thân thiện
        'description',      // Mô tả ngắn
        'content',          // Nội dung đầy đủ
        'image_url',        // Ảnh đại diện
        'original_link',    // Liên kết gốc
        'author',           // Tác giả
        'published_at',     // Ngày xuất bản
        'source',           // Nguồn tin
        'category',         // Danh mục
        'is_featured',      // Tin nổi bật
        'view_count',       // Số lượt xem
        'meta_keywords',    // Từ khóa SEO
        'meta_description', // Mô tả SEO
    ];

    // Các trường ngày tháng
    protected $dates = ['published_at'];

    // Các thuộc tính được cast
    protected $casts = [
        'is_featured' => 'boolean',
        'view_count' => 'integer'
    ];

    // Tự động tạo slug khi set tiêu đề
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Quan hệ với RSS Feed
    public function rssFeed(): BelongsTo
    {
        return $this->belongsTo(RssFeed::class);
    }

    // Scope lấy tin mới nhất
    public function scopeLatestNews($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    // Scope tin nổi bật
    public function scopeFeaturedNews($query, $limit = 5)
    {
        return $query->where('is_featured', true)
                     ->orderBy('published_at', 'desc')
                     ->limit($limit);
    }

    // Scope theo danh mục
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Tăng lượt xem
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    // Lấy ảnh đại diện
    public function getThumbnailAttribute()
    {
        return $this->image_url ?? asset('images/default-news.jpg');
    }

    // Rút trích đoạn ngắn
    public function getExcerptAttribute()
    {
        return Str::limit($this->description, 150);
    }
}