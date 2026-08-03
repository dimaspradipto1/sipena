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
        Schema::create('kejuaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ajang');
            $table->string('jenis_penyelenggaraan')->default('Penyelenggara Kompetisi/Ajang Mandiri');
            $table->string('tingkat_level')->default('Nasional');
            $table->string('kategori')->default('Penalaran dan Kreativitas');
            $table->string('bentuk')->default('Luring (Offline)');
            $table->string('tempat')->nullable();
            $table->string('url_ajang')->nullable();
            $table->year('tahun')->default(2026);
            $table->string('url_laporan_kegiatan')->nullable();
            $table->string('kode_pt')->default('101015');
            $table->string('nama_pt')->default('Universitas Ibnu Sina');
            $table->integer('jumlah_peserta')->default(0);
            $table->string('status')->default('Terverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kejuaraans');
    }
};
