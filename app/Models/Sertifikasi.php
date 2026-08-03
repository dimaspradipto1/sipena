<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;

    protected $table = 'sertifikasis';

    protected $fillable = [
        'level',
        'nama_sertifikasi',
        'nama_penyelenggara',
        'url_sertifikasi',
        'link_dokumen_sertifikat',
        'tanggal_sertifikat',
        'link_foto_kegiatan',
        'link_dokumen_undangan',
        'keterangan',
        'tahun',
        'pt',
        'status',
        'data_mahasiswa',
        'data_dosen',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sertifikat' => 'date',
            'data_mahasiswa' => 'array',
            'data_dosen' => 'array',
        ];
    }
}
