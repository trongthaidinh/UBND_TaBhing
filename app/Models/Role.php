<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'code', 
        'can_manage_configuration', 
        'can_manage_content', 
        'can_manage_users', 
        'permissions', 
        'description',
        'is_default'
    ];

    protected $casts = [
        'can_manage_configuration' => 'boolean',
        'can_manage_content' => 'boolean',
        'can_manage_users' => 'boolean',
        'permissions' => 'array',
        'is_default' => 'boolean'
    ];

    // Quan hệ với User
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    // Kiểm tra quyền
    public function hasPermission($permission)
    {
        // Kiểm tra full access
        if (isset($this->permissions['full_access']) && $this->permissions['full_access'] === true) {
            return true;
        }

        // Kiểm tra theo các trường boolean cũ
        switch ($permission) {
            case 'admin':
                return $this->can_manage_configuration 
                    && $this->can_manage_content 
                    && $this->can_manage_users;
            case 'content':
                return $this->can_manage_content;
            case 'users':
                return $this->can_manage_users;
            case 'configuration':
                return $this->can_manage_configuration;
            default:
                // Kiểm tra trong trường permissions động
                return isset($this->permissions[$permission]) 
                    && $this->permissions[$permission] === true;
        }
    }

    // Scope query cho các vai trò mặc định
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}