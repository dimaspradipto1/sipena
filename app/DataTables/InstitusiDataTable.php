<?php

namespace App\DataTables;

use App\Models\Institusi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InstitusiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Institusi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('id_formatted', function ($item) {
                return '<span class="fw-bold text-dark">#' . str_pad($item->id, 6, '0', STR_PAD_LEFT) . '</span>';
            })
            ->editColumn('kode_pt', function ($item) {
                return '<span class="badge bg-secondary-subtle text-secondary px-2 py-1">' . e($item->kode_pt) . '</span>';
            })
            ->editColumn('nama_pt', function ($item) {
                return '<span class="fw-bold text-primary">' . e($item->nama_pt) . '</span>';
            })
            ->editColumn('bentuk_pt', function ($item) {
                return '<span class="text-dark">' . e($item->bentuk_pt) . '</span>';
            })
            ->editColumn('status_institusi', function ($item) {
                return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">' . e($item->status_institusi) . '</span>';
            })
            ->addColumn('lokasi_display', function ($item) {
                return e(($item->kota ? $item->kota . ', ' : '') . ($item->provinsi ?? '-'));
            })
            ->editColumn('status', function ($item) {
                return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">' . e($item->status ?? 'Aktif') . '</span>';
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('institusi.edit', $item->id);
                $showUrl = route('institusi.show', $item->id);
                $deleteUrl = route('institusi.destroy', $item->id);
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
            ->rawColumns(['id_formatted', 'kode_pt', 'nama_pt', 'bentuk_pt', 'status_institusi', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Institusi>
     */
    public function query(Institusi $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('institusi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->parameters([
                        'scrollX' => true,
                        'language' => [
                            'search' => 'Cari:',
                            'lengthMenu' => 'Tampilkan _MENU_ data',
                            'zeroRecords' => 'Belum ada data institusi',
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
            Column::make('kode_pt')->title('Kode PT')->name('kode_pt'),
            Column::make('nama_pt')->title('Nama Perguruan Tinggi')->name('nama_pt'),
            Column::make('bentuk_pt')->title('Bentuk')->name('bentuk_pt'),
            Column::make('status_institusi')->title('Status Institusi')->name('status_institusi'),
            Column::make('lokasi_display')->title('Kota/Provinsi')->name('kota'),
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
        return 'Institusi_' . date('YmdHis');
    }
}
