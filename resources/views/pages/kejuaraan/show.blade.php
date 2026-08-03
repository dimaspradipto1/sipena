@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Kejuaraan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kejuaraan.index') }}">Kejuaraan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 p-0 text-dark fw-bold">Detail Laporan Kejuaraan #{{ str_pad($kejuaraan->id, 6, '0', STR_PAD_LEFT) }}</h5>
                    <div>
                        <a href="{{ route('kejuaraan.edit', $kejuaraan->id) }}" class="btn btn-warning text-white btn-sm px-3 me-2">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('kejuaraan.index') }}" class="btn btn-light border btn-sm px-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem;">NAMA AJANG / LOMBA</small>
                                <h5 class="fw-bold text-dark mb-1">{{ $kejuaraan->nama_ajang }}</h5>
                                <span class="badge bg-primary mb-2">{{ $kejuaraan->jenis_penyelenggaraan }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem;">LEVEL & BENTUK</small>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-info text-white fs-6">{{ $kejuaraan->tingkat_level }}</span>
                                    <span class="badge bg-secondary text-white">{{ $kejuaraan->bentuk }}</span>
                                    <span class="badge bg-light text-dark border">Tahun {{ $kejuaraan->tahun }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-geo-alt me-2"></i> Lokasi & Perguruan Tinggi</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td style="width: 35%;" class="text-muted">Tempat Penyelenggaraan</td>
                                    <td style="width: 5%;">:</td>
                                    <td class="fw-medium text-dark">{{ $kejuaraan->tempat }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kategori</td>
                                    <td>:</td>
                                    <td>{{ $kejuaraan->kategori }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Perguruan Tinggi</td>
                                    <td>:</td>
                                    <td class="fw-bold text-dark">{{ $kejuaraan->nama_pt }} ({{ $kejuaraan->kode_pt }})</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-people me-2"></i> Status & Peserta</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td style="width: 35%;" class="text-muted">Jumlah Peserta</td>
                                    <td style="width: 5%;">:</td>
                                    <td><span class="badge bg-light text-primary border fw-bold">{{ $kejuaraan->jumlah_peserta ?? 0 }} Peserta</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status Laporan</td>
                                    <td>:</td>
                                    <td><span class="badge bg-success px-3 py-1">{{ $kejuaraan->status }}</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-link-45deg me-2"></i> Tautan Dokumen Pendukung</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <small class="text-muted d-block mb-1">URL Ajang / Microsite Resmi</small>
                                        @if($kejuaraan->url_ajang)
                                            <a href="{{ $kejuaraan->url_ajang }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-globe me-1"></i> Buka Website Ajang
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak melampirkan URL</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <small class="text-muted d-block mb-1">URL Laporan Kegiatan</small>
                                        @if($kejuaraan->url_laporan_kegiatan)
                                            <a href="{{ $kejuaraan->url_laporan_kegiatan }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Laporan Kegiatan
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak melampirkan laporan</span>
                                        @endif
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
