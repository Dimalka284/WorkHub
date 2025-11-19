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
        Schema::create('job_post_skill', function (Blueprint $table) {
            $table->unsignedBigInteger('job_post_id');
            $table->unsignedBigInteger('skill_id');

            $table->foreign('job_post_id')->references('jobPostId')->on('job_posts')->onDelete('cascade');
            $table->foreign('skill_id')->references('skillId')->on('skills')->onDelete('cascade');

            $table->primary(['job_post_id', 'skill_id']); // composite primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_skill');
    }
};
