<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    // Phương thức kiểm tra duyệt bài
    public function approve(User $user, Post $post)
    {
        // Chỉ admin mới được duyệt bài
        return $user->hasRole('admin');
    }

    // Các phương thức khác nếu cần
    public function update(User $user, Post $post)
    {
        // Chỉ admin hoặc tác giả mới được sửa
        return $user->hasRole('admin') || 
               $user->id === $post->author_id;
    }

    public function delete(User $user, Post $post)
    {
        // Chỉ admin mới được xóa
        return $user->hasRole('admin');
    }
}