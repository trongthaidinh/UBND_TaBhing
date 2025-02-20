<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\TrackWebsiteVisits;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ImportRssFeeds;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            // Middleware web toàn cục
            \Illuminate\Http\Middleware\HandleCors::class,
            TrackWebsiteVisits::class,
        ])->api(append: [
            // Middleware API
        ]);

        // Đăng ký middleware role
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Xử lý ngoại lệ Authentication
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            // Nếu là request API, trả về JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'redirect' => route('login')
                ], 401);
            }
    
            // Chuyển hướng đến trang đăng nhập với thông báo
            return redirect()->route('login')
                ->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
        });
    
        // Xử lý lỗi 403 (Forbidden)
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            // Nếu là request API, trả về JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Bạn không có quyền truy cập.',
                    'redirect' => route('home')
                ], 403);
            }
    
            // Chuyển hướng về trang chủ với thông báo
            return redirect()->route('home')
                ->with('error', 'Bạn không có quyền truy cập trang này.');
        });
    })
// Thêm đoạn code schedule vào đây
    ->withSchedule(function (Schedule $schedule) {
        // Import RSS hàng giờ
        $schedule->command('rss:import')->hourly();

        // Hoặc có thể cấu hình chi tiết hơn
        $schedule->command('rss:import')
            ->hourly()
            ->between('6:00', '22:00')
            ->withoutOverlapping()
            ->runInBackground();
    })
    // Khởi tạo ứng dụng
    ->create();