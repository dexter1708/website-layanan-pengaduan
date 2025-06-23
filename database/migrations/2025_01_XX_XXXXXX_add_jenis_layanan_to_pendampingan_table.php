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
        // Schema::table('pendampingans', function (Blueprint $table) {
        //     $table->enum('jenis_layanan', [
        //         'pendampingan_hukum',
        //         'pendampingan_kesehatan', 
        //         'pendampingan_rehabilitasi_sosial',
        //         'pendampingan_reintegrasi_sosial'
        //     ])->default('pendampingan_hukum')->after('konfirmasi');
        // });
    }

    public function down(): void
    {
        Schema::table('pendampingan', function (Blueprint $table) {
            $table->dropColumn('jenis_layanan');
        });
    }
}; 