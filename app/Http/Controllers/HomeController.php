<?php

namespace App\Http\Controllers;

use App\Models\SystemConfiguration;
use App\Models\HomepageBlock;
use App\Models\Post;
use App\Models\Category;
use App\Models\Video;
use App\Models\PhotoLibrary;
use App\Models\AccessStatistic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Get categories explicitly allowed on home page
        $homeCategories = Category::where('show_on_home', true)->pluck('id');

        // If no categories are set to show on home, return empty collections
        if ($homeCategories->isEmpty()) {
            return view('home', [
                'latestPosts' => collect(),
                'featuredPosts' => collect()
            ]);
        }

        // Fetch latest posts from home-visible categories
        $latestPosts = Post::whereIn('category_id', $homeCategories)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->with('category')
            ->paginate(6);

        // Featured posts from home-visible categories
        $featuredPosts = Post::whereIn('category_id', $homeCategories)
            ->where('status', 'published')
            ->where('featured_image', '!=', null)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Fetch slider blocks
        $sliderBlocks = HomepageBlock::where('type', 'slider')
            ->where('is_active', true)
            ->first();

        // Fetch news blocks
        $newsLatestBlocks = HomepageBlock::where('type', 'news_lastest')
            ->where('is_active', true)
            ->first();

        // Fetch active banner
        $banner = HomepageBlock::where('type', 'banner')
            ->where('is_active', true)
            ->orderBy('display_order')
            ->first();

        // Fetch categories with their posts
        $categories = Category::where('show_on_home', true)
            ->with(['posts' => function($query) {
                $query->where('status', 'published')
                      ->latest()
                      ->take(3);
            }])
            ->get()
            // Filter out categories with no posts
            ->filter(function($category) {
                return $category->posts->count() > 0;
            });

        // Fetch videos and photo library
        $videos = Video::published()->latest()->take(3)->get();
        $photoLibrary = PhotoLibrary::published()->latest()->take(4)->get();

        // Pass data to the view
        return view('home', [   
            'sliderBlocks' => $sliderBlocks,
            'newsLatestBlocks' => $newsLatestBlocks,  
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'videos' => $videos,
            'photoLibrary' => $photoLibrary,
            'banner' => $banner,
            'featuredPosts' => $featuredPosts
        ]);
    }
}