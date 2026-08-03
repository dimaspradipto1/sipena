@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Prestasi Mandiri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('prestasi-mandiri.index') }}">Prestasi Mandiri</a></li>
            <li class="breadcrumb-item active">Tambah Prestasi</li>
        </ol>
    </nav>
    <p class="text-muted small">Lengkapi data prestasi, mahasiswa, dan dosen pendamping dalam satu alur.</p>
</div><!-- End Page Title -->

<section class="section">
    <!-- SIMKATMAWA Soft Blue Header Banner -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div class="card-body p-4">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2">
                Tambah Prestasi
            </span>
            <h5 class="fw-bold text-dark mb-1">Form prestasi mandiri terpadu</h5>
            <p class="text-secondary small mb-0">Data mahasiswa dan dosen kini diisi langsung di form ini, sehingga tidak perlu berpindah halaman setelah data prestasi tersimpan.</p>
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

    <form action="{{ route('prestasi-mandiri.store') }}" method="POST">
        @csrf

        <!-- Card 1: Data Prestasi -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 rounded-circle bg-primary-subtle text-primary me-3">
                        <i class="bi bi-trophy fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Data Prestasi</h5>
                        <small class="text-muted">Informasi kompetisi, prestasi, dan dokumen bukti utama.</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="level" class="form-label fw-medium">Level<span class="text-danger">*</span></label>
                        <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                            <option value="" disabled {{ old('level', $prestasiMandiri->level ?? '') ? '' : 'selected' }}>Pilih Level</option>
                            @foreach($options['levels'] as $key => $label)
                                <option value="{{ $key }}" {{ old('level', $prestasiMandiri->level ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="kategori" class="form-label fw-medium">Kategori<span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                            <option value="" disabled {{ old('kategori', $prestasiMandiri->kategori ?? '') ? '' : 'selected' }}>Pilih Kategori</option>
                            @foreach($options['kategoris'] as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', $prestasiMandiri->kategori ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="nama_kompetisi" class="form-label fw-medium">Nama Kompetisi / Lomba<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-award"></i></span>
                            <input type="text" class="form-control @error('nama_kompetisi') is-invalid @enderror" id="nama_kompetisi" name="nama_kompetisi" value="{{ old('nama_kompetisi', $prestasiMandiri->nama_kompetisi ?? '') }}" placeholder="Nama Kompetisi / Lomba" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nama_cabang" class="form-label fw-medium">Nama Cabang<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-diagram-3"></i></span>
                            <input type="text" class="form-control @error('nama_cabang') is-invalid @enderror" id="nama_cabang" name="nama_cabang" value="{{ old('nama_cabang', $prestasiMandiri->nama_cabang ?? '') }}" placeholder="Nama Cabang" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="peringkat" class="form-label fw-medium">Peringkat<span class="text-danger">*</span></label>
                        <select class="form-select @error('peringkat') is-invalid @enderror" id="peringkat" name="peringkat" required>
                            <option value="" disabled {{ old('peringkat', $prestasiMandiri->peringkat ?? '') ? '' : 'selected' }}>Pilih Peringkat</option>
                            @foreach($options['peringkats'] as $key => $label)
                                <option value="{{ $key }}" {{ old('peringkat', $prestasiMandiri->peringkat ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="nama_penyelenggara" class="form-label fw-medium">Nama Penyelenggara<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-building"></i></span>
                            <input type="text" class="form-control @error('nama_penyelenggara') is-invalid @enderror" id="nama_penyelenggara" name="nama_penyelenggara" value="{{ old('nama_penyelenggara', $prestasiMandiri->nama_penyelenggara ?? '') }}" placeholder="Penyelenggara" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="jumlah_pt_peserta" class="form-label fw-medium">Jumlah PT Peserta<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-people"></i></span>
                            <input type="number" class="form-control @error('jumlah_pt_peserta') is-invalid @enderror" id="jumlah_pt_peserta" name="jumlah_pt_peserta" value="{{ old('jumlah_pt_peserta', $prestasiMandiri->jumlah_pt_peserta ?? '') }}" placeholder="Jumlah">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="kepesertaan" class="form-label fw-medium">Kepesertaan<span class="text-danger">*</span></label>
                        <select class="form-select @error('kepesertaan') is-invalid @enderror" id="kepesertaan" name="kepesertaan" required>
                            <option value="" disabled {{ old('kepesertaan', $prestasiMandiri->kepesertaan ?? '') ? '' : 'selected' }}>Pilih Kepesertaan</option>
                            @foreach($options['kepesertaans'] as $key => $label)
                                <option value="{{ $key }}" {{ old('kepesertaan', $prestasiMandiri->kepesertaan ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="bentuk" class="form-label fw-medium">Bentuk<span class="text-danger">*</span></label>
                        <select class="form-select @error('bentuk') is-invalid @enderror" id="bentuk" name="bentuk" required>
                            <option value="" disabled {{ old('bentuk', $prestasiMandiri->bentuk ?? '') ? '' : 'selected' }}>Pilih Bentuk</option>
                            @foreach($options['bentuks'] as $key => $label)
                                <option value="{{ $key }}" {{ old('bentuk', $prestasiMandiri->bentuk ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="url_kompetisi" class="form-label fw-medium">URL Kompetisi / Lomba<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" class="form-control @error('url_kompetisi') is-invalid @enderror" id="url_kompetisi" name="url_kompetisi" value="{{ old('url_kompetisi', $prestasiMandiri->url_kompetisi ?? '') }}" placeholder="URL">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="link_dokumen_sertifikat" class="form-label fw-medium">Link Dokumen Sertifikat<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" class="form-control @error('link_dokumen_sertifikat') is-invalid @enderror" id="link_dokumen_sertifikat" name="link_dokumen_sertifikat" value="{{ old('link_dokumen_sertifikat', $prestasiMandiri->link_dokumen_sertifikat ?? '') }}" placeholder="URL">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_sertifikat" class="form-label fw-medium">Tanggal Sertifikat<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" class="form-control @error('tanggal_sertifikat') is-invalid @enderror" id="tanggal_sertifikat" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', isset($prestasiMandiri->tanggal_sertifikat) && $prestasiMandiri->tanggal_sertifikat ? $prestasiMandiri->tanggal_sertifikat->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="link_foto_upp" class="form-label fw-medium">Link Foto UPP</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" class="form-control @error('link_foto_upp') is-invalid @enderror" id="link_foto_upp" name="link_foto_upp" value="{{ old('link_foto_upp', $prestasiMandiri->link_foto_upp ?? '') }}" placeholder="URL">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="link_dokumen_undangan" class="form-label fw-medium">Link Dokumen Undangan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" class="form-control @error('link_dokumen_undangan') is-invalid @enderror" id="link_dokumen_undangan" name="link_dokumen_undangan" value="{{ old('link_dokumen_undangan', $prestasiMandiri->link_dokumen_undangan ?? '') }}" placeholder="URL">
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="keterangan" class="form-label fw-medium">Keterangan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $prestasiMandiri->keterangan ?? '') }}" placeholder="Keterangan tambahan">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Data Mahasiswa -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-circle bg-primary-subtle text-primary me-3">
                            <i class="bi bi-person fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Data Mahasiswa</h5>
                            <small class="text-muted">Minimal satu mahasiswa wajib diisi sebelum data dapat disimpan.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-add-mahasiswa">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>

                <div id="container-mahasiswa">
                    @php
                        $mahasiswaList = old('data_mahasiswa', $prestasiMandiri->data_mahasiswa ?? [['nim' => '', 'nama' => '']]);
                        if (empty($mahasiswaList)) {
                            $mahasiswaList = [['nim' => '', 'nama' => '']];
                        }
                    @endphp

                    @foreach($mahasiswaList as $index => $mhs)
                        <div class="row g-3 align-items-end mb-2 row-mahasiswa">
                            <div class="col-md-5">
                                <label class="form-label small fw-medium text-secondary mb-1">NIM <span class="text-danger">*</span></label>
                                <input type="text" name="data_mahasiswa[{{ $index }}][nim]" class="form-control form-control-sm" placeholder="NIM" value="{{ $mhs['nim'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-medium text-secondary mb-1">Nama Mahasiswa <span class="text-danger">*</span></label>
                                <input type="text" name="data_mahasiswa[{{ $index }}][nama]" class="form-control form-control-sm" placeholder="Nama Mahasiswa" value="{{ $mhs['nama'] ?? '' }}">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" style="padding: 4px 10px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Card 3: Data Dosen Pendamping -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-circle bg-primary-subtle text-primary me-3">
                            <i class="bi bi-person-badge fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Data Dosen Pendamping</h5>
                            <small class="text-muted">Isi dosen pendamping beserta tautan surat tugasnya.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-add-dosen">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>

                <div id="container-dosen">
                    @php
                        $dosenList = old('data_dosen', $prestasiMandiri->data_dosen ?? [['nidn' => '', 'nama' => '', 'url_surat' => '']]);
                        if (empty($dosenList)) {
                            $dosenList = [['nidn' => '', 'nama' => '', 'url_surat' => '']];
                        }
                    @endphp

                    @foreach($dosenList as $index => $dsn)
                        <div class="row g-3 align-items-end mb-2 row-dosen">
                            <div class="col-md-3">
                                <label class="form-label small fw-medium text-secondary mb-1">NIDN/NUPTK</label>
                                <input type="text" name="data_dosen[{{ $index }}][nidn]" class="form-control form-control-sm" placeholder="NIDN/NUPTK" value="{{ $dsn['nidn'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-secondary mb-1">Nama Dosen</label>
                                <input type="text" name="data_dosen[{{ $index }}][nama]" class="form-control form-control-sm" placeholder="Nama Dosen" value="{{ $dsn['nama'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-secondary mb-1">URL Surat Tugas</label>
                                <input type="text" name="data_dosen[{{ $index }}][url_surat]" class="form-control form-control-sm" placeholder="URL Surat Tugas" value="{{ $dsn['url_surat'] ?? '' }}">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" style="padding: 4px 10px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Action Footer -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <a href="{{ route('prestasi-mandiri.index') }}" class="btn btn-light border px-4 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-dark px-4 shadow-sm" style="background-color: #0f172a; border-color: #0f172a;">
                <i class="bi bi-save me-1"></i> Simpan Data
            </button>
        </div>
    </form>
</section>

<!-- Dynamic Rows JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    let mhsIndex = {{ count($mahasiswaList) }};
    let dsnIndex = {{ count($dosenList) }};

    // Add Mahasiswa Row
    document.getElementById('btn-add-mahasiswa').addEventListener('click', function () {
        const container = document.getElementById('container-mahasiswa');
        const row = document.createElement('div');
        row.className = 'row g-3 align-items-end mb-2 row-mahasiswa';
        row.innerHTML = `
            <div class="col-md-5">
                <label class="form-label small fw-medium text-secondary mb-1">NIM <span class="text-danger">*</span></label>
                <input type="text" name="data_mahasiswa[${mhsIndex}][nim]" class="form-control form-control-sm" placeholder="NIM">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-medium text-secondary mb-1">Nama Mahasiswa <span class="text-danger">*</span></label>
                <input type="text" name="data_mahasiswa[${mhsIndex}][nama]" class="form-control form-control-sm" placeholder="Nama Mahasiswa">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" style="padding: 4px 10px;">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        mhsIndex++;
    });

    // Add Dosen Row
    document.getElementById('btn-add-dosen').addEventListener('click', function () {
        const container = document.getElementById('container-dosen');
        const row = document.createElement('div');
        row.className = 'row g-3 align-items-end mb-2 row-dosen';
        row.innerHTML = `
            <div class="col-md-3">
                <label class="form-label small fw-medium text-secondary mb-1">NIDN/NUPTK</label>
                <input type="text" name="data_dosen[${dsnIndex}][nidn]" class="form-control form-control-sm" placeholder="NIDN/NUPTK">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-medium text-secondary mb-1">Nama Dosen</label>
                <input type="text" name="data_dosen[${dsnIndex}][nama]" class="form-control form-control-sm" placeholder="Nama Dosen">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-medium text-secondary mb-1">URL Surat Tugas</label>
                <input type="text" name="data_dosen[${dsnIndex}][url_surat]" class="form-control form-control-sm" placeholder="URL Surat Tugas">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" style="padding: 4px 10px;">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        dsnIndex++;
    });

    // Delegate Remove Row
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-row')) {
            const row = e.target.closest('.row-mahasiswa') || e.target.closest('.row-dosen');
            if (row) {
                row.remove();
            }
        }
    });
});
</script>
@endsection
