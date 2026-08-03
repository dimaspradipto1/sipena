@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Prestasi Mandiri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar Prestasi Mandiri</li>
        </ol>
    </nav>
    <p class="text-muted small">Semua prestasi mandiri, peserta mahasiswa, dan dosen pendamping.</p>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <!-- SIMKATMAWA Soft Blue Info Banner -->
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2">Prestasi Mandiri</span>
                            <h5 class="fw-bold text-dark mb-1">Form terpadu untuk data prestasi dan peserta</h5>
                            <p class="text-secondary small mb-0">Gunakan tombol tambah atau edit untuk mengisi data lomba, mahasiswa, dan dosen dalam satu form.</p>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <input type="text" id="filter-search" class="form-control form-control-sm bg-white" placeholder="Cari lomba, penyelenggara..." style="max-width: 200px;">
                                <select id="filter-level" class="form-select form-select-sm bg-white" style="max-width: 140px;">
                                    <option value="">Semua Level</option>
                                    @foreach($levels as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="btn-apply-filter" class="btn btn-sm btn-light border shadow-sm">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
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
                            <h5 class="card-title fw-bold m-0 p-0 text-dark">Daftar Prestasi Mandiri</h5>
                            <small class="text-muted">Menampilkan data sesuai cakupan perguruan tinggi pengguna untuk kemudahan.</small>
                        </div>
                        <a href="{{ route('prestasi-mandiri.create') }}" class="btn btn-dark btn-sm px-3 rounded-2 shadow-sm" style="background-color: #0f172a; border-color: #0f172a;">
                            <i class="bi bi-plus-lg me-1"></i> + Tambah Data
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle w-100" id="prestasi-table">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th style="width: 90px;">ID</th>
                                    <th>Lomba/Kompetisi</th>
                                    <th>Cabang</th>
                                    <th>Prestasi</th>
                                    <th>Tahun</th>
                                    <th>PT</th>
                                    <th>Status</th>
                                    <th style="width: 100px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = $('#prestasi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('prestasi-mandiri.index') }}",
            data: function (d) {
                d.level = $('#filter-level').val();
                d.search_custom = $('#filter-search').val();
            }
        },
        columns: [
            { data: 'id_formatted', name: 'id' },
            { data: 'lomba_kompetisi', name: 'nama_kompetisi' },
            { data: 'nama_cabang', name: 'nama_cabang' },
            { data: 'peringkat', name: 'peringkat' },
            { data: 'tahun_display', name: 'tahun' },
            { data: 'pt', name: 'pt' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Belum ada data prestasi mandiri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });

    $('#btn-apply-filter').on('click', function () {
        table.draw();
    });

    $('#filter-search').on('keyup', function (e) {
        if (e.key === 'Enter') {
            table.draw();
        }
    });

    // Delete confirm
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data prestasi mandiri ini akan dihapus permanen!",
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
});
</script>
@endsection
