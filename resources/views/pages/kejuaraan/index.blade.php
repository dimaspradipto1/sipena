@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kejuaraan</h1>
    <p class="text-muted small mb-0">Pelaporan penyelenggaraan ajang dan hasil kejuaraan perguruan tinggi.</p>
    <nav class="mt-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar Kejuaraan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <!-- Header Top Row Banner Widget (SIMKATMAWA Style) -->
    <div class="card border-0 shadow-sm mb-4" style="background-color: #eff6ff;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2 fw-medium" style="font-size: 0.75rem;">Kejuaraan</span>
                    <h5 class="fw-bold text-dark mb-1">Penyelenggaraan Ajang dan Hasil Juara</h5>
                    <p class="text-muted small mb-0">PT melaporkan ajang biasa maupun terverifikasi beserta hasil peserta dan dosen pendampingnya.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" id="customSearchInput" class="form-control bg-white form-control-sm" placeholder="Cari ajang, level, tempat, atau PT" style="min-width: 250px;">
                    <select id="tahunFilter" class="form-select form-select-sm bg-white" style="width: 140px;">
                        <option value="">Semua Tahun</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                    <button type="button" id="btnFilterSearch" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                        <h5 class="card-title m-0 p-0 text-dark fw-bold">Daftar Kejuaraan</h5>
                    </div>
                    <a href="{{ route('kejuaraan.create') }}" class="btn btn-dark btn-sm rounded-2 px-3" style="background-color: #0f172a; border-color: #0f172a;">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Data
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
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            // Custom Search & Filter integration
            $('#customSearchInput').on('keyup', function() {
                $('#kejuaraan-table').DataTable().search(this.value).draw();
            });

            $('#tahunFilter').on('change', function() {
                $('#kejuaraan-table').DataTable().search(this.value).draw();
            });

            $('#btnFilterSearch').on('click', function() {
                let query = $('#customSearchInput').val();
                $('#kejuaraan-table').DataTable().search(query).draw();
            });
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let url = "{{ route('kejuaraan.destroy', ':id') }}".replace(':id', id);

            if (confirm('Apakah Anda yakin ingin menghapus data kejuaraan "' + name + '"?')) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#kejuaraan-table').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        });
    </script>
@endpush
