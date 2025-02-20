<?php

namespace App\Http\Controllers;

use App\Models\RssFeed;
use App\Models\Category;
use App\Services\RssImportService;
use Illuminate\Http\Request;

class RssFeedController extends Controller
{
    // Sử dụng dependency injection đúng cách
    public function __construct(
        protected RssImportService $rssFeedService
    ) {}

    public function index()
    {
        $rssFeeds = RssFeed::latest()->paginate(10);
        return view('admin.rss-feeds.index', compact('rssFeeds'));
    }

    public function create()
    {
        // Lấy danh sách categories
        $categories = Category::all();
        return view('admin.rss-feeds.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:rss_feeds,url',
            'category' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        RssFeed::create($validated);

        return redirect()->route('admin.rss-feeds.index')
            ->with('success', 'RSS Feed đã được thêm mới');
    }

    public function edit(RssFeed $rssFeed)
    {
        // Lấy danh sách categories
        $categories = Category::all();
        return view('admin.rss-feeds.edit', compact('rssFeed', 'categories'));
    }

    public function update(Request $request, RssFeed $rssFeed)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|unique:rss_feeds,url,' . $rssFeed->id,
            'category' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        $rssFeed->update($validated);

        return redirect()->route('admin.rss-feeds.index')
            ->with('success', 'RSS Feed đã được cập nhật');
    }

    public function destroy(RssFeed $rssFeed)
    {
        $rssFeed->delete();

        return redirect()->route('admin.rss-feeds.index')
            ->with('success', 'RSS Feed đã được xóa');
    }

    public function import(RssFeed $rssFeed)
    {
        try {
            $result = $this->rssImportService->importFromRssFeed($rssFeed);

            return redirect()->route('admin.rss-feeds.index')
                ->with('success', $result 
                    ? 'Import RSS thành công' 
                    : 'Không thể import RSS');
        } catch (\Exception $e) {
            return redirect()->route('admin.rss-feeds.index')
                ->with('error', 'Lỗi import RSS: ' . $e->getMessage());
        }
    }

    public function generateRssFeed()
    {
        $rssFeed = $this->rssFeedService->generateRssFeed();
        
        return response($rssFeed, 200, [
            'Content-Type' => 'application/rss+xml; charset=utf-8'
        ]);
    }
}