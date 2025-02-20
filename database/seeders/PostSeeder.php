<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing records
        DB::table('posts')->delete();

        // Get or create a default category
        $category = Category::firstOrCreate([
            'name' => 'Tin tức chung',
            'slug' => 'tin-tuc-chung'
        ]);

        // Get an admin user or create one
        $author = User::firstOrCreate([
            'email' => 'admin@ubnd.gov.vn'
        ], [
            'name' => 'Quản trị viên',
            'password' => bcrypt('password')
        ]);

        // Slider Posts with featured images
        $sliderPosts = [
            [
                'title' => 'Chuyển đổi số - Bước tiến quan trọng của chính quyền điện tử',
                'excerpt' => 'Chuyển đổi số đang là xu thế quan trọng trong việc nâng cao hiệu quả quản lý và phục vụ người dân.',
                'featured_image' => 'uploads/posts/chuyen-doi-so.jpg',
                'status' => 'published',
                'published_at' => Carbon::now(),
            ],
            [
                'title' => 'Triển khai dịch vụ công trực tuyến mức độ 4',
                'excerpt' => 'Hướng tới mục tiêu giảm thời gian, chi phí và tăng trải nghiệm người dùng trong các dịch vụ hành chính.',
                'featured_image' => 'uploads/posts/dich-vu-cong.jpg',
                'status' => 'published',
                'published_at' => Carbon::now(),
            ],
            [
                'title' => 'Tăng cường ứng dụng công nghệ thông tin trong quản trị',
                'excerpt' => 'Ứng dụng CNTT giúp nâng cao tính minh bạch và hiệu quả trong công tác quản lý nhà nước.',
                'featured_image' => 'uploads/posts/ung-dung-cntt.jpg',
                'status' => 'published',
                'published_at' => Carbon::now(),
            ]
        ];

        // Insert slider posts
        foreach ($sliderPosts as $postData) {
            DB::table('posts')->insert([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => '<p>' . $postData['excerpt'] . '</p>',
                'category_id' => $category->id,
                'author_id' => $author->id,
                'featured_image' => $postData['featured_image'],
                'status' => $postData['status'],
                'published_at' => $postData['published_at'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}