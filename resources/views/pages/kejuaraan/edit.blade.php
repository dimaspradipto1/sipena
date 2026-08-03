@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kejuaraan</h1>
    <p class="text-muted small mb-0">Perbarui data ajang dan laporan kegiatan per periode.</p>
    <nav class="mt-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kejuaraan.index') }}">Kejuaraan</a></li>
            <li class="breadcrumb-item active">Edit Form</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Top Blue Banner Widget -->
    <div class="card border-0 shadow-sm mb-4" style="background-color: #eff6ff;">
        <div class="card-body p-4">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2 fw-medium" style="font-size: 0.75rem;">Edit Kejuaraan</span>
            <h5 class="fw-bold text-dark mb-1">Data ajang dan laporan kegiatan</h5>
            <p class="text-muted small mb-3">Perbarui data ajang biasa maupun terverifikasi beserta tautan dokumen pendukungnya.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan input data:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('kejuaraan.update', $kejuaraan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Column: Form Cards (8 cols) -->
            <div class="col-lg-8">
                <!-- Card 1: Data Ajang -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="p-2 rounded-3 bg-primary-subtle text-primary me-3">
                                <i class="bi bi-trophy fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Data Ajang</h6>
                                <small class="text-muted">Informasi utama penyelenggaraan ajang atau lomba.</small>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="jenis_penyelenggaraan" class="form-label fw-medium small">Jenis Penyelenggaraan <span class="text-danger">*</span></label>
                                <select class="form-select" id="jenis_penyelenggaraan" name="jenis_penyelenggaraan" required>
                                    @foreach($options['jenis_penyelenggaraans'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('jenis_penyelenggaraan', $kejuaraan->jenis_penyelenggaraan) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tingkat_level" class="form-label fw-medium small">Tingkat / Level <span class="text-danger">*</span></label>
                                <select class="form-select" id="tingkat_level" name="tingkat_level" required>
                                    @foreach($options['tingkats'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('tingkat_level', $kejuaraan->tingkat_level) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="kategori" class="form-label fw-medium small">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    @foreach($options['kategoris'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('kategori', $kejuaraan->kategori) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="bentuk" class="form-label fw-medium small">Bentuk <span class="text-danger">*</span></label>
                                <select class="form-select" id="bentuk" name="bentuk" required>
                                    @foreach($options['bentuks'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('bentuk', $kejuaraan->bentuk) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="nama_ajang" class="form-label fw-medium small">Nama Ajang / Lomba <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lightbulb text-muted"></i></span>
                                    <input type="text" class="form-control @error('nama_ajang') is-invalid @enderror" id="nama_ajang" name="nama_ajang" value="{{ old('nama_ajang', $kejuaraan->nama_ajang) }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="tempat" class="form-label fw-medium small">Tempat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt text-muted"></i></span>
                                    <input type="text" class="form-control @error('tempat') is-invalid @enderror" id="tempat" name="tempat" value="{{ old('tempat', $kejuaraan->tempat) }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="url_ajang" class="form-label fw-medium small">URL Ajang <span class="text-danger">*</span></label>
                                <input type="url" class="form-control @error('url_ajang') is-invalid @enderror" id="url_ajang" name="url_ajang" value="{{ old('url_ajang', $kejuaraan->url_ajang) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="tahun" class="form-label fw-medium small">Tahun <span class="text-danger">*</span></label>
                                <select class="form-select" id="tahun" name="tahun" required>
                                    <option value="2026" {{ old('tahun', $kejuaraan->tahun) == 2026 ? 'selected' : '' }}>2026</option>
                                    <option value="2025" {{ old('tahun', $kejuaraan->tahun) == 2025 ? 'selected' : '' }}>2025</option>
                                    <option value="2024" {{ old('tahun', $kejuaraan->tahun) == 2024 ? 'selected' : '' }}>2024</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Laporan Kegiatan -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-2 rounded-3 bg-primary-subtle text-primary me-3">
                                <i class="bi bi-file-earmark-text fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Laporan Kegiatan</h6>
                                <small class="text-muted">Tautan dokumen laporan kegiatan.</small>
                            </div>
                        </div>

                        <div class="border rounded-3 p-3 bg-light-subtle">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-medium small">Tahun</label>
                                    <input type="text" class="form-control form-control-sm bg-light" value="{{ $kejuaraan->tahun }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="url_ajang_laporan" class="form-label fw-medium small">URL Ajang <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control form-control-sm" id="url_ajang_laporan" value="{{ old('url_ajang', $kejuaraan->url_ajang) }}" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="url_laporan_kegiatan" class="form-label fw-medium small">URL Laporan Kegiatan <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control form-control-sm" id="url_laporan_kegiatan" name="url_laporan_kegiatan" value="{{ old('url_laporan_kegiatan', $kejuaraan->url_laporan_kegiatan) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Panduan Pengisian (4 cols) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3">Panduan Pengisian</h6>
                        <ul class="text-muted small ps-3 mb-0" style="line-height: 1.6;">
                            <li class="mb-2">Ajang biasa membentuk 1 laporan tahun dari tahun yang dipilih.</li>
                            <li class="mb-2">Ajang terverifikasi membentuk 3 tahun berurutan secara otomatis.</li>
                            <li class="mb-2">Setiap tahun wajib memiliki URL Ajang dan URL Laporan Kegiatan.</li>
                            <li class="mb-0">Data peserta dan juara diisi pada halaman terpisah setelah diverifikasi.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Footer -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <a href="{{ route('kejuaraan.index') }}" class="btn btn-light border px-4 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-dark px-4 shadow-sm" style="background-color: #0f172a; border-color: #0f172a;">
                <i class="bi bi-save me-1"></i> Perbarui Data
            </button>
        </div>
    </form>
</section>
@endsection
