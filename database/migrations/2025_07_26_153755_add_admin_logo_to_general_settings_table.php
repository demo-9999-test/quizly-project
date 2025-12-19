<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('general_settings', function (Blueprint $table) {
        $table->string('admin_logo')->nullable();
    });
}

public function down()
{
    Schema::table('general_settings', function (Blueprint $table) {
        $table->dropColumn('admin_logo');
    });
}
};