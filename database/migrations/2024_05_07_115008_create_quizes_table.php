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
        if(!Schema::hasTable('quizes')){
            Schema::create('quizes', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description');
                $table->string('timer');
                $table->string('image')->nullable();
                $table->string('start_date');
                $table->string('end_date');
                $table->boolean('status')->default(0);
                $table->boolean('reattempt')->default(0);
                $table->boolean('type')->default(0);
                $table->boolean('question_order')->default(0);
                $table->string('subject');
                $table->boolean('service')->default(0);
                $table->integer('fees')->nullable();
                $table->unsignedBigInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories');
                $table->boolean('approve_result')->default(0);
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
        Schema::dropIfExists('quizes');
    }
};
