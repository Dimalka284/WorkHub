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
        Schema::create('gigs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('freelancer_id'); // owner of gig
        $table->string('display_name');
        $table->string('profileimg')->nullable();
        $table->text('description');
        $table->string('college')->nullable();
        $table->string('linkedin')->nullable();
        $table->string('git')->nullable();
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gig');
    }
};
