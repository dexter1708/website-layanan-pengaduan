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
        Schema::create('alamat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('sebagai');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('desa');
            $table->integer('RT');
            $table->integer('RW');
            $table->morphs('alamatable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
