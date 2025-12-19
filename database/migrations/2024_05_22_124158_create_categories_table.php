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
        if(!Schema::hasTable('categories')){

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('icon')->nullable();
            $table->string('mob')->nullable();
            $table->string('image');
            $table->string('parent_id', 10)->default('-1');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->enum('status', ['1', '0'])->default('1');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
