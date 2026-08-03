<?php

namespace App\Http\Controllers;

use App\Models\PrestasiMandiri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PrestasiMandiriController extends Controller
{
    /**
     * Helper to get dropdown options matching SIMKATMAWA specs
     */
    private function getFormOptions(): array
    {
        return [
            'levels' => [
                'Kabupaten/Kota' => 'Kabupaten/Kota',
                'Provinsi'       => 'Provinsi',
                'Nasional'       => 'Nasional',
                'Internasional'  => 'Internasional',
            ],
            'kategoris' => [
                'Riset dan Inovasi : STEM' => 'Riset dan Inovasi : STEM',
                'Riset dan Inovasi : SSH'  => 'Riset dan Inovasi : SSH',
                'Seni dan Budaya'          => 'Seni dan Budaya',
                'Olahraga'                 => 'Olahraga',
                'Minat Khusus'             => 'Minat Khusus',
            ],
            'peringkats' => [
                'Juara I'                      => 'Juara I',
                'Juara II'                     => 'Juara II',
                'Juara III'                    => 'Juara III',
                'Harapan I'                    => 'Harapan I',
                'Harapan II'                   => 'Harapan II',
                'Harapan III'                  => 'Harapan III',
                'Apresiasi / Finalis / Lainnya' => 'Apresiasi / Finalis / Lainnya',
            ],
            'kepesertaans' => [
                'Individu' => 'Individu',
                'Kelompok' => 'Kelompok',
            ],
            'bentuks' => [
                'Daring' => 'Daring',
                'Luring' => 'Luring',
                'Hybrid' => 'Hybrid',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = PrestasiMandiri::query();

            // Filter Level
            if ($request->filled('level')) {
                $query->where('level', $request->level);
            }

            // Filter Kategori
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            // Filter Tahun
            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            return DataTables::of($query->latest())
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
                    return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">' . e($item->status ?? 'Terverifikasi') . '</span>';
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
                ->make(true);
        }

        $options = $this->getFormOptions();
        return view('pages.prestasi-mandiri.index', $options);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $prestasiMandiri = new PrestasiMandiri();
        return view('pages.prestasi-mandiri.form', compact('options', 'prestasiMandiri'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level'                   => ['required', 'string'],
            'kategori'                => ['required', 'string'],
            'nama_kompetisi'          => ['required', 'string', 'max:255'],
            'nama_cabang'             => ['required', 'string', 'max:255'],
            'peringkat'               => ['required', 'string'],
            'nama_penyelenggara'      => ['required', 'string', 'max:255'],
            'jumlah_pt_peserta'       => ['nullable', 'integer', 'min:1'],
            'kepesertaan'             => ['required', 'string'],
            'bentuk'                  => ['required', 'string'],
            'url_kompetisi'           => ['nullable', 'url', 'max:255'],
            'link_dokumen_sertifikat' => ['nullable', 'url', 'max:255'],
            'tanggal_sertifikat'      => ['nullable', 'date'],
            'link_foto_upp'           => ['nullable', 'url', 'max:255'],
            'link_dokumen_undangan'   => ['nullable', 'url', 'max:255'],
            'keterangan'              => ['nullable', 'string'],
            'data_mahasiswa'          => ['nullable', 'array'],
            'data_mahasiswa.*.nim'    => ['nullable', 'string'],
            'data_mahasiswa.*.nama'   => ['nullable', 'string'],
            'data_dosen'              => ['nullable', 'array'],
            'data_dosen.*.nidn'       => ['nullable', 'string'],
            'data_dosen.*.nama'       => ['nullable', 'string'],
            'data_dosen.*.url_surat'  => ['nullable', 'string'],
        ]);

        // Clean empty rows from array
        $mahasiswa = array_values(array_filter($request->input('data_mahasiswa', []), function ($item) {
            return !empty($item['nim']) || !empty($item['nama']);
        }));

        $dosen = array_values(array_filter($request->input('data_dosen', []), function ($item) {
            return !empty($item['nidn']) || !empty($item['nama']);
        }));

        $validated['data_mahasiswa'] = $mahasiswa;
        $validated['data_dosen'] = $dosen;
        $validated['tahun'] = !empty($validated['tanggal_sertifikat']) 
            ? Carbon::parse($validated['tanggal_sertifikat'])->year 
            : date('Y');
        $validated['pt'] = 'Universitas Ibnu Sina';
        $validated['status'] = 'Terverifikasi';

        PrestasiMandiri::create($validated);

        return redirect()->route('prestasi-mandiri.index')
            ->with('success', 'Data Prestasi Mandiri terpadu berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestasiMandiri $prestasiMandiri)
    {
        return view('pages.prestasi-mandiri.show', compact('prestasiMandiri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiMandiri $prestasiMandiri)
    {
        $options = $this->getFormOptions();
        return view('pages.prestasi-mandiri.form', compact('options', 'prestasiMandiri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiMandiri $prestasiMandiri)
    {
        $validated = $request->validate([
            'level'                   => ['required', 'string'],
            'kategori'                => ['required', 'string'],
            'nama_kompetisi'          => ['required', 'string', 'max:255'],
            'nama_cabang'             => ['required', 'string', 'max:255'],
            'peringkat'               => ['required', 'string'],
            'nama_penyelenggara'      => ['required', 'string', 'max:255'],
            'jumlah_pt_peserta'       => ['nullable', 'integer', 'min:1'],
            'kepesertaan'             => ['required', 'string'],
            'bentuk'                  => ['required', 'string'],
            'url_kompetisi'           => ['nullable', 'url', 'max:255'],
            'link_dokumen_sertifikat' => ['nullable', 'url', 'max:255'],
            'tanggal_sertifikat'      => ['nullable', 'date'],
            'link_foto_upp'           => ['nullable', 'url', 'max:255'],
            'link_dokumen_undangan'   => ['nullable', 'url', 'max:255'],
            'keterangan'              => ['nullable', 'string'],
            'data_mahasiswa'          => ['nullable', 'array'],
            'data_dosen'              => ['nullable', 'array'],
        ]);

        $mahasiswa = array_values(array_filter($request->input('data_mahasiswa', []), function ($item) {
            return !empty($item['nim']) || !empty($item['nama']);
        }));

        $dosen = array_values(array_filter($request->input('data_dosen', []), function ($item) {
            return !empty($item['nidn']) || !empty($item['nama']);
        }));

        $validated['data_mahasiswa'] = $mahasiswa;
        $validated['data_dosen'] = $dosen;
        if (!empty($validated['tanggal_sertifikat'])) {
            $validated['tahun'] = Carbon::parse($validated['tanggal_sertifikat'])->year;
        }

        $prestasiMandiri->update($validated);

        return redirect()->route('prestasi-mandiri.index')
            ->with('success', 'Data Prestasi Mandiri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PrestasiMandiri $prestasiMandiri)
    {
        $prestasiMandiri->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data Prestasi Mandiri berhasil dihapus.']);
        }

        return redirect()->route('prestasi-mandiri.index')
            ->with('success', 'Data Prestasi Mandiri berhasil dihapus.');
    }
}
