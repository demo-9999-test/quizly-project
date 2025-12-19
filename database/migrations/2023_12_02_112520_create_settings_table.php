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
        if(!Schema::hasTable('settings')){
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('login_img')->nullable();
            $table->string('signup_img')->nullable();
            $table->boolean('right_click_status')->default(0);
            $table->boolean('preloader_enable_status')->default(0);
            $table->boolean('inspect_status')->default(0);
            $table->boolean('mobile_status')->default(0);
            $table->boolean('activity_status')->default(0);
            $table->boolean('welcome_status')->default(0);
            $table->boolean('verify_status')->default(0);
            $table->string('admin_logo')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
