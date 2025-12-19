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
        if(!Schema::hasTable('blogs')){
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('category_id')->nullable();
            $table->string('banner_img')->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('approved')->default(1);
            $table->boolean('sticky')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->text('desc')->nullable();
            $table->integer('position')->default(0);
            $table->softDeletes();
            $table->timestamps();

        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
