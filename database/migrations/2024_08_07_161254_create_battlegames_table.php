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
        if(!Schema::hasTable('battlegames')) {
            Schema::create('battlegames', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('creator_id');
                $table->unsignedBigInteger('quiz_id');
                $table->unsignedBigInteger('battle_id');
                $table->unsignedBigInteger('opponent_id')->nullable();
                $table->string('room_name');
                $table->decimal('bid_amount');
                $table->string('code', 6)->unique();
                $table->timestamp('expires_at');
                $table->boolean('creator_completed')->default(0);
                $table->boolean('opponent_completed')->default(0);
                $table->enum('status', ['pending', 'active', 'completed', 'expired'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battlegames');
    }
};
