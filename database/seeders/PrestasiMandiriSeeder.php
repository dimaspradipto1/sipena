<?php

namespace Database\Seeders;

use App\Models\PrestasiMandiri;
use Illuminate\Database\Seeder;

class PrestasiMandiriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'level'                   => 'Internasional',
                'kategori'                => 'Olahraga',
                'nama_kompetisi'          => 'Banda baru Li-Ning badminton championship 2023',
                'nama_cabang'             => 'Badminton',
                'peringkat'               => 'Juara III',
                'nama_penyelenggara'      => 'Banda baru',
                'jumlah_pt_peserta'       => 100,
                'kepesertaan'             => 'Kelompok',
                'bentuk'                  => 'Luring',
                'url_kompetisi'           => 'https://sport.detik.com/raket/d-6576547/bni-sirnas-b-kepri-2023-tanding-di-batam-mulai-besok',
                'link_dokumen_sertifikat' => 'https://drive.google.com/file/d/1r3r55bHS2nlhcgN1uKH8blYlCreOlzTg/view',
                'tanggal_sertifikat'      => '2023-12-02',
                'link_foto_upp'           => 'https://drive.google.com/file/d/199jOPTl5l0vuFe9DFR_DdQ4AdqEMR7br/view',
                'link_dokumen_undangan'   => 'https://dispora.batam.go.id/2024/12/20/penutupan-banda-baru-li-ning-badminton-championship-2024/',
                'keterangan'              => 'Kompetisi internasional bulutangkis antar klub dan universitas.',
                'tahun'                   => 2023,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '1910128262190', 'nama' => 'Frida ayu wulandari']
                ],
                'data_dosen'              => [
                    ['nidn' => '0012058501', 'nama' => 'Hendra Wijaya, S.T., M.Eng.', 'url_surat' => 'https://drive.google.com/file/d/surat-tugas/view']
                ]
            ],
            [
                'level'                   => 'Nasional',
                'kategori'                => 'Seni dan Budaya',
                'nama_kompetisi'          => 'Cipta puisi/pantun Qasida',
                'nama_cabang'             => 'Panca nawa',
                'peringkat'               => 'Juara II',
                'nama_penyelenggara'      => 'Panitia Qasida Nasional',
                'jumlah_pt_peserta'       => 45,
                'kepesertaan'             => 'Individu',
                'bentuk'                  => 'Daring',
                'url_kompetisi'           => 'https://example.com/kompetisi-qasida',
                'link_dokumen_sertifikat' => 'https://example.com/sertifikat-qasida.pdf',
                'tanggal_sertifikat'      => '2023-08-17',
                'link_foto_upp'           => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Lomba cipta puisi islami nasional.',
                'tahun'                   => 2023,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '2010128262001', 'nama' => 'Rizky Pratama Putra']
                ],
                'data_dosen'              => []
            ],
            [
                'level'                   => 'Nasional',
                'kategori'                => 'Olahraga',
                'nama_kompetisi'          => 'Batam International Charity 7Km Run',
                'nama_cabang'             => 'Atletik',
                'peringkat'               => 'Juara II',
                'nama_penyelenggara'      => 'Pemerintah Kota Batam',
                'jumlah_pt_peserta'       => 60,
                'kepesertaan'             => 'Individu',
                'bentuk'                  => 'Luring',
                'url_kompetisi'           => 'https://example.com/batam-run',
                'link_dokumen_sertifikat' => 'https://example.com/sertifikat-run.pdf',
                'tanggal_sertifikat'      => '2024-03-10',
                'link_foto_upp'           => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Lari maraton charity 7K.',
                'tahun'                   => 2024,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '2110128262015', 'nama' => 'Anisa Nurul Hidayah']
                ],
                'data_dosen'              => []
            ],
            [
                'level'                   => 'Provinsi',
                'kategori'                => 'Seni dan Budaya',
                'nama_kompetisi'          => 'Porseni KORPRI 2024',
                'nama_cabang'             => 'Pencak Silat',
                'peringkat'               => 'Juara I',
                'nama_penyelenggara'      => 'BAPOMI Kepri',
                'jumlah_pt_peserta'       => 20,
                'kepesertaan'             => 'Kelompok',
                'bentuk'                  => 'Luring',
                'url_kompetisi'           => 'https://example.com/porseni-2024',
                'link_dokumen_sertifikat' => 'https://example.com/sertifikat-porseni.pdf',
                'tanggal_sertifikat'      => '2024-05-20',
                'link_foto_upp'           => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Pekan Olahraga dan Seni Mahasiswa Provinsi.',
                'tahun'                   => 2024,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '2210128262088', 'nama' => 'Bagus Setiawan']
                ],
                'data_dosen'              => []
            ],
        ];

        foreach ($records as $record) {
            PrestasiMandiri::create($record);
        }
    }
}
