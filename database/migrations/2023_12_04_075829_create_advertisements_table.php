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
        if(!Schema::hasTable('advertisements')){
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('position')->nullable();
            $table->string('page_type')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
