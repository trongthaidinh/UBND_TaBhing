<?php

namespace App\Http\Controllers;

use App\Models\AccessStatistic;
use App\Models\Post;
use App\Models\PhotoLibrary;
use App\Models\Video;
use App\Models\ExternalLink;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Access Statistics
        $statistics = AccessStatistic::getStatistics();

        // Content Statistics
        $contentStats = [
            'posts' => [
                'total' => Post::count(),
                'recent' => Post::where('created_at', '>=', now()->subDays(7))->count(),
                'published' => Post::where('status', 'published')->count()
            ],
            'photos' => [
                'total' => PhotoLibrary::count(),
                'published' => PhotoLibrary::where('status', 'published')->count()
            ],
            'videos' => [
                'total' => Video::count(),
                'published' => Video::where('status', 'published')->count()
            ],
            'links' => [
                'total' => ExternalLink::count(),
                'active' => ExternalLink::where('is_active', true)->count()
            ]
        ];

        // Monthly Content Trend
        $monthlyContentTrend = [
            'posts' => Post::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count')
                ->toArray(),
            'photos' => PhotoLibrary::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count')
                ->toArray(),
            'videos' => Video::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count')
                ->toArray()
        ];

        return view('admin.dashboard.index', [
            'todayVisits' => $statistics['today_visits'],
            'totalVisits' => $statistics['total_visits'],
            'contentStats' => $contentStats,
            'monthlyContentTrend' => $monthlyContentTrend
        ]);
    }
}