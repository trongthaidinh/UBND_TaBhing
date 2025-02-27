<?php

namespace App\Providers;

use App\Models\AccessStatistic;
use App\Models\Category;
use App\Models\Post;
use App\Services\RssImportService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // if (config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }
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

            // Fetch document posts
            $documentCategory = Category::where('slug', 'van-ban')->first();
            $documentPosts = collect();

            if ($documentCategory) {
                $documentPosts = Post::where('category_id', $documentCategory->id)
                    ->where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->take(5)
                    ->get();
            }

            // Share data with the view
            $view->with([
                'notifications' => $notifications,
                'documentPosts' => $documentPosts,
                'todayVisits' => $visitorStats['today_visits'],
                'totalVisits' => $visitorStats['total_visits']
            ]);
        });
    }
}
