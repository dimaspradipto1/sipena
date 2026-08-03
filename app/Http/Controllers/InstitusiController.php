<?php

namespace App\Http\Controllers;

use App\DataTables\InstitusiDataTable;
use App\Models\Institusi;
use Illuminate\Http\Request;

class InstitusiController extends Controller
{
    /**
     * Helper options for dropdowns
     */
    private function getFormOptions(): array
    {
        return [
            'bentuks' => [
                'Universitas'    => 'Universitas',
                'Institut'       => 'Institut',
                'Sekolah Tinggi' => 'Sekolah Tinggi',
                'Politeknik'     => 'Politeknik',
                'Akademi'        => 'Akademi',
            ],
            'statuses' => [
                'Swasta (PTS)' => 'Swasta (PTS)',
                'Negeri (PTN)' => 'Negeri (PTN)',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(InstitusiDataTable $dataTable)
    {
        return $dataTable->render('pages.institusi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $institusi = new Institusi();
        return view('pages.institusi.create', compact('options', 'institusi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pt'                               => ['required', 'string', 'max:50'],
            'nama_pt'                               => ['required', 'string', 'max:255'],
            'bentuk_pt'                             => ['nullable', 'string'],
            'status_institusi'                      => ['nullable', 'string'],
            'alamat'                                => ['nullable', 'string'],
            'kota'                                  => ['nullable', 'string', 'max:100'],
            'provinsi'                              => ['nullable', 'string', 'max:100'],
            'telepon'                               => ['nullable', 'string', 'max:50'],
            'email'                                 => ['nullable', 'email', 'max:255'],
            'website'                               => ['nullable', 'url', 'max:255'],
            'nama_rektor'                           => ['nullable', 'string', 'max:255'],
            'nip_rektor'                            => ['nullable', 'string', 'max:100'],
            'nama_warek3'                           => ['nullable', 'string', 'max:255'],
            'nip_warek3'                            => ['nullable', 'string', 'max:100'],
            'no_hp_pic'                             => ['nullable', 'string', 'max:50'],
            'link_sk_pendirian'                     => ['nullable', 'url', 'max:255'],
            'link_pedoman_kemahasiswaan'            => ['nullable', 'url', 'max:255'],
            'link_struktur_organisasi'              => ['nullable', 'url', 'max:255'],
            'tahun_pelaporan'                       => ['nullable', 'string'],
            'mhs_nonapbn'                           => ['nullable', 'integer'],
            'mhs_aktif'                             => ['nullable', 'integer'],
            'link_nonapbn'                          => ['nullable', 'url', 'max:255'],
            'link_mhs_aktif'                        => ['nullable', 'url', 'max:255'],
            'level_kelembagaan'                     => ['nullable', 'string'],
            'link_sk_pengangkat_pimpinan'           => ['nullable', 'url', 'max:255'],
            'link_struktur_pengelola_kemahasiswaan' => ['nullable', 'url', 'max:255'],
            'total_anggaran_pt'                     => ['nullable', 'numeric'],
            'total_anggaran_kemahasiswaan'          => ['nullable', 'numeric'],
            'link_anggaran_pt'                      => ['nullable', 'url', 'max:255'],
            'link_anggaran_kemahasiswaan'           => ['nullable', 'url', 'max:255'],
            'keterangan'                            => ['nullable', 'string'],
        ], [
            'kode_pt.required' => 'Kode Perguruan Tinggi wajib diisi.',
            'nama_pt.required' => 'Nama Perguruan Tinggi wajib diisi.',
        ]);

        $validated['status'] = 'Aktif';

        // Pack JSON indicator checklist data for Points A, B, C, D, E
        $validated['data_indikator'] = [
            'regulasi'             => $request->input('indikator_regulasi', []),
            'link_regulasi'        => $request->input('link_regulasi', []),
            'beasiswa_a'           => $request->input('indikator_beasiswa_a', []),
            'link_beasiswa_a'      => $request->input('link_beasiswa_a', []),
            'kesehatan'            => $request->input('indikator_kesehatan', []),
            'link_kesehatan'       => $request->input('link_kesehatan', []),
            'konseling'            => $request->input('indikator_konseling', []),
            'link_konseling'       => $request->input('link_konseling', []),
            'kekerasan'            => $request->input('indikator_kekerasan', []),
            'link_kekerasan'       => $request->input('link_kekerasan', []),
            'anti_intoleransi'     => $request->input('indikator_anti_intoleransi', []),
            'link_anti_intoleransi' => $request->input('link_anti_intoleransi', []),
            'wirausaha'            => $request->input('indikator_wirausaha', []),
            'link_wirausaha'       => $request->input('link_wirausaha', []),
            'karakter'             => $request->input('indikator_karakter', []),
            'link_karakter'        => $request->input('link_karakter', []),
            'tupoksi'              => $request->input('indikator_tupoksi', []),
            'link_tupoksi'         => $request->input('link_tupoksi', []),
            'sarpras'              => $request->input('indikator_sarpras', []),
            'link_sarpras'         => $request->input('link_sarpras', []),
            'penghargaan'          => $request->input('indikator_penghargaan', []),
            'link_penghargaan'     => $request->input('link_penghargaan', []),
        ];

        Institusi::create($validated);

        return redirect()->route('institusi.index')
            ->with('success', 'Data Institusi Perguruan Tinggi & Indikator SIMKATMAWA berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institusi $institusi)
    {
        return view('pages.institusi.show', compact('institusi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institusi $institusi)
    {
        $options = $this->getFormOptions();
        return view('pages.institusi.edit', compact('options', 'institusi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institusi $institusi)
    {
        $validated = $request->validate([
            'kode_pt'                               => ['required', 'string', 'max:50'],
            'nama_pt'                               => ['required', 'string', 'max:255'],
            'bentuk_pt'                             => ['nullable', 'string'],
            'status_institusi'                      => ['nullable', 'string'],
            'alamat'                                => ['nullable', 'string'],
            'kota'                                  => ['nullable', 'string', 'max:100'],
            'provinsi'                              => ['nullable', 'string', 'max:100'],
            'telepon'                               => ['nullable', 'string', 'max:50'],
            'email'                                 => ['nullable', 'email', 'max:255'],
            'website'                               => ['nullable', 'url', 'max:255'],
            'nama_rektor'                           => ['nullable', 'string', 'max:255'],
            'nip_rektor'                            => ['nullable', 'string', 'max:100'],
            'nama_warek3'                           => ['nullable', 'string', 'max:255'],
            'nip_warek3'                            => ['nullable', 'string', 'max:100'],
            'no_hp_pic'                             => ['nullable', 'string', 'max:50'],
            'link_sk_pendirian'                     => ['nullable', 'url', 'max:255'],
            'link_pedoman_kemahasiswaan'            => ['nullable', 'url', 'max:255'],
            'link_struktur_organisasi'              => ['nullable', 'url', 'max:255'],
            'tahun_pelaporan'                       => ['nullable', 'string'],
            'mhs_nonapbn'                           => ['nullable', 'integer'],
            'mhs_aktif'                             => ['nullable', 'integer'],
            'link_nonapbn'                          => ['nullable', 'url', 'max:255'],
            'link_mhs_aktif'                        => ['nullable', 'url', 'max:255'],
            'level_kelembagaan'                     => ['nullable', 'string'],
            'link_sk_pengangkat_pimpinan'           => ['nullable', 'url', 'max:255'],
            'link_struktur_pengelola_kemahasiswaan' => ['nullable', 'url', 'max:255'],
            'total_anggaran_pt'                     => ['nullable', 'numeric'],
            'total_anggaran_kemahasiswaan'          => ['nullable', 'numeric'],
            'link_anggaran_pt'                      => ['nullable', 'url', 'max:255'],
            'link_anggaran_kemahasiswaan'           => ['nullable', 'url', 'max:255'],
            'keterangan'                            => ['nullable', 'string'],
        ], [
            'kode_pt.required' => 'Kode Perguruan Tinggi wajib diisi.',
            'nama_pt.required' => 'Nama Perguruan Tinggi wajib diisi.',
        ]);

        $validated['data_indikator'] = [
            'regulasi'             => $request->input('indikator_regulasi', []),
            'link_regulasi'        => $request->input('link_regulasi', []),
            'beasiswa_a'           => $request->input('indikator_beasiswa_a', []),
            'link_beasiswa_a'      => $request->input('link_beasiswa_a', []),
            'kesehatan'            => $request->input('indikator_kesehatan', []),
            'link_kesehatan'       => $request->input('link_kesehatan', []),
            'konseling'            => $request->input('indikator_konseling', []),
            'link_konseling'       => $request->input('link_konseling', []),
            'kekerasan'            => $request->input('indikator_kekerasan', []),
            'link_kekerasan'       => $request->input('link_kekerasan', []),
            'anti_intoleransi'     => $request->input('indikator_anti_intoleransi', []),
            'link_anti_intoleransi' => $request->input('link_anti_intoleransi', []),
            'wirausaha'            => $request->input('indikator_wirausaha', []),
            'link_wirausaha'       => $request->input('link_wirausaha', []),
            'karakter'             => $request->input('indikator_karakter', []),
            'link_karakter'        => $request->input('link_karakter', []),
            'tupoksi'              => $request->input('indikator_tupoksi', []),
            'link_tupoksi'         => $request->input('link_tupoksi', []),
            'sarpras'              => $request->input('indikator_sarpras', []),
            'link_sarpras'         => $request->input('link_sarpras', []),
            'penghargaan'          => $request->input('indikator_penghargaan', []),
            'link_penghargaan'     => $request->input('link_penghargaan', []),
        ];

        $institusi->update($validated);

        return redirect()->route('institusi.index')
            ->with('success', 'Data Institusi Perguruan Tinggi & Indikator SIMKATMAWA berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Institusi $institusi)
    {
        $institusi->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data Institusi berhasil dihapus.']);
        }

        return redirect()->route('institusi.index')
            ->with('success', 'Data Institusi berhasil dihapus.');
    }
}
