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
        if(!Schema::hasTable('bookmarks')){
            Schema::create('bookmarks', function (Blueprint $table) {
                $table->id();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('quiz_id')->references('id')->on('quizes');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
