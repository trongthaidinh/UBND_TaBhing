<?php
// 0001_01_05_000000_create_contact_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Contact form submissions
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->enum('status', ['new', 'in_progress', 'resolved'])->default('new');
            $table->unsignedBigInteger('assigned_to')->nullable();
            
            $table->foreign('assigned_to')->references('id')->on('users');
            
            $table->timestamps();
        });

        // Feedback and suggestions
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type'); // e.g., 'service_evaluation', 'administrative_regulation'
            $table->text('content');
            $table->enum('status', ['submitted', 'under_review', 'resolved'])->default('submitted');
            $table->json('metadata')->nullable();
            
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('contact_submissions');
    }
};