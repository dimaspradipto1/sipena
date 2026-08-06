<?php

namespace App\DataTables;

use App\Models\Kejuaraan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KejuaraanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function (Kejuaraan $model) {
                return '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
            })
            ->addColumn('ajang_lomba', function (Kejuaraan $model) {
                $html = '<div class="fw-bold text-dark">' . e($model->nama_ajang) . '</div>';
                if ($model->kategori) {
                    $html .= '<small class="text-muted"><i class="bi bi-tag me-1"></i>' . e($model->kategori) . '</small>';
                }
                return $html;
            })
            ->editColumn('jenis_penyelenggaraan', function (Kejuaraan $model) {
                return '<span class="text-secondary small fw-medium">' . e($model->jenis_penyelenggaraan) . '</span>';
            })
            ->editColumn('tingkat_level', function (Kejuaraan $model) {
                $badgeClass = 'bg-info text-white';
                if ($model->tingkat_level === 'Internasional') {
                    $badgeClass = 'bg-success text-white';
                } elseif ($model->tingkat_level === 'Wilayah / Regional') {
                    $badgeClass = 'bg-secondary text-white';
                }
                return '<span class="badge ' . $badgeClass . ' px-2 py-1"><i class="bi bi-globe me-1"></i>' . e($model->tingkat_level) . '</span>';
            })
            ->editColumn('tempat', function (Kejuaraan $model) {
                return '<span class="small text-dark">' . e($model->tempat ?? '-') . '</span>';
            })
            ->editColumn('tahun', function (Kejuaraan $model) {
                return '<span class="badge bg-light text-dark border">' . e($model->tahun) . '</span>';
            })
            ->editColumn('nama_pt', function (Kejuaraan $model) {
                return '<div class="fw-medium text-dark">' . e($model->nama_pt) . '</div><small class="text-muted">' . e($model->kode_pt) . '</small>';
            })
            ->editColumn('status', function (Kejuaraan $model) {
                $badge = 'bg-success text-white';
                if ($model->status === 'Draft') {
                    $badge = 'bg-secondary text-white';
                } elseif ($model->status === 'Submitted') {
                    $badge = 'bg-warning text-dark';
                } elseif ($model->status === 'Ditolak') {
                    $badge = 'bg-danger text-white';
                }
                return '<span class="badge ' . $badge . ' px-2 py-1">' . e($model->status) . '</span>';
            })
            ->addColumn('peserta', function (Kejuaraan $model) {
                return '<span class="badge bg-light text-primary border fw-bold"><i class="bi bi-people me-1"></i>' . e($model->jumlah_peserta ?? 0) . ' Peserta</span>';
            })
            ->addColumn('action', function (Kejuaraan $model) {
                return '
                <div class="btn-group" role="group">
                    <a href="' . route('kejuaraan.show', $model->id) . '" class="btn btn-sm btn-info text-white" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="' . route('kejuaraan.edit', $model->id) . '" class="btn btn-sm btn-warning text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $model->id . '" data-name="' . e($model->nama_ajang) . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                ';
            })
            ->rawColumns(['ajang_lomba', 'jenis_penyelenggaraan', 'tingkat_level', 'tempat', 'tahun', 'nama_pt', 'status', 'peserta', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Kejuaraan $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kejuaraan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->selectStyleSingle()
                    ->parameters([
                        'dom'          => "<'row mb-3'<'col-md-6'l><'col-md-6'f>>" .
                                          "<'row'<'col-md-12'tr>>" .
                                          "<'row mt-3'<'col-md-5'i><'col-md-7'p>>",
                        'language'     => [
                            'search'         => 'Cari:',
                            'searchPlaceholder' => 'Cari ajang, level, tempat, atau PT',
                            'lengthMenu'     => 'Tampilkan _MENU_ data',
                            'info'           => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty'      => 'Belum ada laporan kejuaraan yang cocok.',
                            'zeroRecords'    => 'Belum ada laporan kejuaraan yang cocok.',
                            'paginate'       => [
                                'first'    => 'Pertama',
                                'last'     => 'Terakhir',
                                'next'     => 'Selanjutnya',
                                'previous' => 'Sebelumnya'
                            ]
                        ],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->width('8%')->addClass('text-center align-middle'),
            Column::computed('ajang_lomba')->title('Ajang / Lomba')->addClass('align-middle'),
            Column::make('jenis_penyelenggaraan')->title('Jenis Ajang')->addClass('align-middle'),
            Column::make('tingkat_level')->title('Level')->addClass('text-center align-middle'),
            Column::make('tempat')->title('Tempat')->addClass('align-middle'),
            Column::make('tahun')->title('Tahun Kegiatan')->addClass('text-center align-middle'),
            Column::make('nama_pt')->title('PT')->addClass('align-middle'),
            Column::make('status')->title('Status')->addClass('text-center align-middle'),
            Column::computed('peserta')->title('Peserta')->addClass('text-center align-middle'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width('12%')
                  ->addClass('text-center align-middle')
                  ->title('Aksi'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kejuaraan_' . date('YmdHis');
    }
}
