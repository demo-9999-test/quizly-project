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
        if(!Schema::hasTable('testimonials')){
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name')->nullable();
            $table->string('rating')->nullable();
            $table->boolean('status')->default(false);
            $table->text('details')->nullable();
            $table->string('images')->nullable();
            $table->integer('position')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
