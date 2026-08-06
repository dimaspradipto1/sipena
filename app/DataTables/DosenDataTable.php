<?php

namespace App\DataTables;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DosenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Dosen> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('nidn_nuptk', function (Dosen $model) {
                return '<span class="badge bg-light text-dark border font-monospace px-2 py-1">' . e($model->nidn_nuptk ?? '-') . '</span>';
            })
            ->editColumn('nama_dosen', function (Dosen $model) {
                $html = '<div class="fw-bold text-dark">' . e($model->nama_dosen) . '</div>';
                if ($model->email) {
                    $html .= '<small class="text-muted"><i class="bi bi-envelope me-1"></i>' . e($model->email) . '</small>';
                }
                return $html;
            })
            ->editColumn('program_studi', function (Dosen $model) {
                return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"><i class="bi bi-bookmark-check me-1"></i>' . e($model->program_studi ?? 'Teknik Informatika') . '</span>';
            })
            ->editColumn('no_hp', function (Dosen $model) {
                return '<span class="small text-secondary"><i class="bi bi-telephone me-1"></i>' . e($model->no_hp ?? '-') . '</span>';
            })
            ->editColumn('status', function (Dosen $model) {
                $badgeClass = $model->status === 'Aktif' ? 'bg-success text-white' : 'bg-secondary text-white';
                return '<span class="badge ' . $badgeClass . ' px-2 py-1">' . e($model->status) . '</span>';
            })
            ->addColumn('action', function (Dosen $model) {
                $editUrl = route('dosen.edit', $model->id);
                $deleteUrl = route('dosen.destroy', $model->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <div class="btn-group" role="group">
                        <a href="' . $editUrl . '" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline delete-form">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>';
            })
            ->rawColumns(['nidn_nuptk', 'nama_dosen', 'program_studi', 'no_hp', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Dosen>
     */
    public function query(Dosen $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dosen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'language' => [
                            'url' => 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                        ],
                        'dom' => "<'row mb-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-end'f>>" .
                                 "<'row'<'col-sm-12'tr>>" .
                                 "<'row mt-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('No')->width(50)->addClass('text-center'),
            Column::make('nidn_nuptk')->title('NIDN / NUPTK'),
            Column::make('nama_dosen')->title('Nama Dosen & Email'),
            Column::make('program_studi')->title('Program Studi'),
            Column::make('no_hp')->title('No. HP'),
            Column::make('status')->title('Status'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Dosen_' . date('YmdHis');
    }
}
