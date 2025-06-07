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
        Schema::create('korban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('disabilitas')->nullable();
            $table->integer('usia');
            $table->string('pendidikan');
            $table->string('status_perkawinan');
            $table->string('pekerjaan');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korban');
    }
};
