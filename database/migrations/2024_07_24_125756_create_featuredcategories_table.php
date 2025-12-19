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
        if(!Schema::hasTable('featured_categories')) {
            Schema::create('featured_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->json('category_ids');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->timestamps();
            });
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featuredcategories');
    }
};
