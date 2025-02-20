<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete existing categories
        DB::table('categories')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create categories based on the requirements
        $categories = [
            [
                'name' => 'Tin tức sự kiện',
                'slug' => 'tin-tuc-su-kien',
                'description' => 'Các tin tức và sự kiện mới nhất',
                'type' => 'tin_tuc_su_kien'
            ],
            [
                'name' => 'Quy hoạch và phát triển',
                'slug' => 'quy-hoach-phat-trien',
                'description' => 'Thông tin về quy hoạch và phát triển',
                'type' => 'quy_hoach_phat_trien'
            ],
            [
                'name' => 'Thông tin tuyên truyền',
                'slug' => 'thong-tin-tuyen-truyen',
                'description' => 'Các thông tin tuyên truyền',
                'type' => 'thong_tin_tuyen_truyen'
            ],
            [
                'name' => 'Giới thiệu',
                'slug' => 'gioi-thieu',
                'description' => 'Thông tin giới thiệu về địa phương',
                'type' => 'gioi_thieu'
            ],
            [
                'name' => 'Chỉ đạo điều hành',
                'slug' => 'chi-dao-dieu-hanh',
                'description' => 'Các thông tin về chỉ đạo và điều hành',
                'type' => 'chi_dao_dieu_hanh'
            ]
        ];

        // Insert categories
        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}