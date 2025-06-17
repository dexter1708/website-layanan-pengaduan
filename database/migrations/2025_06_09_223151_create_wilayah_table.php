<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWilayahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id(); // ID untuk tabel wilayah
            $table->foreignId('kota_id')->nullable()->constrained('wilayah')->nullOnDelete(); // Relasi ke kota_id
            $table->foreignId('kecamatan_id')->nullable()->constrained('wilayah')->nullOnDelete(); // Relasi ke kecamatan_id
            $table->foreignId('desa_id')->nullable()->constrained('wilayah')->nullOnDelete(); // Relasi ke desa_id
            $table->string('kota_nama')->nullable(); // Nama kota
            $table->string('kecamatan_nama')->nullable(); // Nama kecamatan
            $table->string('desa_nama')->nullable(); // Nama desa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wilayah');
    }
}
