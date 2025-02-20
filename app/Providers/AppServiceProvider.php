<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\RssImportService;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Post;
use App\Models\AccessStatistic;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RssImportService::class, function ($app) {
            return new RssImportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set global pagination view
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        // Optional: Customize pagination
        Paginator::currentPathResolver(function () {
            return url(request()->path());
        });

        // View Composer for sidebar data
        View::composer('layouts.app', function ($view) {
            // Fetch notifications from 'thong-bao' category
            $notificationsCategory = Category::where('slug', 'thong-bao')->first();
            $notifications = collect();

            if ($notificationsCategory) {
                $notifications = Post::where('category_id', $notificationsCategory->id)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            }

            // Fetch visitor statistics
            $visitorStats = AccessStatistic::getStatistics();

            // Share data with the view
            $view->with([
                'notifications' => $notifications,
                'todayVisits' => $visitorStats['today_visits'],
                'totalVisits' => $visitorStats['total_visits']
            ]);
        });
    }
}
