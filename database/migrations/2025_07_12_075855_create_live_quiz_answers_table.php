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
        Schema::create('live_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_quiz_question_id')->constrained('live_quiz_questions')->onDelete('cascade');
            $table->text('answer');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_quiz_answers');
    }
};
