<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('clientId'); 
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profilePic')->nullable();
            $table->string('companyName')->nullable();
            $table->text('companyDescription')->nullable(); 

            $table->unsignedBigInteger('industryId')->nullable();

            // foreign key
            $table->foreign('industryId')
                  ->references('industryId')
                  ->on('industries')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients'); 
    }
};
