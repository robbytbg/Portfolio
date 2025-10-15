<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usersheet', function (Blueprint $table) {
            $table->string('branch')->nullable();      // Add branch column
            $table->string('sto')->nullable();         // Add sto column
            $table->boolean('status_paid')->default(false); // Add status_paid column
        });
    }
    
    public function down()
    {
        Schema::table('usersheet', function (Blueprint $table) {
            $table->dropColumn('branch');
            $table->dropColumn('sto');
            $table->dropColumn('status_paid');
        });
    }
    
};
