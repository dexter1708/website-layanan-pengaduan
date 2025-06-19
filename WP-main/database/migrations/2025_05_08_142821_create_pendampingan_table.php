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
        Schema::create('pendampingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->foreignId('korban_id')->constrained('korban')->onDelete('cascade');
            $table->string('nama_korban');
            $table->string('nama_pendamping');
            $table->dateTime('tanggal_pendampingan');
            $table->string('tempat_pendampingan');
            $table->string('jenis_layanan');
            $table->string('konfirmasi')->default('menunggu');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendampingan');
    }
};
