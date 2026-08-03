@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Prestasi Belmawa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('prestasi-belmawa.index') }}">Prestasi Belmawa</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 p-0 text-dark fw-bold">Rincian Prestasi Belmawa #{{ str_pad($prestasiBelmawa->id, 6, '0', STR_PAD_LEFT) }}</h5>
                    <div>
                        <a href="{{ route('prestasi-belmawa.edit', $prestasiBelmawa->id) }}" class="btn btn-warning text-white btn-sm px-3 me-2">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('prestasi-belmawa.index') }}" class="btn btn-light border btn-sm px-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem;">NAMA LOMBA / KOMPETISI BELMAWA</small>
                                <h5 class="fw-bold text-dark mb-1">{{ $prestasiBelmawa->nama_lomba }}</h5>
                                <span class="badge bg-secondary mb-2">{{ $prestasiBelmawa->kategori_lomba ?? 'Umum' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem;">CAPAIAN PRESTASI & TINGKAT</small>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-warning text-dark fs-6"><i class="bi bi-trophy me-1"></i> {{ $prestasiBelmawa->capaian_prestasi }}</span>
                                    <span class="badge bg-info text-white">{{ $prestasiBelmawa->tingkat }}</span>
                                    <span class="badge bg-light text-dark border">Tahun {{ $prestasiBelmawa->tahun }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-building me-2"></i> Perguruan Tinggi</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td style="width: 35%;" class="text-muted">Kode PT</td>
                                    <td style="width: 5%;">:</td>
                                    <td class="fw-medium">{{ $prestasiBelmawa->kode_pt }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nama Perguruan Tinggi</td>
                                    <td>:</td>
                                    <td class="fw-bold text-dark">{{ $prestasiBelmawa->nama_pt }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-people me-2"></i> Mahasiswa & Pembimbing</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td style="width: 35%;" class="text-muted">Nama Mahasiswa / Tim</td>
                                    <td style="width: 5%;">:</td>
                                    <td class="fw-medium text-dark">{{ $prestasiBelmawa->nama_mahasiswa ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">NIM / Program Studi</td>
                                    <td>:</td>
                                    <td>{{ $prestasiBelmawa->nim ?? '-' }} ({{ $prestasiBelmawa->program_studi ?? '-' }})</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Dosen Pembimbing</td>
                                    <td>:</td>
                                    <td>{{ $prestasiBelmawa->dosen_pembimbing ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-text me-2"></i> Dokumen & Keterangan</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <small class="text-muted d-block mb-1">SK Kemendikbudristek / Belmawa</small>
                                        @if($prestasiBelmawa->link_sk_kemendikbud)
                                            <a href="{{ $prestasiBelmawa->link_sk_kemendikbud }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-link-45deg me-1"></i> Buka Tautan SK Belmawa
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak melampirkan tautan</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <small class="text-muted d-block mb-1">Sertifikat / Bukti Prestasi</small>
                                        @if($prestasiBelmawa->link_sertifikat)
                                            <a href="{{ $prestasiBelmawa->link_sertifikat }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-award me-1"></i> Lihat Sertifikat
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak melampirkan sertifikat</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="p-3 bg-light rounded">
                                        <small class="text-muted d-block mb-1 fw-medium">Catatan / Keterangan:</small>
                                        <p class="mb-0 text-dark">{{ $prestasiBelmawa->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
