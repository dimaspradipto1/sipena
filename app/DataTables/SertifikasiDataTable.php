<?php

namespace App\DataTables;

use App\Models\Sertifikasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SertifikasiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Sertifikasi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('id_formatted', function ($item) {
                return '<span class="fw-bold text-dark">#' . str_pad($item->id, 6, '0', STR_PAD_LEFT) . '</span>';
            })
            ->editColumn('nama_sertifikasi', function ($item) {
                return '<span class="fw-bold text-primary">' . e($item->nama_sertifikasi) . '</span>';
            })
            ->editColumn('nama_penyelenggara', function ($item) {
                return '<span class="text-dark">' . e($item->nama_penyelenggara) . '</span>';
            })
            ->editColumn('level', function ($item) {
                return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">' . e($item->level) . '</span>';
            })
            ->addColumn('tahun_display', function ($item) {
                return $item->tahun ?? ($item->created_at ? $item->created_at->format('Y') : date('Y'));
            })
            ->editColumn('pt', function ($item) {
                return '<span class="small text-secondary">' . e($item->pt ?? 'Universitas Ibnu Sina') . '</span>';
            })
            ->editColumn('status', function ($item) {
                return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">' . e($item->status ?? 'Terverifikasi') . '</span>';
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('sertifikasi.edit', $item->id);
                $showUrl = route('sertifikasi.show', $item->id);
                $deleteUrl = route('sertifikasi.destroy', $item->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="btn-group" role="group">
                        <a href="' . $showUrl . '" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline delete-form">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>';
            })
            ->rawColumns(['id_formatted', 'nama_sertifikasi', 'nama_penyelenggara', 'level', 'pt', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Sertifikasi>
     */
    public function query(Sertifikasi $model): QueryBuilder
    {
        $query = $model->newQuery();
        $user = auth()->user();
        if ($user && $user->role === 'mahasiswa') {
            $query->where('data_mahasiswa', 'LIKE', '%' . $user->name . '%');
        }
        return $query->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sertifikasi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->parameters([
                        'scrollX' => true,
                        'language' => [
                            'search' => 'Cari:',
                            'lengthMenu' => 'Tampilkan _MENU_ data',
                            'zeroRecords' => 'Belum ada data sertifikasi yang cocok.',
                            'info' => 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                            'infoEmpty' => 'Tidak ada data tersedia',
                            'paginate' => [
                                'first' => 'Awal',
                                'last' => 'Akhir',
                                'next' => 'Selanjutnya',
                                'previous' => 'Sebelumnya'
                            ]
                        ]
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false)->width(40),
            Column::make('id_formatted')->title('ID')->name('id'),
            Column::make('nama_sertifikasi')->title('Nama Sertifikasi')->name('nama_sertifikasi'),
            Column::make('nama_penyelenggara')->title('Penyelenggara')->name('nama_penyelenggara'),
            Column::make('level')->title('Level')->name('level'),
            Column::make('tahun_display')->title('Tahun')->name('tahun'),
            Column::make('pt')->title('PT')->name('pt'),
            Column::make('status')->title('Status')->name('status'),
            Column::computed('action')
                  ->title('Aksi')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Sertifikasi_' . date('YmdHis');
    }
}
