@extends('layouts.dashboard.template')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('users.create') }}" class="btn btn-primary rounded btn-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                <li><i class="fa fa-window-maximize full-card"></i></li>
                <li><i class="fa fa-minus minimize-card"></i></li>
                <li><i class="fa fa-refresh reload-card"></i></li>
                <li><i class="fa fa-trash close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
           {{ $dataTable->table([
                    'class' => 'table table-striped table-bordered',
                    'style' => 'width:100%; overflow-x: auto',
                ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
                text: "Pengguna ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
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
