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
        if(!Schema::hasTable('invoice_settings')) {
            Schema::create('invoice_settings', function (Blueprint $table) {
                $table->id();
                $table->string('logo')->nullable(); // For logo upload
                $table->boolean('show_logo')->default(0);
                $table->string('site_name')->nullable();
                $table->text('header_message')->nullable(); // Any header message or notice
                $table->text('footer_message')->nullable(); // Any footer message or notice
                $table->string('contact_address')->nullable();
                $table->string('contact_email')->nullable();
                $table->string('contact_phone')->nullable();
                $table->string('signature')->nullable(); // For signature upload
                $table->boolean('show_signature')->default(0);
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
