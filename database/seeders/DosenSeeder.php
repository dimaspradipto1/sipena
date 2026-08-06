<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosens = [
            [
                'nidn_nuptk'     => '0012058501',
                'nama_dosen'     => 'Hendra Wijaya, S.T., M.Eng.',
                'program_studi' => 'S1-TEKNIK INFORMATIKA',
                'email'          => 'hendra.dosen@uis.ac.id',
                'no_hp'          => '081234567801',
                'url_surat_tugas'=> 'https://drive.google.com/file/d/surat-tugas-hendra/view',
                'status'         => 'Aktif',
            ],
            [
                'nidn_nuptk'     => '0020038204',
                'nama_dosen'     => 'Maya Indah, S.Kom., M.T.',
                'program_studi' => 'S1-SISTEM INFORMASI',
                'email'          => 'maya.dosen@uis.ac.id',
                'no_hp'          => '081234567802',
                'url_surat_tugas'=> 'https://drive.google.com/file/d/surat-tugas-maya/view',
                'status'         => 'Aktif',
            ],
            [
                'nidn_nuptk'     => '0099887766',
                'nama_dosen'     => 'Dosen Pendamping Utama',
                'program_studi' => 'S1-TEKNIK INFORMATIKA',
                'email'          => 'dosenpendamping@uis.ac.id',
                'no_hp'          => '081234567800',
                'url_surat_tugas'=> 'https://drive.google.com/file/d/surat-tugas-utama/view',
                'status'         => 'Aktif',
            ],
            [
                'nidn_nuptk'     => '0015087802',
                'nama_dosen'     => 'Dr. H. Ahmad Dahlan, M.Pd.',
                'program_studi' => 'S1-MANAJEMEN',
                'email'          => 'ahmad.dahlan@uis.ac.id',
                'no_hp'          => '081234567803',
                'url_surat_tugas'=> 'https://drive.google.com/file/d/surat-tugas-ahmad/view',
                'status'         => 'Aktif',
            ],
            [
                'nidn_nuptk'     => '0028117905',
                'nama_dosen'     => 'Dr. Hj. Nurhayati, M.M.',
                'program_studi' => 'S1-AKUNTANSI',
                'email'          => 'nurhayati@uis.ac.id',
                'no_hp'          => '081234567804',
                'url_surat_tugas'=> 'https://drive.google.com/file/d/surat-tugas-nurhayati/view',
                'status'         => 'Aktif',
            ],
        ];

        foreach ($dosens as $dosen) {
            Dosen::updateOrCreate(['nidn_nuptk' => $dosen['nidn_nuptk']], $dosen);
        }
    }
}
