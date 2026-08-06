<?php

namespace Database\Seeders;

use App\Models\PrestasiBelmawa;
use Illuminate\Database\Seeder;

class PrestasiBelmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'nama_lomba'        => 'PKM-KC (Pekan Kreativitas Mahasiswa - Karsa Cipta)',
                'kategori_lomba'    => 'Sains, Teknologi dan Inovasi / SSI',
                'tingkat'           => 'Nasional',
                'capaian_prestasi'  => 'Juara I (Medali Emas)',
                'tahun'             => 2024,
                'kode_pt'           => '101015',
                'nama_pt'           => 'Universitas Ibnu Sina',
                'nama_mahasiswa'    => 'Frida Ayu Wulandari',
                'nim'               => '1910128262190',
                'program_studi'     => 'Teknik Informatika',
                'dosen_pembimbing'  => 'Hendra Wijaya, S.T., M.Eng.',
                'link_sk_kemendikbud'=> 'https://example.com/sk-pkm-2024.pdf',
                'link_sertifikat'   => 'https://example.com/sertifikat-pkm-2024.pdf',
                'keterangan'        => 'Lolos PIMNAS ke-37 kategori Karsa Cipta Sistem Monitoring IoT.',
                'status'            => 'Terverifikasi',
            ],
            [
                'nama_lomba'        => 'Kompetisi Nasional MIPA (KN-MIPA) 2023',
                'kategori_lomba'    => 'Sains, Teknologi dan Inovasi / SSI',
                'tingkat'           => 'Nasional',
                'capaian_prestasi'  => 'Juara III',
                'tahun'             => 2023,
                'kode_pt'           => '101015',
                'nama_pt'           => 'Universitas Ibnu Sina',
                'nama_mahasiswa'    => 'Rizky Pratama Putra',
                'nim'               => '2010128262001',
                'program_studi'     => 'Sistem Informasi',
                'dosen_pembimbing'  => 'Maya Indah, S.Kom., M.T.',
                'link_sk_kemendikbud'=> 'https://example.com/sk-knmipa.pdf',
                'link_sertifikat'   => 'https://example.com/sertifikat-knmipa.pdf',
                'keterangan'        => 'Kompetisi matematika dan ilmu pengetahuan alam nasional.',
                'status'            => 'Terverifikasi',
            ],
            [
                'nama_lomba'        => 'Kompak Business Plan Competition 2025',
                'kategori_lomba'    => 'Wirausaha',
                'tingkat'           => 'Nasional',
                'capaian_prestasi'  => 'Juara II',
                'tahun'             => 2025,
                'kode_pt'           => '101015',
                'nama_pt'           => 'Universitas Ibnu Sina',
                'nama_mahasiswa'    => 'Budi Setiawan',
                'nim'               => '2210128262055',
                'program_studi'     => 'Manajemen',
                'dosen_pembimbing'  => 'Dr. Hj. Nurhayati, M.M.',
                'link_sk_kemendikbud'=> 'https://example.com/sk-wirausaha.pdf',
                'link_sertifikat'   => 'https://example.com/sertifikat-wirausaha.pdf',
                'keterangan'        => 'Kompetisi rencana bisnis mahasiswa nasional.',
                'status'            => 'Terverifikasi',
            ],
            [
                'nama_lomba'        => 'National Health Innovation Award 2026',
                'kategori_lomba'    => 'Sains, Teknologi dan Inovasi / SSI',
                'tingkat'           => 'Nasional',
                'capaian_prestasi'  => 'Juara I',
                'tahun'             => 2026,
                'kode_pt'           => '101015',
                'nama_pt'           => 'Universitas Ibnu Sina',
                'nama_mahasiswa'    => 'Siti Aminah',
                'nim'               => '2310128262012',
                'program_studi'     => 'Kesehatan Masyarakat',
                'dosen_pembimbing'  => 'Dr. Ratna Sari, M.Si.',
                'link_sk_kemendikbud'=> 'https://example.com/sk-health.pdf',
                'link_sertifikat'   => 'https://example.com/sertifikat-health.pdf',
                'keterangan'        => 'Inovasi kesehatan masyarakat berpotensi paten.',
                'status'            => 'Terverifikasi',
            ],
        ];

        foreach ($records as $record) {
            PrestasiBelmawa::create($record);
        }
    }
}
