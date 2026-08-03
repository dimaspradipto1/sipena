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
        Schema::create('prestasi_belmawas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lomba');
            $table->string('kategori_lomba')->nullable();
            $table->string('tingkat')->default('Nasional');
            $table->string('capaian_prestasi');
            $table->year('tahun')->default(2026);
            $table->string('kode_pt')->default('101015');
            $table->string('nama_pt')->default('Universitas Ibnu Sina');
            $table->string('nama_mahasiswa')->nullable();
            $table->string('nim')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('dosen_pembimbing')->nullable();
            $table->string('link_sk_kemendikbud')->nullable();
            $table->string('link_sertifikat')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Terverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_belmawas');
    }
};
