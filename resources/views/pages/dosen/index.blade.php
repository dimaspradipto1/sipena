@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Data Dosen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Tata Kelola</li>
            <li class="breadcrumb-item active">Data Dosen</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Header Banner -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2">
                    Master Data SIMKATMAWA
                </span>
                <h5 class="fw-bold text-dark mb-1">Manajemen Data Dosen Pendamping</h5>
                <p class="text-secondary small mb-0">Kelola data dosen, NIDN/NUPTK, program studi, email, serta nomor kontak WhatsApp.</p>
            </div>
            <div class="d-flex gap-2">
                <!-- Modal Import Trigger Button -->
                <button type="button" class="btn btn-success fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-excel me-1"></i> Import Data Dosen
                </button>

                <!-- Tambah Data Dosen Button -->
                <a href="{{ route('dosen.create') }}" class="btn btn-primary fw-semibold shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Dosen
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat Kesalahan:</h6>
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark m-0">
                <i class="bi bi-person-badge text-primary me-2"></i> Daftar Dosen Universitas Ibnu Sina
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle']) }}
            </div>
        </div>
    </div>
</section>

<!-- Modal Import Data Dosen -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="importModalLabel">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i> Import Data Dosen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dosen.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis p-3 mb-3 small">
                        <i class="bi bi-info-circle-fill me-1 fs-6"></i>
                        Gunakan file berformat <strong>.XLS</strong> atau <strong>.XLSX / .CSV</strong>. Unduh template Excel di bawah jika Anda belum memiliki formatnya.
                    </div>

                    <!-- Download Template Link -->
                    <div class="mb-4 text-center">
                        <a href="{{ route('dosen.template') }}" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm">
                            <i class="bi bi-download me-1"></i> Download Template Excel (.XLS)
                        </a>
                    </div>

                    <!-- Input Upload File -->
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Pilih File Import <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="file" name="file" accept=".csv, .txt, .xls, .xlsx" required>
                        <div class="form-text small">Maksimal ukuran file: 5 MB.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-upload me-1"></i> Proses Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete AJAX Confirmation with SweetAlert2
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Hapus Data Dosen?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: form.serialize(),
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    $('#dosen-table').DataTable().ajax.reload();
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
