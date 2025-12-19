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
        if (!Schema::hasTable('coming_soons')) {
            Schema::create('coming_soons', function (Blueprint $table) {
                $table->id();
                $table->string('heading');
                $table->string('btn_txt');
                $table->integer('counter_one');
                $table->integer('counter_two');
                $table->integer('counter_three');
                $table->integer('counter_four');
                $table->string('counter_one_txt');
                $table->string('counter_two_txt');
                $table->string('counter_three_txt');
                $table->string('counter_four_txt');
                $table->boolean('maintenance_mode');
                $table->string('image');
                $table->string('ip_address');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coming_soons');
    }
};
