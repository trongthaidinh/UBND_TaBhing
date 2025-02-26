<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Quan hệ với Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // Đặt mật khẩu với hash
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Kiểm tra quyền
    public function hasRole($roleCode)
    {
        return $this->roles->contains('code', $roleCode);
    }

    public function hasPermission($permission)
    {
        return $this->roles->contains(function ($role) use ($permission) {
            return $role->hasPermission($permission);
        });
    }

    // Kiểm tra quyền admin
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
