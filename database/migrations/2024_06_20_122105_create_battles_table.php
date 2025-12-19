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
        if(!Schema::hasTable('battles')){
            Schema::create('battles', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->string('name');
                $table->string('slug')->unique();
                $table->integer('room_time');
                $table->text('description');
                $table->boolean('status')->default(0);
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
        Schema::dropIfExists('battles');
    }
};
