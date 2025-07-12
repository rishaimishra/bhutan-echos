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
        Schema::create('live_quiz_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('live_quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('live_quiz_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('selected_answer_id')->constrained('live_quiz_answers')->onDelete('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
            
            // Prevent duplicate responses from same user for same question
            $table->unique(['user_id', 'live_quiz_question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_quiz_responses');
    }
};
