<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usersheet', function (Blueprint $table) {
            // Modify the `status_paid` column to be a string with a default value
            $table->string('status_paid', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('usersheet', function (Blueprint $table) {
            // Revert the `status_paid` column back to tinyint
            $table->tinyInteger('status_paid')->change();
        });
    }
};
