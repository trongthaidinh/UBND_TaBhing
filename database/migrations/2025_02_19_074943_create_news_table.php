<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            
            // Liên kết với RSS Feed (tùy chọn)
            $table->foreignId('rss_feed_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Thông tin cơ bản
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();

            // Thông tin bổ sung
            $table->string('image_url')->nullable();
            $table->string('original_link')->nullable()->unique();
            $table->string('author')->nullable();
            $table->timestamp('published_at')->nullable();
            
            // Phân loại và nguồn
            $table->string('source')->nullable();
            $table->string('category')->nullable();
            
            // Các trường bổ sung
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            
            // SEO
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            // Indexes để tối ưu truy vấn
            $table->index(['published_at', 'is_featured']);
            $table->index('category');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};