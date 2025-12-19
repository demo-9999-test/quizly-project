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
        if (!Schema::hasTable('objective_answers')) {
            Schema::create('objective_answers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('quiz_id');
                $table->unsignedBigInteger('question_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('quiz_id')->references('id')->on('quizes');
                $table->foreign('question_id')->references('id')->on('objectives');
                $table->string('user_answer')->nullable();
                $table->string('correct_answer');
                $table->string('question_type');
                $table->boolean('answer_approved')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objective_answers');
    }
};
