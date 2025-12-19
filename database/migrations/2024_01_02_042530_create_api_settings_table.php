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
        if(!Schema::hasTable('api_settings')){
        Schema::create('api_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('twillio_enable')->default(0);
            $table->text('adsense_script')->nullable();
            $table->boolean('ad_status')->default(0);
            $table->boolean('mobile_status')->default(0);
            $table->text('analytics_script')->nullable();
            $table->boolean('an_status')->default(0);
            $table->boolean('recaptcha_status')->default(0);
            $table->boolean('aws_status')->default(0);
            $table->boolean('youtube_status')->default(0);
            $table->boolean('vimeo_status')->default(0);
            $table->boolean('gtm_status')->default(0);
            $table->boolean('gpt_toggle')->default(0);
            $table->text('mailchip_api_key')->nullable();
            $table->text('mailchip_id')->nullable();
            $table->text('fb_pixel')->nullable();
            $table->text('openapikey')->nullable();

            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_settings');
    }
};
