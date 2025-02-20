<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SystemConfiguration;

class SystemConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        DB::table('system_configurations')->delete();
        DB::table('homepage_blocks')->delete();
        DB::table('external_links')->delete();
        DB::table('rss_feeds')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // System Configurations
        $systemConfigurations = [
            [
                'key' => 'site_name',
                'value' => 'Cổng thông tin UBND',
                'group' => 'general',
                'description' => 'Tên website chính thức'
            ],
            [
                'key' => 'site_description',
                'value' => 'Cổng thông tin điện tử của Ủy ban nhân dân',
                'group' => 'general',
                'description' => 'Mô tả ngắn về website'
            ],
            [
                'key' => 'contact_email',
                'value' => 'lienhe@ubnd.gov.vn',
                'group' => 'contact',
                'description' => 'Địa chỉ email liên hệ chính thức'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'group' => 'system',
                'description' => 'Chế độ bảo trì của hệ thống'
            ]
        ];
        DB::table('system_configurations')->insert($systemConfigurations);

        // Homepage Blocks
        $homepageBlocks = [
            [
                'name' => 'Slider Banner',
                'type' => 'slider',
                'display_order' => 1,
                'is_active' => true,
                'configuration' => json_encode([
                    'slides' => [
                        ['title' => 'Slide 1', 'image' => '', 'link' => '#'],
                        ['title' => 'Slide 2', 'image' => '', 'link' => '#']
                    ]
                ])
            ],
            [
                'name' => 'Tin mới nhất',
                'type' => 'news',
                'display_order' => 2,
                'is_active' => true,
                'configuration' => json_encode([
                    'count' => 10,
                    'categories' => ['tin-tuc', 'su-kien']
                ])
            ],
            [
                'name' => 'Video nổi bật',
                'type' => 'video',
                'display_order' => 3,
                'is_active' => true,
                'configuration' => json_encode([
                    'count' => 5,
                    'category' => 'video-noi-bat'
                ])
            ]
        ];
        DB::table('homepage_blocks')->insert($homepageBlocks);

        // External Links
        $externalLinks = [
            [
                'name' => 'Cổng thông tin Chính phủ',
                'url' => 'https://chinhphu.vn',
                'category' => 'chính phủ',
                'is_active' => true
            ],
            [
                'name' => 'Bộ Nội vụ',
                'url' => 'https://moha.gov.vn',
                'category' => 'chính phủ',
                'is_active' => true
            ]
        ];
        DB::table('external_links')->insert($externalLinks);

        // RSS Feeds
        $rssFeeds = [
            [
                'name' => 'Tin tức Chính phủ',
                'url' => 'https://chinhphu.vn/rss',
                'category' => 'tin tức chính thức',
                'is_active' => true
            ],
            [
                'name' => 'Thông báo Bộ Nội vụ',
                'url' => 'https://moha.gov.vn/rss',
                'category' => 'thông báo',
                'is_active' => true
            ]
        ];
        DB::table('rss_feeds')->insert($rssFeeds);
    }
}