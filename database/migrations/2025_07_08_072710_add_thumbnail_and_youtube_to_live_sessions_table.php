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
        Schema::table('live_sessions', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('end_time');
            $table->string('youtube_link')->nullable()->after('thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_sessions', function (Blueprint $table) {
            $table->dropColumn(['thumbnail', 'youtube_link']);
        });
    }
};
