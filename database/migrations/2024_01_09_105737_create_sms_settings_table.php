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
        if(!Schema::hasTable('sms_settings')){
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('twillio_enable')->default(0);
            $table->boolean('mimsms_enable')->default(0);
            $table->boolean('exabytes_enable')->default(0);
            $table->boolean('clicktail_enable')->default(0);
            $table->boolean('bulksms_enable')->default(0);
            $table->boolean('msg_enable')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_settings');
    }
};
