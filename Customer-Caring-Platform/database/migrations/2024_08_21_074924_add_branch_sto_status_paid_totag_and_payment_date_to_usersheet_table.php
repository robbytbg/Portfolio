<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('usersheet', function (Blueprint $table) {

        $table->integer('totag')->nullable();             // Modify totag to be integer
        $table->string('payment_date')->nullable();         // Add payment_date column
    });
}

public function down()
{
    Schema::table('usersheet', function (Blueprint $table) {

        $table->dropColumn('totag');
        $table->dropColumn('payment_date');
    });
}

};
