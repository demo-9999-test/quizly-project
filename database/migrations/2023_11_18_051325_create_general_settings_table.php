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
        if(!Schema::hasTable('general_settings')){
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('support_email')->nullable();
            $table->string('address')->nullable();
            $table->string('iframe_url')->nullable();
            $table->string('promo_text')->nullable();
            $table->string('promo_link')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon_logo')->nullable();
            $table->string('preloader_logo')->nullable();
            $table->timestamps();
        });
     }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
