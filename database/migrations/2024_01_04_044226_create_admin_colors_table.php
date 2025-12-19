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
        if(!Schema::hasTable('admin_colors')){
        Schema::create('admin_colors', function (Blueprint $table) {
            $table->id();
            $table->string('bg_light_grey');
            $table->string('bg_white');
            $table->string('bg_dark_blue');
            $table->string('bg_dark_grey');
            $table->string('bg_black');
            $table->string('bg_yellow');
            $table->string('text_black');
            $table->string('text_dark_grey');
            $table->string('text_light_grey');
            $table->string('text_dark_blue');
            $table->string('text_white');
            $table->string('text_red');
            $table->string('text_yellow');
            $table->string('border_white');
            $table->string('border_black');
            $table->string('border_light_grey');
            $table->string('border_dark_grey');
            $table->string('border_grey');
            $table->string('border_dark_blue');
            $table->string('border_yellow');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_colors');
    }
};
