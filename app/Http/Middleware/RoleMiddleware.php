<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$requiredPermissions)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            // Chuyển hướng đến trang đăng nhập với thông báo
            return redirect()->route('login')
                ->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
        }

        $user = Auth::user();
        $user->load('roles');

        // Nếu user không có roles
        if ($user->roles->isEmpty()) {
            return redirect()->route('login')
                ->with('error', 'Tài khoản của bạn chưa được phân quyền.');
        }

        // Kiểm tra quyền với nhiều role
        $hasPermission = collect($requiredPermissions)->contains(function ($requiredPermission) use ($user) {
            return $user->roles->contains(function ($role) use ($requiredPermission) {
                // Thêm debug log
                Log::info('Checking role', [
                    'role_code' => $role->code,
                    'required_permission' => $requiredPermission,
                    'can_manage_content' => $role->can_manage_content,
                    'can_manage_configuration' => $role->can_manage_configuration,
                    'can_manage_users' => $role->can_manage_users
                ]);

                switch ($requiredPermission) {
                    case 'admin':
                        return $role->can_manage_configuration 
                            && $role->can_manage_content 
                            && $role->can_manage_users;
                    case 'editor':
                        return $role->can_manage_content 
                            && !$role->can_manage_configuration 
                            && !$role->can_manage_users;
                    case 'content':
                        return $role->can_manage_content;
                    case 'configuration':
                        return $role->can_manage_configuration;
                    default:
                        return $role->code === $requiredPermission;
                }
            });
        });

        // Nếu không có quyền
        if (!$hasPermission) {
            // Thêm debug log
            Log::info('Access denied', [
                'user_id' => $user->id,
                'user_roles' => $user->roles->pluck('code'),
                'required_permissions' => $requiredPermissions
            ]);

            return redirect()->route('home')
                ->with('error', 'Bạn không có quyền truy cập trang quản trị.');
        }

        return $next($request);
    }
}