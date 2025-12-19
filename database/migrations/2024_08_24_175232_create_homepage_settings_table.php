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
        if (!Schema::hasTable('homepage_settings')) {
            Schema::create('homepage_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('slider')->default(0);
                $table->boolean('counter')->default(0);
                $table->boolean('categories')->default(0);
                $table->boolean('friends')->default(0);
                $table->boolean('discover_quiz')->default(0);
                $table->boolean('battle')->default(0);
                $table->boolean('zone')->default(0);
                $table->boolean('testimonial')->default(0);
                $table->boolean('blogs')->default(0);
                $table->boolean('newsletter')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_setting');
    }
};
