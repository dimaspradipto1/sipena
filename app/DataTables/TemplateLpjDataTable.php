<?php

namespace App\DataTables;

use App\Models\TemplateLpj;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TemplateLpjDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<TemplateLpj> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('nama_dokumen', function ($row) {
                $html = '<div class="fw-bold text-dark">' . e($row->nama) . '</div>';
                if (!empty($row->keterangan)) {
                    $html .= '<small class="text-muted text-wrap d-block mt-1" style="max-width: 320px;">' . e($row->keterangan) . '</small>';
                }
                return $html;
            })
            ->editColumn('kategori', function ($row) {
                return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">' . e($row->kategori) . '</span>';
            })
            ->editColumn('tipe', function ($row) {
                if ($row->tipe === 'link') {
                    return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="bi bi-link-45deg me-1"></i> Custom Link</span>';
                }
                return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-file-earmark-word me-1"></i> File Upload</span>';
            })
            ->addColumn('sumber', function ($row) {
                if ($row->tipe === 'link' && !empty($row->url_link)) {
                    $url = e($row->url_link);
                    $display = strlen($url) > 40 ? substr($url, 0, 37) . '...' : $url;
                    return '<a href="' . $url . '" target="_blank" class="text-primary text-decoration-none small d-inline-flex align-items-center" title="' . $url . '">
                                <i class="bi bi-box-arrow-up-right me-1"></i> ' . e($display) . '
                            </a>';
                }

                $fileName = $row->file_name ?? basename($row->file_path ?? 'Dokumen Template');
                return '<span class="small text-secondary"><i class="bi bi-paperclip me-1"></i>' . e($fileName) . '</span>';
            })
            ->editColumn('is_active', function ($row) {
                if ($row->is_active) {
                    return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>';
                }
                return '<span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i> Non-Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                $user = Auth::user();
                $isAdmin = $user && in_array($user->role, ['superadmin', 'adminbkak']);

                $downloadUrl = route('template-lpj.download', $row->id);
                $btnDownload = '<a href="' . $downloadUrl . '" class="btn-action btn-action-download" title="Download / Buka Dokumen" target="' . ($row->tipe === 'link' ? '_blank' : '_self') . '">
                                    <i class="bi bi-download"></i>
                                </a>';

                if (!$isAdmin) {
                    return '<div class="action-btn-group" role="group">' . $btnDownload . '</div>';
                }

                $editUrl = route('template-lpj.edit', $row->id);
                $deleteUrl = route('template-lpj.destroy', $row->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                $btnEdit = '<a href="' . $editUrl . '" class="btn-action btn-action-edit" title="Edit Template">
                                <i class="bi bi-pencil-square"></i>
                            </a>';

                $btnDelete = '
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline m-0 p-0 delete-form">
                        ' . $csrf . '
                        ' . $method . '
                        <button type="button" class="btn-action btn-action-delete btn-delete" data-id="' . $row->id . '" title="Hapus Template">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>';

                return '<div class="action-btn-group" role="group">' . $btnDownload . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['nama_dokumen', 'kategori', 'tipe', 'sumber', 'is_active', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<TemplateLpj>
     */
    public function query(TemplateLpj $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('is_active', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('templatelpj-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'asc')
                    ->parameters([
                        'scrollX' => true,
                        'responsive' => true,
                        'language' => [
                            'search' => 'Cari:',
                            'lengthMenu' => 'Tampilkan _MENU_ data',
                            'zeroRecords' => 'Data template LPJ tidak ditemukan',
                            'info' => 'Menampilkan _START_ - _END_ dari _TOTAL_ template',
                            'infoEmpty' => 'Tidak ada data template',
                            'paginate' => [
                                'first' => 'Pertama',
                                'last' => 'Terakhir',
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
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false)->width(40)->addClass('text-center'),
            Column::make('nama_dokumen')->title('Nama Dokumen Template'),
            Column::make('kategori')->title('Kategori')->width(140),
            Column::make('tipe')->title('Tipe Sumber')->width(130),
            Column::make('sumber')->title('Tautan / File')->orderable(false),
            Column::make('is_active')->title('Status')->width(90)->addClass('text-center'),
            Column::computed('action')
                  ->title('Aksi')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TemplateLpj_' . date('YmdHis');
    }
}
