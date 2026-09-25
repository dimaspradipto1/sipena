@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Template LPJ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Template LPJ</li>
        </ol>
    </nav>
    <p class="text-muted small">Kelola dokumen dan tautan template Laporan Pertanggungjawaban (LPJ) kegiatan dan prestasi mahasiswa.</p>
</div><!-- End Page Title -->

<section class="section">
    <!-- Header Soft Blue Info Banner -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2">
                        Dokumen LPJ
                    </span>
                    <h5 class="fw-bold text-dark mb-1">Manajemen Template LPJ Prestasi & Kegiatan</h5>
                    <p class="text-secondary small mb-0">Atur tautan kustom (Google Drive / OneDrive) atau unggah file dokumen resmi (.docx / .pdf). Template yang ditandai <strong>Aktif</strong> akan otomatis digunakan saat mahasiswa mengunduh template.</p>
                </div>
                @if(in_array(auth()->user()->role, ['superadmin', 'adminbkak']))
                <div class="flex-shrink-0">
                    <a href="{{ route('template-lpj.create') }}" class="btn btn-dark px-3 py-2 rounded-2 shadow-sm d-inline-flex align-items-center" style="background-color: #0f172a; border-color: #0f172a;">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Template
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="card-title fw-bold m-0 p-0 text-dark">Daftar Template LPJ</h5>
                            <small class="text-muted">Daftar berkas dan tautan kustom template yang tersedia untuk mahasiswa dan dosen pendamping.</small>
                        </div>
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
                text: "Template LPJ ini akan dihapus secara permanen!",
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
