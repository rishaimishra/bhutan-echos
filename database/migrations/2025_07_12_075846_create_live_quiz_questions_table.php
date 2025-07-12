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
        Schema::create('live_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_quiz_id')->constrained('live_quizzes')->onDelete('cascade');
            $table->text('question');
            $table->string('question_type')->default('multiple_choice'); // multiple_choice, true_false, etc.
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_quiz_questions');
    }
};
