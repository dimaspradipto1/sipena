@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Rekapitulasi & Pelaporan Data Prestasi</h1>
    <p class="text-muted small mb-0">Laporan terpadu dan rekapitulasi data capaian prestasi, rekognisi, serta sertifikasi Universitas Ibnu Sina.</p>
    <nav class="mt-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Rekapitulasi & Pelaporan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Filter Panel & Export Toolbar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="fw-bold text-dark m-0 d-flex align-items-center">
                <i class="bi bi-funnel-fill text-primary me-2"></i> Filter & Parameter Laporan
            </h6>
            <div class="d-flex gap-2 flex-wrap">
                <!-- Export Excel Button -->
                <a href="{{ route('rekapitulasi.excel', request()->query()) }}" target="_blank" class="btn btn-success fw-semibold btn-sm shadow-sm">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel (.xls)
                </a>

                <!-- Printable PDF Button -->
                <a href="{{ route('rekapitulasi.pdf', request()->query()) }}" target="_blank" class="btn btn-danger fw-semibold btn-sm shadow-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Cetak Laporan PDF
                </a>
            </div>
        </div>
        <div class="card-body p-4 pt-1">
            <form action="{{ route('rekapitulasi.index') }}" method="GET" class="row g-3 align-items-end">
                <!-- Filter Tahun -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label text-muted small fw-semibold mb-1">
                        <i class="bi bi-calendar-event me-1 text-primary"></i> Filter Tahun
                    </label>
                    <select name="tahun" class="form-select border-primary-subtle shadow-sm" style="font-size: 0.88rem;">
                        <option value="all" {{ $selectedTahun === 'all' ? 'selected' : '' }}>-- Semua Tahun --</option>
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ (string)$selectedTahun === (string)$y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Program Studi -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label text-muted small fw-semibold mb-1">
                        <i class="bi bi-building me-1 text-primary"></i> Program Studi
                    </label>
                    <select name="prodi" class="form-select border-primary-subtle shadow-sm" style="font-size: 0.88rem;">
                        <option value="all" {{ $selectedProdi === 'all' ? 'selected' : '' }}>-- Semua Program Studi --</option>
                        @foreach($defaultProdis as $p)
                            <option value="{{ $p }}" {{ $selectedProdi === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Jenis Prestasi -->
                <div class="col-md-2 col-sm-6">
                    <label class="form-label text-muted small fw-semibold mb-1">
                        <i class="bi bi-award me-1 text-primary"></i> Kategori
                    </label>
                    <select name="jenis" class="form-select border-primary-subtle shadow-sm" style="font-size: 0.88rem;">
                        <option value="all" {{ $selectedJenis === 'all' ? 'selected' : '' }}>-- Semua --</option>
                        <option value="Akademik" {{ strtolower($selectedJenis) === 'akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Non-Akademik" {{ strtolower($selectedJenis) === 'non-akademik' ? 'selected' : '' }}>Non-Akademik</option>
                    </select>
                </div>

                <!-- Filter Modul Sumber -->
                <div class="col-md-2 col-sm-6">
                    <label class="form-label text-muted small fw-semibold mb-1">
                        <i class="bi bi-journal-text me-1 text-primary"></i> Sumber Data
                    </label>
                    <select name="modul" class="form-select border-primary-subtle shadow-sm" style="font-size: 0.88rem;">
                        <option value="all" {{ $selectedModul === 'all' ? 'selected' : '' }}>-- Semual Modul --</option>
                        <option value="mandiri" {{ $selectedModul === 'mandiri' ? 'selected' : '' }}>Prestasi Mandiri</option>
                        <option value="belmawa" {{ $selectedModul === 'belmawa' ? 'selected' : '' }}>Prestasi Belmawa</option>
                        <option value="rekognisi" {{ $selectedModul === 'rekognisi' ? 'selected' : '' }}>Rekognisi</option>
                        <option value="sertifikasi" {{ $selectedModul === 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="col-md-2 col-sm-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-semibold w-100 shadow-sm">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    @if($selectedTahun !== 'all' || $selectedProdi !== 'all' || $selectedJenis !== 'all' || $selectedModul !== 'all')
                        <a href="{{ route('rekapitulasi.index') }}" class="btn btn-light border shadow-sm" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise text-secondary"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Matrix Table per Program Studi -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark m-0">
                <i class="bi bi-table text-primary me-2"></i> Matriks Rekapitulasi Capaian per Program Studi & Tingkat
            </h6>
            <span class="badge bg-primary px-3 py-1">Total: {{ number_format($totalRecords) }} Data Capaian</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle m-0 text-center" style="font-size: 0.88rem;">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="text-start ps-3" style="width: 250px;">Program Studi</th>
                            <th>Kabupaten / Kota</th>
                            <th>Provinsi</th>
                            <th>Nasional</th>
                            <th>Internasional</th>
                            <th class="bg-primary text-white" style="width: 120px;">Total Capaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sumKab = 0; $sumProv = 0; $sumNas = 0; $sumInter = 0; $sumTotal = 0;
                        @endphp
                        @foreach($matrix as $prodiName => $counts)
                            @php
                                $sumKab += $counts['Kabupaten/Kota'];
                                $sumProv += $counts['Provinsi'];
                                $sumNas += $counts['Nasional'];
                                $sumInter += $counts['Internasional'];
                                $sumTotal += $counts['total'];
                            @endphp
                            <tr class="{{ $counts['total'] > 0 ? '' : 'text-muted opacity-75' }}">
                                <td class="text-start ps-3 fw-semibold text-dark">{{ $prodiName }}</td>
                                <td>{{ $counts['Kabupaten/Kota'] > 0 ? $counts['Kabupaten/Kota'] : '-' }}</td>
                                <td>{{ $counts['Provinsi'] > 0 ? $counts['Provinsi'] : '-' }}</td>
                                <td>{{ $counts['Nasional'] > 0 ? $counts['Nasional'] : '-' }}</td>
                                <td>{{ $counts['Internasional'] > 0 ? $counts['Internasional'] : '-' }}</td>
                                <td class="fw-bold text-primary bg-primary-subtle">{{ number_format($counts['total']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light fw-bold">
                        <tr>
                            <td class="text-start ps-3">TOTAL KESELURUHAN</td>
                            <td>{{ number_format($sumKab) }}</td>
                            <td>{{ number_format($sumProv) }}</td>
                            <td>{{ number_format($sumNas) }}</td>
                            <td>{{ number_format($sumInter) }}</td>
                            <td class="bg-primary text-white fs-6">{{ number_format($sumTotal) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Detailed Records Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark m-0">
                <i class="bi bi-list-stars text-warning me-2"></i> Rincian Data Capaian Prestasi
            </h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0" id="rekapTable" style="font-size: 0.85rem;">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="text-center" style="width: 40px;">#</th>
                            <th>Mahasiswa / NIM</th>
                            <th>Program Studi</th>
                            <th>Judul Kegiatan / Prestasi</th>
                            <th>Modul</th>
                            <th class="text-center">Tingkat</th>
                            <th>Capaian / Peringkat</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filteredRecords as $index => $row)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $row['mahasiswa'] }}</div>
                                    <small class="text-muted">{{ $row['nim'] }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $row['prodi'] }}</span></td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $row['judul_kegiatan'] }}</div>
                                    <small class="text-muted">{{ $row['kategori'] }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                        {{ $row['modul'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-white">{{ $row['level'] }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1">{{ $row['capaian'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $row['jenis'] === 'Akademik' ? 'bg-primary' : 'bg-success' }} px-2 py-1">
                                        {{ $row['jenis'] }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold">{{ $row['tahun'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Tidak ada data rekapitulasi yang cocok dengan filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#rekapTable').DataTable({
        pageLength: 10,
        language: {
            search: "Cari Data:",
            lengthMenu: "Tampilkan _MENU_ baris",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "►",
                previous: "◄"
            }
        }
    });
});
</script>
@endpush
