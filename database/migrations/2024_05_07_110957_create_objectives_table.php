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
        if(!Schema::hasTable('objectives')){
            Schema::create('objectives', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->string('option_a')->nullable();
                $table->string('option_b')->nullable();
                $table->string('option_c')->nullable();
                $table->string('option_d')->nullable();
                $table->string('correct_answer');
                $table->string('video')->nullable();
                $table->string('audio')->nullable();
                $table->string('image')->nullable();
                $table->string('ques_type');
                $table->integer('mark')->default('1');
                $table->integer('quiz_id')->unsigned();
                $table->foreign('quiz_id')
                  ->references('id')
                  ->on('quizzes')
                  ->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectives');
    }
};
