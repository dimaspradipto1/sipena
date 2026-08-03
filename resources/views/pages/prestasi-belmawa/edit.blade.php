@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Prestasi Belmawa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('prestasi-belmawa.index') }}">Prestasi Belmawa</a></li>
            <li class="breadcrumb-item active">Edit Prestasi Belmawa</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan input data:</h6>
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title m-0 p-0 text-dark fw-bold">Edit Data Prestasi Belmawa</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('prestasi-belmawa.update', $prestasiBelmawa->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_lomba" class="form-label fw-medium">Nama Lomba / Ajang Kompetisi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lomba') is-invalid @enderror" id="nama_lomba" name="nama_lomba" value="{{ old('nama_lomba', $prestasiBelmawa->nama_lomba) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="kategori_lomba" class="form-label fw-medium">Kategori / Divisi Lomba</label>
                                <input type="text" class="form-control" id="kategori_lomba" name="kategori_lomba" value="{{ old('kategori_lomba', $prestasiBelmawa->kategori_lomba) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="tingkat" class="form-label fw-medium">Tingkat Kompetisi <span class="text-danger">*</span></label>
                                <select class="form-select" id="tingkat" name="tingkat" required>
                                    @foreach($options['tingkats'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('tingkat', $prestasiBelmawa->tingkat) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="capaian_prestasi" class="form-label fw-medium">Capaian Prestasi <span class="text-danger">*</span></label>
                                <select class="form-select" id="capaian_prestasi" name="capaian_prestasi" required>
                                    @foreach($options['prestasis'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('capaian_prestasi', $prestasiBelmawa->capaian_prestasi) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="tahun" class="form-label fw-medium">Tahun Kegiatan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', $prestasiBelmawa->tahun) }}" required min="2000" max="2099">
                            </div>

                            <div class="col-md-6">
                                <label for="kode_pt" class="form-label fw-medium">Kode Perguruan Tinggi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_pt" name="kode_pt" value="{{ old('kode_pt', $prestasiBelmawa->kode_pt) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="nama_pt" class="form-label fw-medium">Nama Perguruan Tinggi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pt" name="nama_pt" value="{{ old('nama_pt', $prestasiBelmawa->nama_pt) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="nama_mahasiswa" class="form-label fw-medium">Nama Mahasiswa / Tim Peserta</label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $prestasiBelmawa->nama_mahasiswa) }}">
                            </div>

                            <div class="col-md-3">
                                <label for="nim" class="form-label fw-medium">NIM (Nomor Induk Mahasiswa)</label>
                                <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $prestasiBelmawa->nim) }}">
                            </div>

                            <div class="col-md-3">
                                <label for="program_studi" class="form-label fw-medium">Program Studi</label>
                                <input type="text" class="form-control" id="program_studi" name="program_studi" value="{{ old('program_studi', $prestasiBelmawa->program_studi) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="dosen_pembimbing" class="form-label fw-medium">Dosen Pembimbing</label>
                                <input type="text" class="form-control" id="dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing', $prestasiBelmawa->dosen_pembimbing) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="link_sk_kemendikbud" class="form-label fw-medium">Link SK Kemendikbudristek / Belmawa</label>
                                <input type="url" class="form-control" id="link_sk_kemendikbud" name="link_sk_kemendikbud" value="{{ old('link_sk_kemendikbud', $prestasiBelmawa->link_sk_kemendikbud) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="link_sertifikat" class="form-label fw-medium">Link Sertifikat / Bukti Prestasi</label>
                                <input type="url" class="form-control" id="link_sertifikat" name="link_sertifikat" value="{{ old('link_sertifikat', $prestasiBelmawa->link_sertifikat) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-medium">Status Verifikasi</label>
                                <select class="form-select" id="status" name="status">
                                    @foreach($options['statuses'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('status', $prestasiBelmawa->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="keterangan" class="form-label fw-medium">Keterangan / Catatan Tambahan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $prestasiBelmawa->keterangan) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('prestasi-belmawa.index') }}" class="btn btn-light border px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Perbarui Data Prestasi Belmawa
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
