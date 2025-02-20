<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExternalLinkSeeder extends Seeder
{
    public function run()
    {
        DB::table('external_links')->insert([
            [
                'name' => 'Trang Thông Tin Điện Tử Quảng Nam',
                'url' => 'https://quangnam.gov.vn/',
                'category' => 'government',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cổng Dịch Vụ Công Quốc Gia',
                'url' => 'https://dichvucong.gov.vn/',
                'category' => 'service',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'UBND Huyện Nam Giang',
                'url' => 'https://namgiang.quangnam.gov.vn/',
                'category' => 'local',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bảo Hiểm Xã Hội Việt Nam',
                'url' => 'https://baohiem.vn/',
                'category' => 'service',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cổng Thông Tin Điện Tử Chính Phủ',
                'url' => 'https://chinhphu.vn/',
                'category' => 'government',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}