<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageBlock extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'homepage_blocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'display_order',
        'is_active',
        'configuration'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'configuration' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Scope a query to only include active homepage blocks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order blocks by display order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    // Get blocks by type
    public static function getByType($type)
    {
        return self::where('type', $type)
                   ->where('is_active', true)
                   ->orderBy('display_order')
                   ->get();
    }

    // Update block configuration
    public function updateConfiguration($key, $value)
    {
        $config = $this->configuration ?? [];
        $config[$key] = $value;
        $this->configuration = $config;
        $this->save();
    }

    // Predefined block types
    public static function getBlockTypes()
    {
        return [
            'slider' => 'Slider Banner',
            'news' => 'Tin tức',
            'banner' => 'Banner',
            'video' => 'Video',
            'quick_access' => 'Truy cập nhanh',
            'links' => 'Liên kết'
        ];
    }
}