@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Dosen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dosen.index') }}">Data Dosen</a></li>
            <li class="breadcrumb-item active">Edit Dosen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title m-0 p-0 text-dark fw-bold">Form Edit Data Dosen</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('dosen.update', $dosen->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nidn_nuptk" class="form-label fw-medium">NIDN / NUPTK</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class="bi bi-card-heading"></i></span>
                                    <input type="text" class="form-control @error('nidn_nuptk') is-invalid @enderror" id="nidn_nuptk" name="nidn_nuptk" value="{{ old('nidn_nuptk', $dosen->nidn_nuptk) }}" placeholder="Contoh: 0012058501">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="nama_dosen" class="form-label fw-medium">Nama Dosen beserta Gelar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" placeholder="Contoh: Hendra Wijaya, S.T., M.Eng." required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="program_studi" class="form-label fw-medium">Program Studi</label>
                                <select class="form-select @error('program_studi') is-invalid @enderror" id="program_studi" name="program_studi">
                                    <option value="" {{ empty($dosen->program_studi) ? 'selected' : '' }}>-- Pilih Program Studi --</option>
                                    @foreach($options['prodis'] as $key => $label)
                                        <option value="{{ $key }}" {{ old('program_studi', $dosen->program_studi) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium d-block">Status Dosen <span class="text-danger">*</span></label>
                                <div class="pt-2">
                                    @foreach($options['statuses'] as $key => $label)
                                        <div class="form-check form-check-inline me-4">
                                            <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="status_{{ strtolower($key) }}" value="{{ $key }}" {{ old('status', $dosen->status) == $key ? 'checked' : '' }} required>
                                            <label class="form-check-label fw-semibold text-dark" for="status_{{ strtolower($key) }}">
                                                <span class="badge {{ $key === 'Aktif' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }} px-2 py-1 me-1">
                                                    <i class="bi {{ $key === 'Aktif' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                                </span>
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium">Email Resmi / Kampus</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $dosen->email) }}" placeholder="contoh: hendra.dosen@uis.ac.id">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="no_hp" class="form-label fw-medium">Nomor Telepon / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $dosen->no_hp) }}" placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('dosen.index') }}" class="btn btn-light border px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Data Dosen
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
