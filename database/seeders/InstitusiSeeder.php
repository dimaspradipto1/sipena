<?php

namespace Database\Seeders;

use App\Models\Institusi;
use Illuminate\Database\Seeder;

class InstitusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'kode_pt'                    => '101015',
                'nama_pt'                    => 'Universitas Ibnu Sina',
                'bentuk_pt'                  => 'Universitas',
                'status_institusi'           => 'Swasta (PTS)',
                'alamat'                     => 'Jl. Teuku Umar, Pelita, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
                'kota'                       => 'Kota Batam',
                'provinsi'                   => 'Kepulauan Riau',
                'telepon'                    => '(0778) 4083113',
                'email'                      => 'info@uis.ac.id',
                'website'                    => 'https://uis.ac.id',
                'nama_rektor'                => 'Prof. Dr. Ir. H. Muhammad Ridwan, M.T.',
                'nip_rektor'                 => '196508121992031002',
                'nama_warek3'                => 'Dr. H. Ahmad Dahlan, M.Pd.',
                'nip_warek3'                 => '197204152000031001',
                'no_hp_pic'                  => '081270001122',
                'link_sk_pendirian'          => 'https://drive.google.com/file/d/sk-pendirian-uis/view',
                'link_pedoman_kemahasiswaan' => 'https://drive.google.com/file/d/pedoman-kemahasiswaan-uis/view',
                'link_struktur_organisasi'   => 'https://drive.google.com/file/d/struktur-organisasi-uis/view',
                'keterangan'                 => 'Institusi Perguruan Tinggi Swasta Unggul di Kota Batam.',
                'status'                     => 'Aktif',
            ],
        ];

        foreach ($records as $record) {
            Institusi::create($record);
        }
    }
}
