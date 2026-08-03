@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Institusi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Tata Kelola</li>
            <li class="breadcrumb-item active">Institusi</li>
        </ol>
    </nav>
    <p class="text-muted small">Pengaturan data institusi, pimpinan, dan dokumen Pendukung SIMKATMAWA.</p>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <!-- SIMKATMAWA Soft Blue Info Banner & Progress Card -->
        <div class="col-lg-8 col-12 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2 align-self-start">Institusi</span>
                    <h5 class="fw-bold text-dark mb-1">Pengaturan Institusi Perguruan Tinggi</h5>
                    <p class="text-secondary small mb-0">Lengkapi 70 indikator penilaian profil perguruan tinggi, pimpinan, bidang kemahasiswaan, dan dokumen pendukung SIMKATMAWA.</p>
                </div>
            </div>
        </div>

        <!-- SIMKATMAWA Progress Widget Card (70 Indikator) -->
        <div class="col-lg-4 col-12 mb-3">
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

        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="card-title fw-bold m-0 p-0 text-dark">Daftar Institusi Perguruan Tinggi</h5>
                            <small class="text-muted">Menampilkan daftar data institusi perguruan tinggi yang terdaftar.</small>
                        </div>
                        <a href="{{ route('institusi.create') }}" class="btn btn-dark btn-sm px-3 rounded-2 shadow-sm" style="background-color: #0f172a; border-color: #0f172a;">
                            <i class="bi bi-plus-lg me-1"></i> + Tambah Institusi
                        </a>
                    </div>

                    <div class="table-responsive">
                       {{ $dataTable->table([
                                'class' => 'table table-hover align-middle w-100',
                                'style' => 'width:100%; overflow-x: auto',
                            ]) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
    <script>
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data institusi ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
