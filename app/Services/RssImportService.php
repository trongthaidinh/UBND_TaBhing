<?php

namespace App\Services;

use App\Models\RssFeed;
use App\Models\News;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use SimpleXMLElement;

class RssImportService
{
    public function importFromRssFeed(RssFeed $rssFeed)
    {
        try {
            Log::info("Importing from RSS feed: {$rssFeed->name}");
            Log::info("RSS Feed URL: {$rssFeed->url}");

            // More robust XML fetching
            $xmlContent = $this->fetchXmlContent($rssFeed->url);
            
            if (empty($xmlContent)) {
                Log::error("Empty RSS feed content for: {$rssFeed->name}");
                return 0;
            }

            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($xmlContent);
            
            if ($xml === false) {
                $errors = libxml_get_errors();
                Log::error("XML Parsing errors for {$rssFeed->name}:");
                foreach ($errors as $error) {
                    Log::error($error->message);
                }
                libxml_clear_errors();
                return 0;
            }

            // Validate RSS structure
            if (!isset($xml->channel)) {
                Log::error("Invalid RSS feed structure for: {$rssFeed->name}");
                return 0;
            }

            $namespaces = $xml->getNamespaces(true);
            $importedCount = 0;

            foreach ($xml->channel->item as $item) {
                $link = (string)($item->link ?? $item->guid ?? '');
                
                if (empty($link)) {
                    Log::warning("Skipping item without link in {$rssFeed->name}");
                    continue;
                }

                // Kiểm tra trùng lặp
                if (News::where('original_link', $link)->exists()) {
                    Log::info("Skipping duplicate news: {$link}");
                    continue;
                }

                // Trích xuất ảnh từ description
                preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', (string)$item->description, $image);
                $imageUrl = $image['src'] ?? null;

                $newsData = [
                    'rss_feed_id' => $rssFeed->id,
                    'title' => (string)($item->title ?? 'Không có tiêu đề'),
                    'description' => strip_tags((string)($item->description ?? '')),
                    'content' => (string)($item->description ?? ''),
                    'original_link' => $link,
                    'author' => 'Quảng Nam',
                    'published_at' => Carbon::parse((string)($item->pubDate ?? now())),
                    'image_url' => $imageUrl,
                    'category' => 'Tin tức',
                    'source' => $rssFeed->name,
                    'is_featured' => false,
                ];

                try {
                    News::create($newsData);
                    $importedCount++;
                    Log::info("Imported news item: {$newsData['title']}");
                } catch (\Exception $createError) {
                    Log::error("Error creating news item: " . $createError->getMessage());
                    Log::error("News data: " . json_encode($newsData));
                }
            }

            // Cập nhật thông tin RSS Feed
            $rssFeed->update([
                'last_fetched_at' => now(),
                'total_imported_posts' => ($rssFeed->total_imported_posts ?? 0) + $importedCount
            ]);

            Log::info("Imported {$importedCount} news from {$rssFeed->name}");
            return $importedCount;

        } catch (\Exception $e) {
            Log::error('RSS Import Error for ' . $rssFeed->name . ': ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return 0;
        }
    }

    private function fetchXmlContent(string $url)
    {
        try {
            // Multiple fallback methods for fetching XML
            $methods = [
                fn() => file_get_contents($url),
                fn() => Http::timeout(30)->get($url)->body(),
                fn() => $this->curlFetch($url)
            ];

            foreach ($methods as $method) {
                try {
                    $content = $method();
                    if (!empty($content)) {
                        return $content;
                    }
                } catch (\Exception $e) {
                    Log::warning("XML fetch method failed: " . $e->getMessage());
                }
            }

            Log::error("All XML fetch methods failed for URL: {$url}");
            return null;
        } catch (\Exception $e) {
            Log::error("Fatal error in XML fetching: " . $e->getMessage());
            return null;
        }
    }

    private function curlFetch(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error("cURL error: {$error}");
            return null;
        }

        return $result;
    }
}