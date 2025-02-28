<?php

namespace Database\Seeders;

use App\Models\HomepageBlock;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomepageBlockSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete existing homepage blocks
        DB::table('homepage_blocks')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get the IDs of the first 3 published posts
        $postIds = DB::table('posts')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->pluck('id')
            ->toArray();

        // Create initial homepage blocks
        $blocks = [
            [
                'name' => 'Tin tức nổi bật',
                'type' => 'slider',
                'display_order' => 1,
                'is_active' => true,
                'configuration' => json_encode([
                    'type' => 'post_slider',
                    'post_ids' => $postIds
                ])
            ],
            [
                'name' => 'Tin tức mới nhất',
                'type' => 'news',
                'display_order' => 2,
                'is_active' => true,
                'configuration' => json_encode([
                    'items_to_show' => 6,
                    'category_filter' => null
                ])
            ],
            [
                'name' => 'Liên kết nhanh',
                'type' => 'quick_access',
                'display_order' => 3,
                'is_active' => true,
                'configuration' => json_encode([
                    'links' => [
                        'Dịch vụ trực tuyến' => '#',
                        'Tra cứu hồ sơ' => '#',
                        'Hỗ trợ doanh nghiệp' => '#'
                    ]
                ])
            ],
            [
                'name' => 'Tuyên truyền Xã Tà Bhing',
                'type' => 'banner',
                'display_order' => 1,
                'is_active' => true,
                'configuration' => json_encode([
                    'image_path' => 'images/banerxoanhatam1.png',
                    'description' => 'Thông tin tuyên truyền về phát triển kinh tế - xã hội của xã Tà Bhing',
                    'link_url' => 'https://dichvucong.quangnam.gov.vn/'
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        // Insert blocks
        foreach ($blocks as $blockData) {
            HomepageBlock::create($blockData);
        }
    }
}
