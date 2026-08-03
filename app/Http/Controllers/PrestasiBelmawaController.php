<?php

namespace App\Http\Controllers;

use App\DataTables\PrestasiBelmawaDataTable;
use App\Models\PrestasiBelmawa;
use Illuminate\Http\Request;

class PrestasiBelmawaController extends Controller
{
    /**
     * Options helper for dropdowns
     */
    private function getFormOptions(): array
    {
        return [
            'tingkats' => [
                'Nasional' => 'Nasional',
                'Wilayah/Regional' => 'Wilayah / Regional',
                'Internasional' => 'Internasional',
            ],
            'prestasis' => [
                'Juara 1 (Medali Emas)'   => 'Juara 1 (Medali Emas)',
                'Juara 2 (Medali Perak)'  => 'Juara 2 (Medali Perak)',
                'Juara 3 (Medali Perunggu)' => 'Juara 3 (Medali Perunggu)',
                'Juara Harapan 1'         => 'Juara Harapan 1',
                'Juara Harapan 2'         => 'Juara Harapan 2',
                'Juara Harapan 3'         => 'Juara Harapan 3',
                'Finalis'                 => 'Finalis',
                'Peserta Terpilih'        => 'Peserta Terpilih',
            ],
            'statuses' => [
                'Terverifikasi' => 'Terverifikasi',
                'Pending'       => 'Pending',
                'Draft'         => 'Draft',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PrestasiBelmawaDataTable $dataTable)
    {
        return $dataTable->render('pages.prestasi-belmawa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $prestasiBelmawa = new PrestasiBelmawa();
        return view('pages.prestasi-belmawa.create', compact('options', 'prestasiBelmawa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lomba'          => ['required', 'string', 'max:255'],
            'kategori_lomba'      => ['nullable', 'string', 'max:255'],
            'tingkat'             => ['required', 'string'],
            'capaian_prestasi'    => ['required', 'string'],
            'tahun'               => ['required', 'digits:4', 'integer', 'min:2000', 'max:2099'],
            'kode_pt'             => ['required', 'string', 'max:50'],
            'nama_pt'             => ['required', 'string', 'max:255'],
            'nama_mahasiswa'      => ['nullable', 'string', 'max:255'],
            'nim'                 => ['nullable', 'string', 'max:100'],
            'program_studi'       => ['nullable', 'string', 'max:255'],
            'dosen_pembimbing'    => ['nullable', 'string', 'max:255'],
            'link_sk_kemendikbud' => ['nullable', 'url', 'max:255'],
            'link_sertifikat'     => ['nullable', 'url', 'max:255'],
            'keterangan'          => ['nullable', 'string'],
            'status'              => ['nullable', 'string'],
        ], [
            'nama_lomba.required'       => 'Nama Lomba / Kompetisi wajib diisi.',
            'capaian_prestasi.required' => 'Capaian Prestasi wajib dipilih.',
            'tahun.required'            => 'Tahun kegiatan wajib diisi.',
            'kode_pt.required'          => 'Kode PT wajib diisi.',
            'nama_pt.required'          => 'Nama Perguruan Tinggi wajib diisi.',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'Terverifikasi';
        }

        PrestasiBelmawa::create($validated);

        return redirect()->route('prestasi-belmawa.index')
            ->with('success', 'Data Prestasi Belmawa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestasiBelmawa $prestasiBelmawa)
    {
        return view('pages.prestasi-belmawa.show', compact('prestasiBelmawa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiBelmawa $prestasiBelmawa)
    {
        $options = $this->getFormOptions();
        return view('pages.prestasi-belmawa.edit', compact('options', 'prestasiBelmawa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiBelmawa $prestasiBelmawa)
    {
        $validated = $request->validate([
            'nama_lomba'          => ['required', 'string', 'max:255'],
            'kategori_lomba'      => ['nullable', 'string', 'max:255'],
            'tingkat'             => ['required', 'string'],
            'capaian_prestasi'    => ['required', 'string'],
            'tahun'               => ['required', 'digits:4', 'integer', 'min:2000', 'max:2099'],
            'kode_pt'             => ['required', 'string', 'max:50'],
            'nama_pt'             => ['required', 'string', 'max:255'],
            'nama_mahasiswa'      => ['nullable', 'string', 'max:255'],
            'nim'                 => ['nullable', 'string', 'max:100'],
            'program_studi'       => ['nullable', 'string', 'max:255'],
            'dosen_pembimbing'    => ['nullable', 'string', 'max:255'],
            'link_sk_kemendikbud' => ['nullable', 'url', 'max:255'],
            'link_sertifikat'     => ['nullable', 'url', 'max:255'],
            'keterangan'          => ['nullable', 'string'],
            'status'              => ['nullable', 'string'],
        ], [
            'nama_lomba.required'       => 'Nama Lomba / Kompetisi wajib diisi.',
            'capaian_prestasi.required' => 'Capaian Prestasi wajib dipilih.',
            'tahun.required'            => 'Tahun kegiatan wajib diisi.',
            'kode_pt.required'          => 'Kode PT wajib diisi.',
            'nama_pt.required'          => 'Nama Perguruan Tinggi wajib diisi.',
        ]);

        $prestasiBelmawa->update($validated);

        return redirect()->route('prestasi-belmawa.index')
            ->with('success', 'Data Prestasi Belmawa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PrestasiBelmawa $prestasiBelmawa)
    {
        $prestasiBelmawa->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data Prestasi Belmawa berhasil dihapus.']);
        }

        return redirect()->route('prestasi-belmawa.index')
            ->with('success', 'Data Prestasi Belmawa berhasil dihapus.');
    }
}
