<?php

namespace App\Http\Controllers;

use App\DataTables\PrestasiMandiriDataTable;
use App\Models\PrestasiMandiri;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function index(PrestasiMandiriDataTable $dataTable)
    {
        return $dataTable->render('pages.prestasi-mandiri.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $prestasiMandiri = new PrestasiMandiri();
        return view('pages.prestasi-mandiri.create', compact('options', 'prestasiMandiri'));
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
        return view('pages.prestasi-mandiri.edit', compact('options', 'prestasiMandiri'));
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
