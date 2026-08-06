@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Data Dosen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dosen.index') }}">Data Dosen</a></li>
            <li class="breadcrumb-item active">Detail Dosen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 p-0 text-dark fw-bold">
                <i class="bi bi-person-vcard text-primary me-2"></i> {{ $dosen->nama_dosen }}
            </h5>
            <span class="badge {{ $dosen->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }} px-3 py-1 fs-7">
                {{ $dosen->status }}
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="text-muted small fw-semibold">NIDN / NUPTK</label>
                    <div class="fs-6 fw-bold text-dark font-monospace">{{ $dosen->nidn_nuptk ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small fw-semibold">Program Studi</label>
                    <div class="fs-6 fw-bold text-dark">{{ $dosen->program_studi ?? 'Teknik Informatika' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small fw-semibold">Email Kampus</label>
                    <div class="fs-6 text-dark">{{ $dosen->email ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small fw-semibold">Nomor Telepon / WA</label>
                    <div class="fs-6 text-dark">{{ $dosen->no_hp ?? '-' }}</div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                <a href="{{ route('dosen.index') }}" class="btn btn-light border px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-warning text-white px-4">
                    <i class="bi bi-pencil-square me-1"></i> Edit Dosen
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
