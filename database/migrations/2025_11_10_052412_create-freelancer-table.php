<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancer', function (Blueprint $table) {
            $table->id('freelancerId'); 
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profilePic')->nullable();
            $table->string('bio')->nullable();
            $table->text('linkedInProfile')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancer'); 
    }
};
