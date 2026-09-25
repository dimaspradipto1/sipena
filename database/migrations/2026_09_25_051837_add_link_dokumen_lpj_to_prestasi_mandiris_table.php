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
        Schema::table('prestasi_mandiris', function (Blueprint $table) {
            $table->string('link_dokumen_lpj')->nullable()->after('link_dokumen_undangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi_mandiris', function (Blueprint $table) {
            $table->dropColumn('link_dokumen_lpj');
        });
    }
};
