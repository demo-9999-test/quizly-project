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
        if(!Schema::hasTable('footer_settings')){
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('insta_url')->nullable();
            $table->text('desc')->nullable();
            $table->text('copyright_text')->nullable();
            $table->string('image')->nullable();
            $table->string('footer_logo')->nullable();

            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
