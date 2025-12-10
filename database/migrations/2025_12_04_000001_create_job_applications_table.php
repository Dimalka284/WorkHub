<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('freelancer_id');
            $table->text('cover_letter');
            $table->decimal('proposed_rate', 10, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->foreign('job_post_id')->references('jobPostId')->on('job_posts')->onDelete('cascade');
            $table->foreign('freelancer_id')->references('freelancerId')->on('freelancer')->onDelete('cascade');
            
            // Prevent duplicate applications
            $table->unique(['job_post_id', 'freelancer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
