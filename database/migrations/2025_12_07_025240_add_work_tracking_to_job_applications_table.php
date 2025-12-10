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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->enum('work_status', ['not_started', 'in_progress', 'submitted', 'revision_requested', 'completed'])
                  ->default('not_started')
                  ->after('status');
            $table->integer('revisions_used')->default(0)->after('work_status');
            $table->integer('max_revisions')->default(3)->after('revisions_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['work_status', 'revisions_used', 'max_revisions']);
        });
    }
};
