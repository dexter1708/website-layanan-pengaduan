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
        Schema::table('pengaduan', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('nama_kecamatan')->nullable()->after('kecamatan');
            $table->string('nama_desa')->nullable()->after('desa');

            // Hapus kolom lama
            $table->dropColumn(['kecamatan', 'desa']);
        });

        Schema::table('pengaduan', function (Blueprint $table) {
            // Rename kolom baru
            $table->renameColumn('nama_kecamatan', 'kecamatan');
            $table->renameColumn('nama_desa', 'desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Tambah kolom lama
            $table->integer('old_kecamatan')->after('kecamatan');
            $table->integer('old_desa')->after('desa');

            // Hapus kolom baru
            $table->dropColumn(['kecamatan', 'desa']);

            // Rename kolom lama
            $table->renameColumn('old_kecamatan', 'kecamatan');
            $table->renameColumn('old_desa', 'desa');
        });
    }
};
