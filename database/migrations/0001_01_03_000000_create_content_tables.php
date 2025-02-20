<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories for content classification
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Posts/Articles table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable(); // Added featured image column
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('author_id');
            $table->enum('status', ['draft', 'pending', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('author_id')->references('id')->on('users');
            
            $table->timestamps();
        });

        // Approval workflow
        Schema::create('post_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('comments')->nullable();
            
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
        });

        // Metadata for different content types
        Schema::create('content_metadata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('department')->nullable(); // Phòng ban chuyên môn
            $table->string('field')->nullable(); // Lĩnh vực
            $table->json('additional_info')->nullable(); // Thông tin bổ sung
            
            $table->foreign('post_id')->references('id')->on('posts');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_metadata');
        Schema::dropIfExists('post_approvals');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
};