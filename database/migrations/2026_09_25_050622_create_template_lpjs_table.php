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
        Schema::create('template_lpjs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->default('Prestasi Mandiri');
            $table->string('tipe')->default('link'); // 'link' atau 'file'
            $table->text('url_link')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_lpjs');
    }
};
