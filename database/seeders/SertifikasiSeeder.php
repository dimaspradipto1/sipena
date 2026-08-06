<?php

namespace Database\Seeders;

use App\Models\Sertifikasi;
use Illuminate\Database\Seeder;

class SertifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'level'                   => 'Internasional',
                'nama_sertifikasi'        => 'AWS Certified Solutions Architect – Associate',
                'nama_penyelenggara'      => 'Amazon Web Services (AWS)',
                'url_sertifikasi'         => 'https://aws.amazon.com/certification/certified-solutions-architect-associate/',
                'link_dokumen_sertifikat' => 'https://example.com/aws-cert.pdf',
                'tanggal_sertifikat'      => '2024-01-10',
                'link_foto_kegiatan'      => 'https://example.com/photo-aws.jpg',
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Sertifikasi keahlian komputasi awan internasional.',
                'tahun'                   => 2024,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '1910128262190', 'nama' => 'Frida Ayu Wulandari', 'prodi' => 'Teknik Informatika']
                ],
                'data_dosen'              => [
                    ['nidn' => '0012058501', 'nama' => 'Hendra Wijaya, S.T., M.Eng.', 'url_surat' => 'https://example.com/surat-tugas.pdf']
                ]
            ],
            [
                'level'                   => 'Nasional',
                'nama_sertifikasi'        => 'Sertifikasi Kompetensi BNSP Junior Web Developer',
                'nama_penyelenggara'      => 'LSP Teknologi Informasi Indonesia / BNSP',
                'url_sertifikasi'         => 'https://example.com/bnsp-webdev',
                'link_dokumen_sertifikat' => 'https://example.com/bnsp-cert.pdf',
                'tanggal_sertifikat'      => '2023-09-15',
                'link_foto_kegiatan'      => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Sertifikasi profesi pengembang web nasional.',
                'tahun'                   => 2023,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '2010128262001', 'nama' => 'Rizky Pratama Putra', 'prodi' => 'Sistem Informasi']
                ],
                'data_dosen'              => [
                    ['nidn' => '0020038204', 'nama' => 'Maya Indah, S.Kom., M.T.', 'url_surat' => 'https://example.com/surat-tugas.pdf']
                ]
            ],
            [
                'level'                   => 'Provinsi',
                'nama_sertifikasi'        => 'Sertifikasi Pelatihan Digital Marketing UMKM Kepri',
                'nama_penyelenggara'      => 'Dinas Koperasi & UMKM Provinsi Kepulauan Riau',
                'url_sertifikasi'         => 'https://example.com/digimar-kepri',
                'link_dokumen_sertifikat' => 'https://example.com/cert-digimar.pdf',
                'tanggal_sertifikat'      => '2024-04-05',
                'link_foto_kegiatan'      => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Pelatihan dan uji kompetensi pemasaran digital.',
                'tahun'                   => 2024,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '2110128262015', 'nama' => 'Anisa Nurul Hidayah', 'prodi' => 'Manajemen']
                ],
                'data_dosen'              => []
            ],
            [
                'level'                   => 'Internasional',
                'nama_sertifikasi'        => 'Oracle Certified Professional Java SE Programmer',
                'nama_penyelenggara'      => 'Oracle Corporation',
                'url_sertifikasi'         => 'https://example.com/oracle-java',
                'link_dokumen_sertifikat' => 'https://example.com/oracle-cert.pdf',
                'tanggal_sertifikat'      => '2025-05-12',
                'link_foto_kegiatan'      => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Sertifikasi internasional pemrograman Java.',
                'tahun'                   => 2025,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '19101280001', 'nama' => 'Mahasiswa Berprestasi', 'prodi' => 'Teknik Informatika']
                ],
                'data_dosen'              => [
                    ['nidn' => '0012058501', 'nama' => 'Hendra Wijaya, S.T., M.Eng.', 'url_surat' => 'https://example.com/surat-tugas.pdf']
                ]
            ],
        ];

        foreach ($records as $record) {
            Sertifikasi::create($record);
        }
    }
}
