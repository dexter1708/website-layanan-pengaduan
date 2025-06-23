<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->string('jenis_kasus')->nullable();
            $table->string('bentuk_kekerasan')->nullable();
            $table->unsignedBigInteger('kecamatan')->nullable();
            $table->unsignedBigInteger('desa')->nullable();
            $table->string('status')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn(['jenis_kasus', 'bentuk_kekerasan', 'kecamatan', 'desa','status']);
        });
    }
};

