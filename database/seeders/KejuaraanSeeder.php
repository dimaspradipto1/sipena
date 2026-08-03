<?php

namespace Database\Seeders;

use App\Models\Kejuaraan;
use Illuminate\Database\Seeder;

class KejuaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_ajang'             => 'Kompetisi Nasional Inovasi Teknologi Ibnu Sina (KNITIS 2026)',
                'jenis_penyelenggaraan' => 'Penyelenggara Kompetisi/Ajang Mandiri',
                'tingkat_level'         => 'Nasional',
                'kategori'               => 'Penalaran dan Kreativitas',
                'bentuk'                 => 'Hybrid (Daring & Luring)',
                'tempat'                 => 'Kampus Utama UIS Batam',
                'url_ajang'              => 'https://knitis.uis.ac.id',
                'tahun'                  => 2026,
                'url_laporan_kegiatan'   => 'https://drive.google.com/file/d/laporan-knitis-2026/view',
                'kode_pt'                => '101015',
                'nama_pt'                => 'Universitas Ibnu Sina',
                'jumlah_peserta'         => 45,
                'status'                 => 'Terverifikasi',
            ],
            [
                'nama_ajang'             => 'Olimpiade Seni & Rekayasa Mahasiswa Se-Kepulauan Riau',
                'jenis_penyelenggaraan' => 'Penyelenggara Kompetisi/Ajang Mandiri',
                'tingkat_level'         => 'Wilayah / Regional',
                'kategori'               => 'Seni dan Budaya',
                'bentuk'                 => 'Luring (Offline)',
                'tempat'                 => 'Batalkan / Aula Utama UIS',
                'url_ajang'              => 'https://olimpiade.uis.ac.id',
                'tahun'                  => 2025,
                'url_laporan_kegiatan'   => 'https://drive.google.com/file/d/laporan-olimpiade-2025/view',
                'kode_pt'                => '101015',
                'nama_pt'                => 'Universitas Ibnu Sina',
                'jumlah_peserta'         => 30,
                'status'                 => 'Submitted',
            ],
        ];

        foreach ($data as $item) {
            Kejuaraan::create($item);
        }
    }
}
