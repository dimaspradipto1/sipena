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
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('nama_sertifikasi');
            $table->string('nama_penyelenggara');
            $table->string('url_sertifikasi')->nullable();
            $table->string('link_dokumen_sertifikat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('link_foto_kegiatan')->nullable();
            $table->string('link_dokumen_undangan')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('tahun')->nullable();
            $table->string('pt')->default('Universitas Ibnu Sina');
            $table->string('status')->default('Terverifikasi');
            $table->json('data_mahasiswa')->nullable();
            $table->json('data_dosen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasis');
    }
};
