<?php

namespace App\Http\Controllers;

use App\DataTables\KejuaraanDataTable;
use App\Models\Kejuaraan;
use Illuminate\Http\Request;

class KejuaraanController extends Controller
{
    /**
     * Options helper for dropdowns
     */
    private function getFormOptions(): array
    {
        return [
            'jenis_penyelenggaraans' => [
                'Penyelenggara Kompetisi/Ajang Mandiri' => 'Penyelenggara Kompetisi/Ajang Mandiri',
                'Belmawa / Kemendikbud'                => 'Belmawa / Kemendikbud',
                'Lainnya / Eksternal'                  => 'Lainnya / Eksternal',
            ],
            'tingkats' => [
                'Nasional'           => 'Nasional',
                'Internasional'      => 'Internasional',
                'Wilayah / Regional' => 'Wilayah / Regional',
                'Lokal / Provinsi'   => 'Lokal / Provinsi',
            ],
            'kategoris' => [
                'Penalaran dan Kreativitas' => 'Penalaran dan Kreativitas',
                'Seni dan Budaya'           => 'Seni dan Budaya',
                'Olahraga'                  => 'Olahraga',
                'Kewirausahaan'             => 'Kewirausahaan',
                'Keagamaan / Kebangsaan'    => 'Keagamaan / Kebangsaan',
            ],
            'bentuks' => [
                'Luring (Offline)'         => 'Luring (Offline)',
                'Daring (Online)'          => 'Daring (Online)',
                'Hybrid (Daring & Luring)' => 'Hybrid (Daring & Luring)',
            ],
            'statuses' => [
                'Terverifikasi' => 'Terverifikasi',
                'Submitted'     => 'Submitted',
                'Draft'         => 'Draft',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(KejuaraanDataTable $dataTable)
    {
        return $dataTable->render('pages.kejuaraan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $kejuaraan = new Kejuaraan();
        return view('pages.kejuaraan.create', compact('options', 'kejuaraan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ajang'             => ['required', 'string', 'max:255'],
            'jenis_penyelenggaraan' => ['required', 'string'],
            'tingkat_level'         => ['required', 'string'],
            'kategori'               => ['required', 'string'],
            'bentuk'                 => ['required', 'string'],
            'tempat'                 => ['required', 'string', 'max:255'],
            'url_ajang'              => ['required', 'url', 'max:255'],
            'tahun'                  => ['required', 'digits:4', 'integer', 'min:2000', 'max:2099'],
            'url_laporan_kegiatan'   => ['nullable', 'url', 'max:255'],
            'kode_pt'                => ['required', 'string', 'max:50'],
            'nama_pt'                => ['required', 'string', 'max:255'],
            'jumlah_peserta'         => ['nullable', 'integer', 'min:0'],
            'status'                 => ['nullable', 'string'],
        ], [
            'nama_ajang.required'   => 'Nama Ajang / Lomba wajib diisi.',
            'tempat.required'       => 'Tempat penyelenggaraan wajib diisi.',
            'url_ajang.required'    => 'URL Ajang wajib diisi.',
            'tahun.required'        => 'Tahun kegiatan wajib diisi.',
        ]);

        $validated['status'] = (auth()->check() && in_array(auth()->user()->role, ['superadmin', 'adminbkak']))
            ? ($request->input('status', 'Terverifikasi'))
            : 'Submitted';

        Kejuaraan::create($validated);

        return redirect()->route('kejuaraan.index')
            ->with('success', 'Data Laporan Kejuaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kejuaraan $kejuaraan)
    {
        return view('pages.kejuaraan.show', compact('kejuaraan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kejuaraan $kejuaraan)
    {
        $options = $this->getFormOptions();
        return view('pages.kejuaraan.edit', compact('options', 'kejuaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kejuaraan $kejuaraan)
    {
        $validated = $request->validate([
            'nama_ajang'             => ['required', 'string', 'max:255'],
            'jenis_penyelenggaraan' => ['required', 'string'],
            'tingkat_level'         => ['required', 'string'],
            'kategori'               => ['required', 'string'],
            'bentuk'                 => ['required', 'string'],
            'tempat'                 => ['required', 'string', 'max:255'],
            'url_ajang'              => ['required', 'url', 'max:255'],
            'tahun'                  => ['required', 'digits:4', 'integer', 'min:2000', 'max:2099'],
            'url_laporan_kegiatan'   => ['nullable', 'url', 'max:255'],
            'kode_pt'                => ['required', 'string', 'max:50'],
            'nama_pt'                => ['required', 'string', 'max:255'],
            'jumlah_peserta'         => ['nullable', 'integer', 'min:0'],
            'status'                 => ['nullable', 'string'],
        ], [
            'nama_ajang.required'   => 'Nama Ajang / Lomba wajib diisi.',
            'tempat.required'       => 'Tempat penyelenggaraan wajib diisi.',
            'url_ajang.required'    => 'URL Ajang wajib diisi.',
            'tahun.required'        => 'Tahun kegiatan wajib diisi.',
        ]);

        $kejuaraan->update($validated);

        return redirect()->route('kejuaraan.index')
            ->with('success', 'Data Laporan Kejuaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Kejuaraan $kejuaraan)
    {
        $kejuaraan->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data Kejuaraan berhasil dihapus.']);
        }

        return redirect()->route('kejuaraan.index')
            ->with('success', 'Data Kejuaraan berhasil dihapus.');
    }
}
