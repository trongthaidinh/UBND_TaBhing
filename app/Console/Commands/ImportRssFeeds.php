<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RssFeed;
use App\Services\RssImportService;

class ImportRssFeeds extends Command
{
    protected $signature = 'rss:import';
    protected $description = 'Import posts from active RSS feeds';

    public function __construct(
        protected RssImportService $rssFeedService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy các RSS feed đang hoạt động
        $rssFeeds = RssFeed::where('is_active', true)->get();

        foreach ($rssFeeds as $rssFeed) {
            $importedCount = $this->rssFeedService->importFromRssFeed($rssFeed);
            
            if ($importedCount) {
                $this->info("Imported {$importedCount} news from {$rssFeed->name}");
            } else {
                $this->warn("No news imported from {$rssFeed->name}");
            }
        }

        return 0;
    }
}