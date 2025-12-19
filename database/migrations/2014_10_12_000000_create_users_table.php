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
        if(!Schema::hasTable('users')){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->boolean('show_email')->default(0);
            $table->string('mobile')->nullable();
            $table->boolean('show_mobile')->default(0);
            $table->string('role')->nullable()->default('U');
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('password');
            $table->boolean('status')->default(1);
            $table->text('desc')->nullable();
            $table->integer('age')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode')->nullable();
            $table->integer('score')->default(0);
            $table->integer('rank')->default(0);
            $table->integer('coins')->default(0);
            $table->string('google_id')->nullable();
            $table->rememberToken();
            $table->softDeletes(); // <-- This will add a deleted_at field
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
