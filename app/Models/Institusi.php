<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institusi extends Model
{
    use HasFactory;

    protected $table = 'institusis';

    protected $fillable = [
        'kode_pt',
        'nama_pt',
        'bentuk_pt',
        'status_institusi',
        'alamat',
        'kota',
        'provinsi',
        'telepon',
        'email',
        'website',
        'nama_rektor',
        'nip_rektor',
        'nama_warek3',
        'nip_warek3',
        'no_hp_pic',
        'link_sk_pendirian',
        'link_pedoman_kemahasiswaan',
        'link_struktur_organisasi',
        'tahun_pelaporan',
        'mhs_nonapbn',
        'mhs_aktif',
        'link_nonapbn',
        'link_mhs_aktif',
        'level_kelembagaan',
        'link_sk_pengangkat_pimpinan',
        'link_struktur_pengelola_kemahasiswaan',
        'total_anggaran_pt',
        'total_anggaran_kemahasiswaan',
        'link_anggaran_pt',
        'link_anggaran_kemahasiswaan',
        'data_indikator',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'data_indikator'               => 'array',
        'mhs_nonapbn'                  => 'integer',
        'mhs_aktif'                     => 'integer',
        'total_anggaran_pt'            => 'float',
        'total_anggaran_kemahasiswaan' => 'float',
    ];
}
