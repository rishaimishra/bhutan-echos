<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('author_sessions');
            $table->foreignId('user_id')->constrained('users');
            $table->text('question');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_questions');
    }
}; 