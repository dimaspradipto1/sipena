<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kejuaraan extends Model
{
    use HasFactory;

    protected $table = 'kejuaraans';

    protected $fillable = [
        'nama_ajang',
        'jenis_penyelenggaraan',
        'tingkat_level',
        'kategori',
        'bentuk',
        'tempat',
        'url_ajang',
        'tahun',
        'url_laporan_kegiatan',
        'kode_pt',
        'nama_pt',
        'jumlah_peserta',
        'status',
    ];
}
