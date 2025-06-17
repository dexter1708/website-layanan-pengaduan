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
        // Migration ini tidak diperlukan karena kolom konfirmasi sudah ada di migration awal
        // Schema::table('pendampingan', function (Blueprint $table) {
        //     $table->string('konfirmasi')->after('tanggal_pendampingan');
        // });
    }

    public function down(): void
    {
        // Schema::table('pendampingan', function (Blueprint $table) {
        //     //
        // });
    }
};
