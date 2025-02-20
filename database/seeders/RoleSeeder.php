<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Xóa các vai trò cũ
        Role::query()->delete();

        // Vai trò quản trị hệ thống
        Role::create([
            'name' => 'Quản trị viên hệ thống',
            'code' => 'system_admin',
            'can_manage_configuration' => true,
            'can_manage_content' => true,
            'can_manage_users' => true,
            'permissions' => [
                'full_access' => true,
                'dashboard_access' => true,
                'advanced_settings' => true,
                'admin' => true,
                'content' => true,
                'users' => true,
                'configuration' => true
            ],
            'description' => 'Người dùng có toàn quyền quản trị hệ thống'
        ]);

        // Vai trò admin
        Role::create([
            'name' => 'Admin',
            'code' => 'admin',
            'can_manage_configuration' => true,
            'can_manage_content' => true,
            'can_manage_users' => true,
            'permissions' => [
                'admin' => true,
                'content' => true,
                'users' => true,
                'configuration' => true
            ],
            'description' => 'Quản trị viên'
        ]);

        // Vai trò biên tập viên
        Role::create([
            'name' => 'Biên tập viên',
            'code' => 'editor',
            'can_manage_content' => true,
            'can_manage_configuration' => false,
            'can_manage_users' => false,
            'permissions' => [
                'content_create' => true,
                'content_edit' => true,
                'content_view' => true,
                'content_approve' => false
            ],
            'description' => 'Người có quyền soạn và chỉnh sửa bài viết'
        ]);
    }
}