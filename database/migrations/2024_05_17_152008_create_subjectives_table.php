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
        if (!Schema::hasTable('subjectives')) {
            Schema::create('subjectives', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->string('video')->nullable();
                $table->string('audio')->nullable();
                $table->string('image')->nullable();
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
        Schema::dropIfExists('subjectives');
    }
};
