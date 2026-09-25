@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Prestasi Belmawa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Prestasi Belmawa</li>
            <li class="breadcrumb-item active">Daftar Prestasi Belmawa</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <div>
                        <h5 class="card-title m-0 p-0 text-dark fw-bold">Daftar Prestasi Belmawa</h5>
                        <small class="text-muted">Data kompetisi dan prestasi mahasiswa yang diselenggarakan oleh Direktorat Belmawa Kemendikbudristek.</small>
                    </div>
                    <a href="{{ route('prestasi-belmawa.create') }}" class="btn btn-primary btn-sm rounded-2">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Prestasi Belmawa
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table(['class' => 'table table-hover align-middle w-100']) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{ $dataTable->scripts() }}

    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let url = "{{ route('prestasi-belmawa.destroy', ':id') }}".replace(':id', id);

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Hapus data prestasi belmawa "' + name + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#prestasi-belmawa-table').DataTable().ajax.reload();
                            }
                        },
                        error: function(xhr) {
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
    </script>
@endpush
