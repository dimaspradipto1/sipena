<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekognisi extends Model
{
    use HasFactory;

    protected $table = 'rekognisis';

    protected $fillable = [
        'level',
        'nama_rekognisi',
        'jenis',
        'nama_penyelenggara',
        'url_rekognisi',
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
