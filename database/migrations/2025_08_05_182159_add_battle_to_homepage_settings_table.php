<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->boolean('battle')->default(0);
        });
    }

    public function down()
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn('battle');
        });
    }
};