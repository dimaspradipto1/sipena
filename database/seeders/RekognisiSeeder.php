<?php

namespace Database\Seeders;

use App\Models\Rekognisi;
use Illuminate\Database\Seeder;

class RekognisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'level'                   => 'Internasional',
                'nama_rekognisi'          => 'Keynote Speaker at International Conference on Computer Science 2024',
                'jenis'                   => 'Narasumber / Keynote Speaker',
                'nama_penyelenggara'      => 'IEEE Computer Society Malaysia',
                'url_rekognisi'           => 'https://example.com/iccs2024',
                'link_dokumen_sertifikat' => 'https://example.com/certificate-keynote.pdf',
                'tanggal_sertifikat'      => '2024-02-15',
                'link_foto_kegiatan'      => 'https://example.com/photo-keynote.jpg',
                'link_dokumen_undangan'   => 'https://example.com/invitation.pdf',
                'keterangan'              => 'Undangan sebagai narasumber utama konferensi internasional bidang Artificial Intelligence.',
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
                'nama_rekognisi'          => 'Dewan Hakim Musabaqah Tilawatil Quran (MTQ) Mahasiswa Nasional',
                'jenis'                   => 'Juri / Dewan Hakim',
                'nama_penyelenggara'      => 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi',
                'url_rekognisi'           => 'https://example.com/mtq-nasional',
                'link_dokumen_sertifikat' => 'https://example.com/sertifikat-juri.pdf',
                'tanggal_sertifikat'      => '2023-11-10',
                'link_foto_kegiatan'      => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Juri tingkat nasional bidang kaligrafi kontemporer.',
                'tahun'                   => 2023,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '2010128262001', 'nama' => 'Rizky Pratama Putra', 'prodi' => 'Sistem Informasi']
                ],
                'data_dosen'              => [
                    ['nidn' => '0015087802', 'nama' => 'Dr. H. Ahmad Dahlan, M.Pd.', 'url_surat' => 'https://example.com/sk-juri.pdf']
                ]
            ],
            [
                'level'                   => 'Provinsi',
                'nama_rekognisi'          => 'Reviewer Jurnal Nasional Terakreditasi SINTA 2',
                'jenis'                   => 'Editor / Reviewer Jurnal',
                'nama_penyelenggara'      => 'Lembaga Penelitian dan Pengabdian Masyarakat',
                'url_rekognisi'           => 'https://example.com/journal-reviewer',
                'link_dokumen_sertifikat' => 'https://example.com/sk-reviewer.pdf',
                'tanggal_sertifikat'      => '2024-01-20',
                'link_foto_kegiatan'      => null,
                'link_dokumen_undangan'   => null,
                'keterangan'              => 'Reviewer naskah publikasi ilmiah.',
                'tahun'                   => 2024,
                'pt'                      => 'Universitas Ibnu Sina',
                'status'                  => 'Terverifikasi',
                'data_mahasiswa'          => [
                    ['nim' => '19101280001', 'nama' => 'Mahasiswa Berprestasi', 'prodi' => 'Teknik Informatika']
                ],
                'data_dosen'              => [
                    ['nidn' => '0020038204', 'nama' => 'Maya Indah, S.Kom., M.T.', 'url_surat' => 'https://example.com/surat-tugas.pdf']
                ]
            ],
        ];

        foreach ($records as $record) {
            Rekognisi::create($record);
        }
    }
}
