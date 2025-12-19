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
        if(!Schema::hasTable('social_chats')){
        Schema::create('social_chats', function (Blueprint $table) {
            $table->id();
            $table->string('header_title')->nullable();
            $table->string('contact')->nullable();
            $table->text('wp_msg')->nullable();
            $table->string('wp_color')->nullable();
            $table->boolean('button_position')->default(0);
            $table->boolean('whatsapp_enable_button')->default(0);
            $table->string('facebook_chat_bubble')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_chats');
    }
};
