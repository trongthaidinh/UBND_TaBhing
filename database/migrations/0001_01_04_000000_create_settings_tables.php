<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // System-wide configurations
        Schema::create('system_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Homepage block configurations
        Schema::create('homepage_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // e.g., 'slider', 'news', 'banner', 'video'
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('configuration')->nullable();
            $table->timestamps();
        });

        // External links and integrations
        Schema::create('external_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // RSS Feed configurations
        Schema::create('rss_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rss_feeds');
        Schema::dropIfExists('external_links');
        Schema::dropIfExists('homepage_blocks');
        Schema::dropIfExists('system_configurations');
    }
};