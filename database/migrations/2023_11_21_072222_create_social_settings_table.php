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
        if(!Schema::hasTable('social_settings')){
        Schema::create('social_settings', function (Blueprint $table) {
                $table->id();

                // Facebook
                $table->string('facebook_client_id')->nullable();
                $table->string('facebook_client_key')->nullable();
                $table->string('facebook_callback_url')->nullable();
                $table->boolean('facebook_status')->default(0);

                // Google
                $table->string('google_client_id')->nullable();
                $table->string('google_client_key')->nullable();
                $table->string('google_callback_url')->nullable();
                $table->boolean('google_status')->default(0);

                // Gitlab
                $table->string('gitlab_client_id')->nullable();
                $table->string('gitlab_client_key')->nullable();
                $table->string('gitlab_callback_url')->nullable();
                $table->boolean('gitlab_status')->default(0);

                // Amazon
                $table->string('amazon_client_id')->nullable();
                $table->string('amazon_client_key')->nullable();
                $table->string('amazon_callback_url')->nullable();
                $table->boolean('amazon_status')->default(0);

                // LinkedIn
                $table->string('linkedin_client_id')->nullable();
                $table->string('linkedin_client_key')->nullable();
                $table->string('linkedin_callback_url')->nullable();
                $table->boolean('linkedin_status')->default(0);

                // Twitter
                $table->string('twitter_client_id')->nullable();
                $table->string('twitter_client_key')->nullable();
                $table->string('twitter_callback_url')->nullable();
                $table->boolean('twitter_status')->default(0);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_settings');
    }
};
