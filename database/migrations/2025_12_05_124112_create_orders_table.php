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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gig_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('freelancer_id');
            $table->enum('status', [
                'pending', 
                'accepted', 
                'rejected', 
                'in_progress', 
                'delivered', 
                'completed', 
                'revision_requested'
            ])->default('pending');
            $table->text('requirements');
            $table->decimal('budget', 10, 2)->nullable();
            $table->dateTime('deadline')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('gig_id')->references('id')->on('gigs')->onDelete('cascade');
            $table->foreign('client_id')->references('clientId')->on('clients')->onDelete('cascade');
            $table->foreign('freelancer_id')->references('freelancerId')->on('freelancer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
