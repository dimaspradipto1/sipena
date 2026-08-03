<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiBelmawa extends Model
{
    use HasFactory;

    protected $table = 'prestasi_belmawas';

    protected $fillable = [
        'nama_lomba',
        'kategori_lomba',
        'tingkat',
        'capaian_prestasi',
        'tahun',
        'kode_pt',
        'nama_pt',
        'nama_mahasiswa',
        'nim',
        'program_studi',
        'dosen_pembimbing',
        'link_sk_kemendikbud',
        'link_sertifikat',
        'keterangan',
        'status',
    ];
}
