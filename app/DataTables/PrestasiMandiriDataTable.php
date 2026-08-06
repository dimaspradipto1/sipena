<?php

namespace App\DataTables;

use App\Models\PrestasiMandiri;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PrestasiMandiriDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<PrestasiMandiri> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('id_formatted', function ($item) {
                return '<span class="fw-bold text-dark">#' . str_pad($item->id, 6, '0', STR_PAD_LEFT) . '</span>';
            })
            ->addColumn('lomba_kompetisi', function ($item) {
                return '<div>
                    <div class="fw-bold text-primary">' . e($item->nama_kompetisi) . '</div>
                    <small class="text-muted">' . e($item->level) . ' &bull; ' . e($item->kategori) . '</small>
                </div>';
            })
            ->editColumn('nama_cabang', function ($item) {
                return '<span class="text-dark">' . e($item->nama_cabang) . '</span>';
            })
            ->editColumn('peringkat', function ($item) {
                return '<span class="fw-medium">' . e($item->peringkat) . '</span>';
            })
            ->addColumn('tahun_display', function ($item) {
                return $item->tahun ?? ($item->created_at ? $item->created_at->format('Y') : date('Y'));
            })
            ->editColumn('pt', function ($item) {
                return '<span class="small text-secondary">' . e($item->pt ?? 'Universitas Ibnu Sina') . '</span>';
            })
            ->editColumn('status', function ($item) {
                $status = $item->status ?? 'Terverifikasi';
                $badgeClass = 'bg-success text-white';
                if ($status === 'Submitted') {
                    $badgeClass = 'bg-warning text-dark';
                } elseif ($status === 'Draft') {
                    $badgeClass = 'bg-secondary text-white';
                } elseif ($status === 'Ditolak') {
                    $badgeClass = 'bg-danger text-white';
                }
                return '<span class="badge ' . $badgeClass . ' px-2 py-1">' . e($status) . '</span>';
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('prestasi-mandiri.edit', $item->id);
                $showUrl = route('prestasi-mandiri.show', $item->id);
                $deleteUrl = route('prestasi-mandiri.destroy', $item->id);
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
            ->rawColumns(['id_formatted', 'lomba_kompetisi', 'nama_cabang', 'peringkat', 'pt', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<PrestasiMandiri>
     */
    public function query(PrestasiMandiri $model): QueryBuilder
    {
        $query = $model->newQuery();
        $user = auth()->user();
        if ($user && $user->role === 'mahasiswa') {
            $name = trim($user->name);
            $query->where(function ($q) use ($name) {
                $q->where('data_mahasiswa', 'LIKE', '%' . $name . '%')
                  ->orWhere('data_mahasiswa', 'LIKE', '%' . strtolower($name) . '%')
                  ->orWhere('data_mahasiswa', 'LIKE', '%' . strtoupper($name) . '%')
                  ->orWhere('data_mahasiswa', 'LIKE', '%' . ucwords(strtolower($name)) . '%');
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
                    ->setTableId('prestasimandiri-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->parameters([
                        'scrollX' => true,
                        'language' => [
                            'search' => 'Cari:',
                            'lengthMenu' => 'Tampilkan _MENU_ data',
                            'zeroRecords' => 'Belum ada data prestasi mandiri',
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
            Column::make('lomba_kompetisi')->title('Lomba/Kompetisi')->name('nama_kompetisi'),
            Column::make('nama_cabang')->title('Cabang')->name('nama_cabang'),
            Column::make('peringkat')->title('Peringkat')->name('peringkat'),
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
        return 'PrestasiMandiri_' . date('YmdHis');
    }
}
