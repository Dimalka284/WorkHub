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
        Schema::create('job_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_application_id');
            $table->string('delivery_url')->nullable();
            $table->json('delivery_files')->nullable();
            $table->text('delivery_message')->nullable();
            $table->integer('revision_number')->default(0);
            $table->enum('status', ['pending', 'accepted', 'revision_requested'])->default('pending');
            $table->timestamps();
            
            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_deliveries');
    }
};
