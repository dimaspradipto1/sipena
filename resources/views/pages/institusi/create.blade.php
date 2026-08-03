@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Institusi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('institusi.index') }}">Institusi</a></li>
            <li class="breadcrumb-item active">Form Checklist Institusi</li>
        </ol>
    </nav>
    <p class="text-muted small">Lengkapi profil perguruan tinggi dan Indikator Penilaian SIMKATMAWA.</p>
</div><!-- End Page Title -->

<section class="section">
    <!-- Header Top Row: Tahun Pelaporan & Info Petunjuk -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-3">
                    <label for="tahun_pelaporan" class="form-label fw-bold small text-dark mb-1">Tahun Pelaporan <span class="text-danger">*</span></label>
                    <select id="tahun_pelaporan" name="tahun_pelaporan" class="form-select bg-white">
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <div class="p-3 rounded-3 border-0" style="background-color: #eff6ff; color: #1e40af;">
                        <small style="font-size: 0.825rem; line-height: 1.4;">
                            <strong>Petunjuk:</strong> centang indikator yang tersedia di PT Anda, lalu isi URL dokumen pendukung pada baris yang sama. Khusus butir 2.b, isi jumlah mahasiswa dan tautan buktinya. Khusus 0.1, pilih level kelembagaan melalui radio button lalu lampirkan dua dokumen pendukungnya.
                        </small>
                    </div>
                </div>
            </div>
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

    <form action="{{ route('institusi.store') }}" method="POST">
        @csrf

        <!-- Profil Perguruan Tinggi (Basic Info) -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="p-2 rounded-circle bg-primary-subtle text-primary me-3">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Identitas Perguruan Tinggi</h5>
                        <small class="text-muted">Informasi umum perguruan tinggi penanggung jawab pelaporan SIMKATMAWA.</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="kode_pt" class="form-label fw-medium">Kode Perguruan Tinggi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_pt') is-invalid @enderror" id="kode_pt" name="kode_pt" value="{{ old('kode_pt', '101015') }}" required placeholder="Contoh: 101015">
                    </div>
                    <div class="col-md-6">
                        <label for="nama_pt" class="form-label fw-medium">Nama Perguruan Tinggi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pt') is-invalid @enderror" id="nama_pt" name="nama_pt" value="{{ old('nama_pt', 'Universitas Ibnu Sina') }}" required placeholder="Nama Perguruan Tinggi">
                    </div>
                    <div class="col-md-6">
                        <label for="bentuk_pt" class="form-label fw-medium">Bentuk Perguruan Tinggi</label>
                        <select class="form-select" id="bentuk_pt" name="bentuk_pt">
                            @foreach($options['bentuks'] as $key => $label)
                                <option value="{{ $key }}" {{ old('bentuk_pt') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status_institusi" class="form-label fw-medium">Status Institusi</label>
                        <select class="form-select" id="status_institusi" name="status_institusi">
                            @foreach($options['statuses'] as $key => $label)
                                <option value="{{ $key }}" {{ old('status_institusi') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION A: KELEMBAGAAN KEMAHASISWAAN -->
        <div class="text-uppercase text-secondary fw-bold mb-3 small" style="letter-spacing: 0.5px;">
            A. KELEMBAGAAN KEMAHASISWAAN
        </div>

        <!-- Sub-section 1: Regulasi Pembinaan Bidang Kemahasiswaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">1. Regulasi Pembinaan Bidang Kemahasiswaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $regulasi = [
                                    1 => 'Kode etik, hak, dan kewajiban mahasiswa.',
                                    2 => 'Kode etik, hak, dan kewajiban Organisasi Kemahasiswaan (ORMAWA)/Unit Kegiatan Mahasiswa (UKM).',
                                    3 => 'Prosedur Operasional Baku (POB) layanan kegiatan kemahasiswaan.',
                                    4 => 'Panduan/peraturan tata kelola pembinaan organisasi/kegiatan kemahasiswaan.',
                                    5 => 'Surat keputusan pengangkatan pembina kemahasiswaan.',
                                    6 => 'Lembaga/unit/tim penegakan norma kemahasiswaan.',
                                    7 => 'Kebijakan kampus sehat dan/atau green campus.',
                                    8 => 'Kebijakan penggunaan media sosial.',
                                    9 => 'Regulasi/kebijakan pelampauan standar Sistem Penjaminan Mutu Internal (SPMI) pada bidang kemahasiswaan.',
                                    10 => 'Regulasi/kebijakan dan POB penyelenggaraan kegiatan kompetisi/lomba oleh ORMAWA/UKM.',
                                    11 => 'Regulasi/kebijakan dan POB layanan kemahasiswaan inklusif bagi mahasiswa berkebutuhan khusus (MBK).',
                                ];
                            @endphp
                            @foreach($regulasi as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_regulasi[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_regulasi[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 2.a: Beasiswa/Bantuan Biaya Pendidikan - Pengelolaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">2.a. Beasiswa/Bantuan Biaya Pendidikan - Pengelolaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $beasiswa_a = [
                                    1 => 'SK pengelola/unit pengelola beasiswa/SK penyaluran/distribusi beasiswa.',
                                    2 => 'Dokumen kerja sama (MoU/MoA/IA) dengan mitra pemberi beasiswa.',
                                    3 => 'POB pengajuan, pengelolaan, dan pencairan beasiswa.',
                                    4 => 'Laporan pengelolaan, penyaluran, dan distribusi beasiswa.',
                                    5 => 'Laporan pembinaan dan pengembangan kompetensi mahasiswa penerima beasiswa.',
                                    6 => 'Penggunaan sistem informasi untuk pengelolaan, penyaluran, dan distribusi beasiswa.',
                                ];
                            @endphp
                            @foreach($beasiswa_a as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_beasiswa_a[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_beasiswa_a[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 2.b: Jumlah Mahasiswa Penerima Beasiswa NonAPBN -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">2.b. Jumlah Mahasiswa Penerima Beasiswa NonAPBN</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 180px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-medium text-secondary">1</td>
                                <td class="text-dark">Jumlah mahasiswa penerima beasiswa dana NonAPBN</td>
                                <td class="text-center px-3">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">JUMLAH MAHASISWA</small>
                                    <input type="number" class="form-control form-control-sm text-center" name="mhs_nonapbn" value="0" min="0">
                                </td>
                                <td class="pe-4">
                                    <input type="url" class="form-control form-control-sm bg-light" name="link_nonapbn" placeholder="https://...">
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-medium text-secondary">2</td>
                                <td class="text-dark">Jumlah mahasiswa aktif sarjana (S1) dan diploma (D4/D3/D2/D1).</td>
                                <td class="text-center px-3">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">JUMLAH MAHASISWA AKTIF</small>
                                    <input type="number" class="form-control form-control-sm text-center" name="mhs_aktif" value="0" min="0">
                                </td>
                                <td class="pe-4">
                                    <input type="url" class="form-control form-control-sm bg-light" name="link_mhs_aktif" placeholder="https://...">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 3: Layanan Kesehatan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">3. Layanan Kesehatan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $kesehatan = [
                                    1 => 'Surat keputusan unit pengelola layanan kesehatan mahasiswa.',
                                    2 => 'POB layanan kesehatan mahasiswa.',
                                    3 => 'Ruang khusus layanan atau klinik kesehatan mahasiswa.',
                                    4 => 'Surat keputusan dokter piket/jaga pada klinik kesehatan mahasiswa.',
                                    5 => 'Unit transportasi (ambulance) milik perguruan tinggi dan/atau kerja sama pengelolaan.',
                                    6 => 'Laporan layanan kesehatan mahasiswa.',
                                ];
                            @endphp
                            @foreach($kesehatan as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_kesehatan[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_kesehatan[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 4: Konseling Mahasiswa -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">4. Konseling Mahasiswa</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $konseling = [
                                    1 => 'Gedung/ruangan khusus layanan konseling mahasiswa.',
                                    2 => 'Panduan dan/atau POB konseling mahasiswa.',
                                    3 => 'Surat keputusan pengelola unit konseling mahasiswa.',
                                    4 => 'Kualifikasi dan ketersediaan SDM sebagai konselor.',
                                    5 => 'Sistem informasi untuk layanan konseling secara daring.',
                                    6 => 'Laporan layanan konseling mahasiswa.',
                                ];
                            @endphp
                            @foreach($konseling as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_konseling[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_konseling[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 5: Pencegahan dan Penanganan Kekerasan di Lingkungan Perguruan Tinggi -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">5. Pencegahan dan Penanganan Kekerasan di Lingkungan Perguruan Tinggi</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $kekerasan = [
                                    1 => 'Gedung/ruangan khusus pengelola pencegahan dan penanganan kekerasan di lingkungan perguruan tinggi.',
                                    2 => 'Surat keputusan unit pengelola pencegahan dan penanganan kekerasan di lingkungan perguruan tinggi.',
                                    3 => 'Panduan dan/atau POB pencegahan dan penanganan kekerasan di lingkungan perguruan tinggi.',
                                    4 => 'Program terstruktur tentang pencegahan dan penanganan kekerasan di lingkungan perguruan tinggi.',
                                    5 => 'Laporan pelaksanaan pencegahan dan penanganan kekerasan di lingkungan perguruan tinggi.',
                                ];
                            @endphp
                            @foreach($kekerasan as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_kekerasan[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_kekerasan[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 6: Pencegahan dan Penanganan Anti Intoleransi, Anti Perundungan, atau Anti Korupsi -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">6. Pencegahan dan Penanganan Anti Intoleransi, Anti Perundungan, atau Anti Korupsi</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $anti_intoleransi = [
                                    1 => 'Surat keputusan pengelola/program/struktur/laporan pembinaan anti intoleransi.',
                                    2 => 'Surat keputusan pengelola/program/struktur/laporan pembinaan anti perundungan.',
                                    3 => 'Surat keputusan pengelola/program/struktur/laporan pembinaan anti korupsi mahasiswa.',
                                ];
                            @endphp
                            @foreach($anti_intoleransi as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_anti_intoleransi[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_anti_intoleransi[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 7: Pembinaan Kewirausahaan Mahasiswa -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">7. Pembinaan Kewirausahaan Mahasiswa</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $wirausaha = [
                                    1 => 'Surat keputusan unit pengelola kewirausahaan mahasiswa.',
                                    2 => 'Program terstruktur pengembangan kewirausahaan mahasiswa.',
                                    3 => 'Penyelenggaraan seminar dan/atau kuliah umum kewirausahaan.',
                                    4 => 'Penyelenggaraan pendidikan dan pelatihan/diklat kewirausahaan.',
                                    5 => 'Dokumen kerja sama magang kewirausahaan.',
                                    6 => 'Sarana inkubasi bisnis atau sarana display/galeri/etalase produk (offline/online) kewirausahaan mahasiswa.',
                                ];
                            @endphp
                            @foreach($wirausaha as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_wirausaha[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_wirausaha[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section 8: Pembinaan Karakter, Bela Negara, atau Wawasan Kebangsaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">8. Pembinaan Karakter, Bela Negara, atau Wawasan Kebangsaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $karakter = [
                                    1 => 'Surat keputusan pengelola/program/struktur/laporan kegiatan pembinaan karakter.',
                                    2 => 'Surat keputusan pengelola/program/struktur/laporan kegiatan pembinaan bela negara.',
                                    3 => 'Surat keputusan pengelola/program/struktur/laporan kegiatan pembinaan nasionalisme dan wawasan kebangsaan.',
                                ];
                            @endphp
                            @foreach($karakter as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_karakter[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_karakter[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- SECTION B: SUMBER DAYA MANUSIA -->
        <div class="text-uppercase text-secondary fw-bold mb-3 small" style="letter-spacing: 0.5px;">
            B. SUMBER DAYA MANUSIA
        </div>

        <!-- Sub-section B.1: Level Kelembagaan Bidang Kemahasiswaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">1. Level Kelembagaan Bidang Kemahasiswaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-4">
                <label class="form-label fw-bold text-dark small mb-2">Level Kelembagaan Bidang Kemahasiswaan</label>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-white h-100">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="level_kelembagaan" id="level1" value="Level 1">
                                <label class="form-check-label fw-bold text-dark" for="level1">
                                    Level 1
                                    <span class="d-block text-muted small fw-normal">Setingkat Kepala Seksi/Koordinator</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-white h-100">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="level_kelembagaan" id="level2" value="Level 2">
                                <label class="form-check-label fw-bold text-dark" for="level2">
                                    Level 2
                                    <span class="d-block text-muted small fw-normal">Setingkat Wakil Direktur/Kepala Sub Direktorat/Kepala Bagian</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 bg-white h-100">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="level_kelembagaan" id="level3" value="Level 3" checked>
                                <label class="form-check-label fw-bold text-dark" for="level3">
                                    Level 3
                                    <span class="d-block text-muted small fw-normal">Setingkat Wakil Rektor/Direktur</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-3">No</th>
                                <th>Indikator</th>
                                <th style="width: 160px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium text-secondary">1</td>
                                <td class="text-dark">Surat keputusan pengangkatan pimpinan/pengelola yang khusus mengelola bidang kemahasiswaan.</td>
                                <td class="text-center">
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 fw-normal">Dokumen Pendukung</span>
                                </td>
                                <td class="pe-3">
                                    <input type="url" class="form-control form-control-sm bg-light" name="link_sk_pengangkat_pimpinan" placeholder="https://...">
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium text-secondary">2</td>
                                <td class="text-dark">Struktur organisasi pengelola bidang kemahasiswaan di perguruan tinggi.</td>
                                <td class="text-center">
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 fw-normal">Dokumen Pendukung</span>
                                </td>
                                <td class="pe-3">
                                    <input type="url" class="form-control form-control-sm bg-light" name="link_struktur_pengelola_kemahasiswaan" placeholder="https://...">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Sub-section B.2: Tugas Pokok dan Fungsi Bidang Kemahasiswaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">2. Tugas Pokok dan Fungsi Bidang Kemahasiswaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tupoksi = [
                                    1 => 'Pengembangan penalaran dan kreativitas.',
                                    2 => 'Kesejahteraan dan kewirausahaan.',
                                    3 => 'Minat, bakat, dan organisasi kemahasiswaan.',
                                    4 => 'Penyelarasan dan pengembangan karir.',
                                    5 => 'Pengembangan mental spiritual kebangsaan.',
                                    6 => 'Internasionalisasi.',
                                ];
                            @endphp
                            @foreach($tupoksi as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_tupoksi[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_tupoksi[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- SECTION C: PRASARANA DAN SARANA -->
        <div class="text-uppercase text-secondary fw-bold mb-3 small" style="letter-spacing: 0.5px;">
            C. PRASARANA DAN SARANA
        </div>

        <!-- Sub-section C.1: Prasarana dan Sarana Kegiatan Kemahasiswaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">Prasarana dan Sarana Kegiatan Kemahasiswaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sarpras = [
                                    1 => 'Gedung/ruang sekretariat untuk setiap ORMAWA/UKM.',
                                    2 => 'Portal/laman website bidang kemahasiswaan yang terintegrasi dengan portal utama perguruan tinggi.',
                                    3 => 'Prasarana/sarana kegiatan atau latihan mahasiswa untuk pengembangan minat, bakat, penalaran, kreativitas, dan kewirausahaan.',
                                    4 => 'Prasarana/sarana kegiatan pengembangan kerohanian mahasiswa.',
                                    5 => 'Peraturan/ketentuan/tata kelola penggunaan prasarana dan sarana bagi ORMAWA/UKM.',
                                    6 => 'Sistem informasi untuk pelaporan capaian kinerja/prestasi mahasiswa/ORMAWA/UKM.',
                                    7 => 'Fasilitas aksesibel dan tata kelola penggunaan prasarana/sarana untuk mahasiswa berkebutuhan khusus.',
                                ];
                            @endphp
                            @foreach($sarpras as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_sarpras[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_sarpras[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- SECTION D: PEMBIAYAAN -->
        <div class="text-uppercase text-secondary fw-bold mb-3 small" style="letter-spacing: 0.5px;">
            D. PEMBIAYAAN
        </div>

        <!-- Sub-section D.1: Pembiayaan Kemahasiswaan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">Pembiayaan Kemahasiswaan</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 220px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-medium text-secondary">1</td>
                                <td class="text-dark">Jumlah total anggaran perguruan tinggi.</td>
                                <td class="text-center px-3">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.65rem; letter-spacing: 0.3px;">JUMLAH TOTAL ANGGARAN PT</small>
                                    <input type="number" class="form-control form-control-sm text-center" name="total_anggaran_pt" value="0" min="0" step="1000">
                                </td>
                                <td class="pe-4">
                                    <input type="url" class="form-control form-control-sm bg-light" name="link_anggaran_pt" placeholder="https://...">
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-medium text-secondary">2</td>
                                <td class="text-dark">Jumlah total anggaran kemahasiswaan perguruan tinggi.</td>
                                <td class="text-center px-3">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.65rem; letter-spacing: 0.3px;">JUMLAH TOTAL ANGGARAN KEMAHASISWAAN PT</small>
                                    <input type="number" class="form-control form-control-sm text-center" name="total_anggaran_kemahasiswaan" value="0" min="0" step="1000">
                                </td>
                                <td class="pe-4">
                                    <input type="url" class="form-control form-control-sm bg-light" name="link_anggaran_kemahasiswaan" placeholder="https://...">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- SECTION E: REGULASI PENGHARGAAN CAPAIAN PRESTASI MAHASISWA -->
        <div class="text-uppercase text-secondary fw-bold mb-3 small" style="letter-spacing: 0.5px;">
            E. REGULASI PENGHARGAAN CAPAIAN PRESTASI MAHASISWA
        </div>

        <!-- Sub-section E.1: Regulasi Penghargaan Capaian Prestasi Mahasiswa -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-3 d-flex justify-content-between align-items-center border-bottom-0">
                <h6 class="fw-bold text-dark m-0">Regulasi Penghargaan Capaian Prestasi Mahasiswa</h6>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-capitalize" style="font-size: 0.75rem;">Checklist Section</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" style="font-size: 0.875rem;">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th>Indikator</th>
                                <th style="width: 100px;" class="text-center">Isian</th>
                                <th style="width: 45%;">Link Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $penghargaan = [
                                    1 => 'Peraturan dan/atau buku panduan yang mengatur pemberian penghargaan terhadap prestasi mahasiswa.',
                                    2 => 'Surat keputusan pemberian penghargaan prestasi mahasiswa sebagai implementasi peraturan pimpinan.',
                                    3 => 'Peraturan dan/atau buku panduan pengakuan dan penyetaraan prestasi/capaian mahasiswa dengan kredit (SKS) dan nilai akademik.',
                                    4 => 'Peraturan dan/atau buku panduan pelaksanaan Surat Keterangan Pendamping Ijazah.',
                                    5 => 'Peraturan dan/atau buku panduan penghargaan bagi mahasiswa atas capaian ekstrakurikuler mahasiswa.',
                                    6 => 'Sistem informasi untuk pendataan dan pengelolaan capaian prestasi mahasiswa.',
                                ];
                            @endphp
                            @foreach($penghargaan as $num => $title)
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">{{ $num }}</td>
                                    <td class="text-dark">{{ $title }}</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" name="indikator_penghargaan[{{ $num }}]" value="1" style="width: 1.3rem; height: 1.3rem;">
                                    </td>
                                    <td class="pe-4">
                                        <input type="url" class="form-control form-control-sm bg-light" name="link_penghargaan[{{ $num }}]" placeholder="https://...">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end border-top-0">
                <button type="submit" class="btn btn-sm btn-outline-secondary px-4">Simpan Draft</button>
            </div>
        </div>

        <!-- Action Footer -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <a href="{{ route('institusi.index') }}" class="btn btn-light border px-4 shadow-sm">
                Kembali
            </a>
            <button type="submit" class="btn btn-dark px-4 shadow-sm" style="background-color: #0f172a; border-color: #0f172a;">
                Simpan Laporan
            </button>
        </div>
    </form>
</section>
@endsection
