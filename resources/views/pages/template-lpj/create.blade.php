@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Template LPJ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('template-lpj.index') }}">Template LPJ</a></li>
            <li class="breadcrumb-item active">Tambah Template</li>
        </ol>
    </nav>
    <p class="text-muted small">Tambahkan tautan kustom atau berkas baru untuk dokumen template LPJ.</p>
</div><!-- End Page Title -->

<section class="section">
    <!-- Header Soft Blue Banner -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div class="card-body p-4">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2">
                Tambah Dokumen
            </span>
            <h5 class="fw-bold text-dark mb-1">Form Input Template LPJ</h5>
            <p class="text-secondary small mb-0">Anda dapat menautkan link Google Drive, OneDrive, atau mengunggah berkas Microsoft Word (.docx) secara langsung.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan input data:</h6>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('template-lpj.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="p-2 rounded-circle bg-primary-subtle text-primary me-3">
                        <i class="bi bi-file-earmark-arrow-down fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Detail Template LPJ</h5>
                        <small class="text-muted">Lengkapi informasi nama template, kategori, serta tautan atau berkas.</small>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Nama Template -->
                    <div class="col-md-8">
                        <label for="nama" class="form-label fw-medium">Nama Dokumen Template <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-file-text"></i></span>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Template LPJ Prestasi Mandiri 2026" required>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-4">
                        <label for="kategori" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                            @foreach($kategoriList as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', 'Prestasi Mandiri') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipe Sumber -->
                    <div class="col-12">
                        <label class="form-label fw-medium d-block">Tipe Sumber Dokumen <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 p-3 bg-light rounded-3 border">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe" id="tipe_link" value="link" {{ old('tipe', 'link') === 'link' ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium cursor-pointer" for="tipe_link">
                                    <i class="bi bi-link-45deg text-primary me-1"></i> Custom Link (Google Drive / OneDrive / URL Eksternal)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe" id="tipe_file" value="file" {{ old('tipe') === 'file' ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium cursor-pointer" for="tipe_file">
                                    <i class="bi bi-upload text-success me-1"></i> Unggah File Langsung (.docx / .pdf)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section Link URL -->
                    <div class="col-12" id="section-link">
                        <label for="url_link" class="form-label fw-medium">Tautan Kustom Download (URL) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-link"></i></span>
                            <input type="url" class="form-control @error('url_link') is-invalid @enderror" id="url_link" name="url_link" value="{{ old('url_link') }}" placeholder="https://drive.google.com/file/d/... atau https://...">
                        </div>
                        <small class="text-muted">Pastikan izin akses tautan Google Drive / cloud storage telah disetel agar dapat diakses atau diunduh oleh siapa saja yang memiliki link.</small>
                    </div>

                    <!-- Section File Upload -->
                    <div class="col-12 d-none" id="section-file">
                        <label for="file_document" class="form-label fw-medium">Unggah Berkas Dokumen <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file_document') is-invalid @enderror" id="file_document" name="file_document" accept=".docx,.doc,.pdf,.odt,.zip">
                        <small class="text-muted">Format file yang didukung: .docx, .doc, .pdf, .odt, .zip (Maksimal 20 MB).</small>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-12">
                        <label for="keterangan" class="form-label fw-medium">Keterangan / Petunjuk Pengisian</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Tuliskan catatan panduan atau instruksi penggunaan template ini...">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Status Aktif Checkbox -->
                    <div class="col-12">
                        <div class="form-check form-switch p-3 bg-light rounded-3 border">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">
                                <span class="text-dark">Jadikan Template Aktif (Default)</span>
                                <small class="text-muted d-block fw-normal">Jika dicentang, template ini akan langsung digunakan secara otomatis ketika mahasiswa atau dosen mengunduh template LPJ.</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Footer -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <a href="{{ route('template-lpj.index') }}" class="btn btn-light border px-4 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-dark px-4 shadow-sm" style="background-color: #0f172a; border-color: #0f172a;">
                <i class="bi bi-save me-1"></i> Simpan Template
            </button>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioLink = document.getElementById('tipe_link');
    const radioFile = document.getElementById('tipe_file');
    const sectionLink = document.getElementById('section-link');
    const sectionFile = document.getElementById('section-file');
    const inputUrl = document.getElementById('url_link');
    const inputFile = document.getElementById('file_document');

    function toggleSourceSection() {
        if (radioFile.checked) {
            sectionLink.classList.add('d-none');
            sectionFile.classList.remove('d-none');
            inputUrl.removeAttribute('required');
            inputFile.setAttribute('required', 'required');
        } else {
            sectionLink.classList.remove('d-none');
            sectionFile.classList.add('d-none');
            inputUrl.setAttribute('required', 'required');
            inputFile.removeAttribute('required');
        }
    }

    radioLink.addEventListener('change', toggleSourceSection);
    radioFile.addEventListener('change', toggleSourceSection);

    // Initial run
    toggleSourceSection();
});
</script>
@endsection
