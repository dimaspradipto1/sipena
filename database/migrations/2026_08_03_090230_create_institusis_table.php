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
        Schema::create('institusis', function (Blueprint $table) {
            $table->id();
            // Identitas PT
            $table->string('kode_pt');
            $table->string('nama_pt');
            $table->string('bentuk_pt')->default('Universitas');
            $table->string('status_institusi')->default('Swasta (PTS)');
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Pimpinan & Kemahasiswaan
            $table->string('nama_rektor')->nullable();
            $table->string('nip_rektor')->nullable();
            $table->string('nama_warek3')->nullable();
            $table->string('nip_warek3')->nullable();
            $table->string('no_hp_pic')->nullable();

            // Dokumen Utama & Pelaporan
            $table->string('link_sk_pendirian')->nullable();
            $table->string('link_pedoman_kemahasiswaan')->nullable();
            $table->string('link_struktur_organisasi')->nullable();
            $table->string('tahun_pelaporan')->default('2026');

            // Point A (2.b Beasiswa NonAPBN)
            $table->integer('mhs_nonapbn')->default(0);
            $table->integer('mhs_aktif')->default(0);
            $table->string('link_nonapbn')->nullable();
            $table->string('link_mhs_aktif')->nullable();

            // Point B (Sumber Daya Manusia & Level Kelembagaan)
            $table->string('level_kelembagaan')->nullable(); // Level 1, Level 2, Level 3
            $table->string('link_sk_pengangkat_pimpinan')->nullable();
            $table->string('link_struktur_pengelola_kemahasiswaan')->nullable();

            // Point D (Pembiayaan Kemahasiswaan)
            $table->decimal('total_anggaran_pt', 15, 2)->default(0);
            $table->decimal('total_anggaran_kemahasiswaan', 15, 2)->default(0);
            $table->string('link_anggaran_pt')->nullable();
            $table->string('link_anggaran_kemahasiswaan')->nullable();

            // JSON Data 70 Indikator Checklist (Poin A, B, C, D, E)
            $table->json('data_indikator')->nullable();

            $table->text('keterangan')->nullable();
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institusis');
    }
};
