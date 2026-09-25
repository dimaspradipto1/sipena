<?php

namespace Database\Seeders;

use App\Models\TemplateLpj;
use Illuminate\Database\Seeder;

class TemplateLpjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TemplateLpj::firstOrCreate(
            ['nama' => 'Template Dokumen LPJ Prestasi Mandiri UIS'],
            [
                'kategori'   => 'Prestasi Mandiri',
                'tipe'       => 'file',
                'file_path'  => 'templates/template_lpj_prestasi_mandiri.docx',
                'file_name'  => 'Template_LPJ_Prestasi_Mandiri.docx',
                'url_link'   => null,
                'keterangan' => 'Template resmi dokumen Laporan Pertanggungjawaban (LPJ) kegiatan dan prestasi mandiri mahasiswa Universitas Ibnu Sina.',
                'is_active'  => true,
            ]
        );
    }
}
