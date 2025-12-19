<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('api_settings', function (Blueprint $table) {
        if (!Schema::hasColumn('api_settings', 'recaptcha_site_key')) {
            $table->text('recaptcha_site_key')->nullable();
        }

        if (!Schema::hasColumn('api_settings', 'recaptcha_secret_key')) {
            $table->text('recaptcha_secret_key')->nullable();
        }

        if (!Schema::hasColumn('api_settings', 'recaptcha_status')) {
            $table->boolean('recaptcha_status')->default(0);
        }
    });
}

public function down()
{
    Schema::table('api_settings', function (Blueprint $table) {
        $table->dropColumn(['recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_status']);
    });
}
};