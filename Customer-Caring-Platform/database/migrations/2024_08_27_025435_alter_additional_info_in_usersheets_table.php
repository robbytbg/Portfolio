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
    Schema::table('usersheet', function (Blueprint $table) {
        $table->text('additional_info')->change();
    });
}

public function down()
{
    Schema::table('usersheet', function (Blueprint $table) {
        $table->string('additional_info', 255)->change();
    });
}

};
