@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Rekognisi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rekognisi.index') }}">Rekognisi</a></li>
            <li class="breadcrumb-item active">Form</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4 p-0">View Data</h5>

            <div class="row g-3">
                <!-- Level & Nama Rekognisi -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Level</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $rekognisi->level ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Nama Rekognisi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small fw-bold text-primary">
                        {{ $rekognisi->nama_rekognisi ?? '-' }}
                    </div>
                </div>

                <!-- Jenis & Nama Penyelenggara/Mitra -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Jenis</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $rekognisi->jenis ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Nama Penyelenggara/Mitra</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $rekognisi->nama_penyelenggara ?? '-' }}
                    </div>
                </div>

                <!-- URL Rekognisi -->
                <div class="col-12">
                    <label class="form-label small fw-bold text-dark mb-1">URL Rekognisi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($rekognisi->url_rekognisi)
                            <a href="{{ $rekognisi->url_rekognisi }}" target="_blank" class="text-primary text-decoration-none">{{ $rekognisi->url_rekognisi }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Link Dokumen Sertifikat & Tanggal Sertifikat -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Link Dokumen Sertifikat</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($rekognisi->link_dokumen_sertifikat)
                            <a href="{{ $rekognisi->link_dokumen_sertifikat }}" target="_blank" class="text-primary text-decoration-none">{{ $rekognisi->link_dokumen_sertifikat }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Tanggal Sertifikat</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $rekognisi->tanggal_sertifikat ? $rekognisi->tanggal_sertifikat->format('Y-m-d') : '-' }}
                    </div>
                </div>

                <!-- Link Foto Kegiatan & Link Dokumen/Undangan/Bukti Lain -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Link Foto Kegiatan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($rekognisi->link_foto_kegiatan)
                            <a href="{{ $rekognisi->link_foto_kegiatan }}" target="_blank" class="text-primary text-decoration-none">{{ $rekognisi->link_foto_kegiatan }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Link Dokumen/Undangan/Bukti Lain</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($rekognisi->link_dokumen_undangan)
                            <a href="{{ $rekognisi->link_dokumen_undangan }}" target="_blank" class="text-primary text-decoration-none">{{ $rekognisi->link_dokumen_undangan }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="col-12">
                    <label class="form-label small fw-bold text-dark mb-1">Keterangan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $rekognisi->keterangan ?? '-' }}
                    </div>
                </div>

                <!-- Data Mahasiswa Table -->
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-dark mb-2">Data Mahasiswa</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 60px;">No</th>
                                    <th style="width: 250px;">NIM</th>
                                    <th>Nama Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($rekognisi->data_mahasiswa) && count($rekognisi->data_mahasiswa) > 0)
                                    @foreach($rekognisi->data_mahasiswa as $idx => $mhs)
                                        <tr>
                                            <td class="fw-bold">{{ $idx + 1 }}</td>
                                            <td>{{ $mhs['nim'] ?? '-' }}</td>
                                            <td>{{ $mhs['nama'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center text-muted small py-3">Belum ada data mahasiswa</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Data Dosen Table -->
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-dark mb-2">Data Dosen</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 60px;">No</th>
                                    <th style="width: 250px;">NUPTK/NIDN</th>
                                    <th>Nama Dosen</th>
                                    <th>Surat Tugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($rekognisi->data_dosen) && count($rekognisi->data_dosen) > 0)
                                    @foreach($rekognisi->data_dosen as $idx => $dsn)
                                        <tr>
                                            <td class="fw-bold">{{ $idx + 1 }}</td>
                                            <td>{{ $dsn['nidn'] ?? '-' }}</td>
                                            <td>{{ $dsn['nama'] ?? '-' }}</td>
                                            <td>
                                                @if(!empty($dsn['url_surat']))
                                                    <a href="{{ $dsn['url_surat'] }}" target="_blank" class="text-primary text-decoration-none">{{ $dsn['url_surat'] }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted small py-3">Belum ada data dosen</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bottom Button -->
                <div class="col-12 mt-4">
                    <a href="{{ route('rekognisi.index') }}" class="btn text-white fw-medium px-4 shadow-sm" style="background-color: #f97316; border-color: #f97316;">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
