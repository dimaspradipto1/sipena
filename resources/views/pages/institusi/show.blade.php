@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Institusi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('institusi.index') }}">Institusi</a></li>
            <li class="breadcrumb-item active">View Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <!-- SIMKATMAWA Soft Blue Header Banner -->
        <div class="col-lg-8 col-12 mb-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2 align-self-start">
                        Detail Institusi
                    </span>
                    <h5 class="fw-bold text-dark mb-1">Pengaturan Institusi & 70 Indikator SIMKATMAWA</h5>
                    <p class="text-secondary small mb-0">Rincian data profil perguruan tinggi, pimpinan, dan kelengkapan dokumen SIMKATMAWA.</p>
                </div>
            </div>
        </div>

        <!-- SIMKATMAWA Progress Widget Card (70 Indikator) -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small fw-medium">Indikator tercentang</span>
                        <span class="fw-bold text-dark fs-6">0 / 70</span>
                    </div>
                    <div class="progress mb-1" style="height: 8px; background-color: #e2e8f0;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="text-end mb-3">
                        <small class="text-secondary" style="font-size: 0.75rem;">0% kelengkapan</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small">Status</span>
                        <span class="fw-bold text-dark small">Submitted</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small">Tahun pelaporan</span>
                        <span class="fw-bold text-dark small">{{ date('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 1: Profil Perguruan Tinggi -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4 p-0">I. Profil Perguruan Tinggi</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Kode Perguruan Tinggi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small fw-bold">
                        {{ $institusi->kode_pt ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Nama Perguruan Tinggi</label>
                    <div class="p-2 rounded bg-light border-0 text-primary small fw-bold fs-6">
                        {{ $institusi->nama_pt ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Bentuk Perguruan Tinggi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->bentuk_pt ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Status Institusi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->status_institusi ?? '-' }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold text-dark mb-1">Alamat</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->alamat ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold text-dark mb-1">Kota / Kabupaten</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->kota ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold text-dark mb-1">Provinsi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->provinsi ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold text-dark mb-1">Telepon / Fax</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->telepon ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Email Resmi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->email ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Website Utama</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($institusi->website)
                            <a href="{{ $institusi->website }}" target="_blank" class="text-primary text-decoration-none">{{ $institusi->website }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Pimpinan -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4 p-0">II. Data Pimpinan & Kemahasiswaan</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Nama Rektor / Pimpinan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->nama_rektor ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">NIP / NIDN Rektor</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->nip_rektor ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Nama Warek III / Kabid Kemahasiswaan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->nama_warek3 ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">NIP / NIDN Warek III</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->nip_warek3 ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">No. HP / WhatsApp PIC Kemahasiswaan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->no_hp_pic ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Dokumen Pendukung -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4 p-0">III. Dokumen Pendukung SIMKATMAWA</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Link SK Pendirian / Akreditasi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($institusi->link_sk_pendirian)
                            <a href="{{ $institusi->link_sk_pendirian }}" target="_blank" class="text-primary text-decoration-none">{{ $institusi->link_sk_pendirian }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Link Pedoman Kemahasiswaan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($institusi->link_pedoman_kemahasiswaan)
                            <a href="{{ $institusi->link_pedoman_kemahasiswaan }}" target="_blank" class="text-primary text-decoration-none">{{ $institusi->link_pedoman_kemahasiswaan }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-bold text-dark mb-1">Link Struktur Organisasi</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small text-break">
                        @if($institusi->link_struktur_organisasi)
                            <a href="{{ $institusi->link_struktur_organisasi }}" target="_blank" class="text-primary text-decoration-none">{{ $institusi->link_struktur_organisasi }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold text-dark mb-1">Keterangan / Catatan Tambahan</label>
                    <div class="p-2 rounded bg-light border-0 text-dark small">
                        {{ $institusi->keterangan ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('institusi.index') }}" class="btn text-white fw-medium px-4 shadow-sm" style="background-color: #f97316; border-color: #f97316;">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
