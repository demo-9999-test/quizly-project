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
    {   if(!Schema::hasTable('p_w_a_settings')) {
            Schema::create('p_w_a_settings', function (Blueprint $table) {
                $table->id();
                $table->string('pwa_icon')->nullable();
                $table->string('pwa_splash_icon')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_w_a_settings');
    }
};
