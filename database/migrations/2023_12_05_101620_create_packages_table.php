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
        if(!Schema::hasTable('packages')){
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id')->nullable();
            $table->string('pname')->nullable();
            $table->string('pfeatures_id')->nullable();
            $table->string('plan_unit')->nullable();
            $table->string('plan_amount')->nullable();
            $table->string('offer_price')->nullable();
            $table->string('plan_duration')->nullable();
            $table->string('currency')->nullable();
            $table->integer('free')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
