<?php

namespace App\DataTables;

use App\Models\PrestasiBelmawa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PrestasiBelmawaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('id', function (PrestasiBelmawa $model) {
                return '#' . str_pad($model->id, 6, '0', STR_PAD_LEFT);
            })
            ->addColumn('lomba_kompetisi', function (PrestasiBelmawa $model) {
                $html = '<div class="fw-bold text-dark">' . e($model->nama_lomba) . '</div>';
                if ($model->kategori_lomba) {
                    $html .= '<small class="text-muted"><i class="bi bi-tag me-1"></i>' . e($model->kategori_lomba) . '</small>';
                }
                return $html;
            })
            ->editColumn('capaian_prestasi', function (PrestasiBelmawa $model) {
                $badgeClass = 'bg-primary';
                if (str_contains(strtolower($model->capaian_prestasi), 'emas') || str_contains(strtolower($model->capaian_prestasi), 'juara 1')) {
                    $badgeClass = 'bg-warning text-dark';
                } elseif (str_contains(strtolower($model->capaian_prestasi), 'perak') || str_contains(strtolower($model->capaian_prestasi), 'juara 2')) {
                    $badgeClass = 'bg-secondary text-white';
                } elseif (str_contains(strtolower($model->capaian_prestasi), 'perunggu') || str_contains(strtolower($model->capaian_prestasi), 'juara 3')) {
                    $badgeClass = 'bg-danger';
                }
                return '<span class="badge ' . $badgeClass . ' px-2 py-1 fs-7"><i class="bi bi-trophy me-1"></i>' . e($model->capaian_prestasi) . '</span>';
            })
            ->editColumn('tahun', function (PrestasiBelmawa $model) {
                return '<span class="badge bg-light text-dark border">' . e($model->tahun) . '</span>';
            })
            ->editColumn('nama_pt', function (PrestasiBelmawa $model) {
                return '<div class="fw-medium text-dark">' . e($model->nama_pt) . '</div><small class="text-muted">' . e($model->kode_pt) . '</small>';
            })
            ->editColumn('keterangan', function (PrestasiBelmawa $model) {
                return '<span class="text-muted small">' . e($model->keterangan ?? '-') . '</span>';
            })
            ->editColumn('status', function (PrestasiBelmawa $model) {
                $status = $model->status ?? 'Terverifikasi';
                $badge = 'bg-success text-white';
                if ($status === 'Submitted') {
                    $badge = 'bg-warning text-dark';
                } elseif ($status === 'Draft') {
                    $badge = 'bg-secondary text-white';
                } elseif ($status === 'Ditolak') {
                    $badge = 'bg-danger text-white';
                }
                return '<span class="badge ' . $badge . ' px-2 py-1">' . e($status) . '</span>';
            })
            ->addColumn('action', function (PrestasiBelmawa $model) {
                return '
                <div class="btn-group" role="group">
                    <a href="' . route('prestasi-belmawa.show', $model->id) . '" class="btn btn-sm btn-info text-white" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="' . route('prestasi-belmawa.edit', $model->id) . '" class="btn btn-sm btn-warning text-white" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $model->id . '" data-name="' . e($model->nama_lomba) . '" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                ';
            })
            ->rawColumns(['lomba_kompetisi', 'capaian_prestasi', 'tahun', 'nama_pt', 'keterangan', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PrestasiBelmawa $model): QueryBuilder
    {
        $query = $model->newQuery();
        $user = auth()->user();
        if ($user && $user->role === 'mahasiswa') {
            $name = trim($user->name);
            $query->where(function ($q) use ($name) {
                $q->where('nama_mahasiswa', 'LIKE', '%' . $name . '%')
                  ->orWhere('nama_mahasiswa', 'LIKE', '%' . strtolower($name) . '%')
                  ->orWhere('nama_mahasiswa', 'LIKE', '%' . strtoupper($name) . '%')
                  ->orWhere('nama_mahasiswa', 'LIKE', '%' . ucwords(strtolower($name)) . '%');
            });
        }
        return $query->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('prestasi-belmawa-table')
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
                            'searchPlaceholder' => 'Masukkan Kata Kunci...',
                            'lengthMenu'     => 'Tampilkan _MENU_ data',
                            'info'           => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                            'infoEmpty'      => 'Tidak ada data yang ditampilkan',
                            'zeroRecords'    => 'Data tidak ditemukan',
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
            Column::make('id')->title('ID')->width('10%')->addClass('text-center align-middle'),
            Column::computed('lomba_kompetisi')->title('Lomba/Kompetisi')->addClass('align-middle'),
            Column::make('capaian_prestasi')->title('Prestasi')->addClass('text-center align-middle'),
            Column::make('tahun')->title('Tahun')->addClass('text-center align-middle'),
            Column::make('nama_pt')->title('PT')->addClass('align-middle'),
            Column::make('keterangan')->title('Keterangan')->addClass('align-middle'),
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
        return 'PrestasiBelmawa_' . date('YmdHis');
    }
}
