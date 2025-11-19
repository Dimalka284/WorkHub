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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id('jobPostId');
            $table->unsignedBigInteger('client_id');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->string('project_length');
            $table->decimal('budget', 10, 2);
            $table->string('payment_preference');
            $table->timestamps();
            $table->foreign('client_id')->references('clientId')->on('clients')->onDelete('cascade');
            $table->foreign('category_id')->references('categoryId')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
