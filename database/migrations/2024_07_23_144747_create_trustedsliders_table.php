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
        if(!Schema::hasTable('trustedsliders')) {
            Schema::create('trustedsliders', function (Blueprint $table) {
                $table->id();
                $table->string('image')->nullable(); // Column to store the image file name or path
                $table->string('url')->nullable();  // Column to store the image URL
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trustedsliders');
    }
};
