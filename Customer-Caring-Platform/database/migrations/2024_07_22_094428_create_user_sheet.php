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
        Schema::create('usersheet', function (Blueprint $table) {
            $table->Increments('id');
            $table->bigInteger('nper')->nullable();
            $table->bigInteger('snd')->nullable();
            $table->bigInteger('snd_group')->nullable();
            $table->string('nama_cli', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('ubis', 255)->nullable();
            $table->string('desc_newbill', 255)->nullable();
            $table->string('usage_desc', 255)->nullable();
            $table->integer('lama_berlangganan')->nullable();
            $table->bigInteger('saldo')->nullable(); // Changed to bigint
            $table->bigInteger('no_hp')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('tanggal_caring_1', 255)->nullable();
            $table->string('petugas', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('tanggal_caring_2', 255)->nullable();
            $table->string('petugas_2', 255)->nullable();
            $table->string('status_2', 255)->nullable();
            $table->string('additional_info', 255)->nullable();
            $table->string('sheet_code', 255)->nullable();

            // Adding timestamps (created_at and updated_at columns)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersheet');
    }
};
