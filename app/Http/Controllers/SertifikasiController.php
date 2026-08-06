<?php

namespace App\Http\Controllers;

use App\DataTables\SertifikasiDataTable;
use App\Models\Sertifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SertifikasiController extends Controller
{
    /**
     * Helper to get dropdown options for Sertifikasi
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
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SertifikasiDataTable $dataTable)
    {
        return $dataTable->render('pages.sertifikasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $sertifikasi = new Sertifikasi();
        return view('pages.sertifikasi.create', compact('options', 'sertifikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level'                   => ['required', 'string'],
            'nama_sertifikasi'        => ['required', 'string', 'max:255'],
            'nama_penyelenggara'      => ['required', 'string', 'max:255'],
            'url_sertifikasi'         => ['nullable', 'url', 'max:255'],
            'link_dokumen_sertifikat' => ['nullable', 'url', 'max:255'],
            'tanggal_sertifikat'      => ['nullable', 'date'],
            'link_foto_kegiatan'      => ['nullable', 'url', 'max:255'],
            'link_dokumen_undangan'   => ['nullable', 'url', 'max:255'],
            'keterangan'              => ['nullable', 'string'],
            'data_mahasiswa'          => ['nullable', 'array'],
            'data_mahasiswa.*.nim'    => ['nullable', 'string'],
            'data_mahasiswa.*.nama'   => ['nullable', 'string'],
            'data_dosen'              => ['nullable', 'array'],
            'data_dosen.*.nidn'       => ['nullable', 'string'],
            'data_dosen.*.nama'       => ['nullable', 'string'],
            'data_dosen.*.url_surat'  => ['nullable', 'string'],
        ], [
            'level.required'              => 'Level wajib dipilih.',
            'nama_sertifikasi.required'   => 'Nama Sertifikasi wajib diisi.',
            'nama_penyelenggara.required' => 'Nama Penyelenggara wajib diisi.',
        ]);

        $mahasiswa = array_values(array_filter($request->input('data_mahasiswa', []), function ($item) {
            return !empty($item['nim']) || !empty($item['nama']);
        }));

        $dosen = array_values(array_filter($request->input('data_dosen', []), function ($item) {
            return !empty($item['nidn']) || !empty($item['nama']);
        }));

        $user = auth()->user();
        if ($user && $user->role === 'mahasiswa') {
            $hasCurrentStudent = false;
            foreach ($mahasiswa as $mhs) {
                if (!empty($mhs['nama']) && strcasecmp(trim($mhs['nama']), trim($user->name)) === 0) {
                    $hasCurrentStudent = true;
                    break;
                }
            }
            if (!$hasCurrentStudent) {
                $mahasiswa[] = [
                    'nama'  => $user->name,
                    'nim'   => $request->input('nim', ''),
                    'prodi' => 'Teknik Informatika'
                ];
            }
        }

        $validated['data_mahasiswa'] = $mahasiswa;
        $validated['data_dosen'] = $dosen;
        $validated['tahun'] = !empty($validated['tanggal_sertifikat']) 
            ? Carbon::parse($validated['tanggal_sertifikat'])->year 
            : date('Y');
        $validated['pt'] = 'Universitas Ibnu Sina';
        $validated['status'] = (auth()->check() && in_array(auth()->user()->role, ['superadmin', 'adminbkak']))
            ? ($request->input('status', 'Terverifikasi'))
            : 'Submitted';

        Sertifikasi::create($validated);

        return redirect()->route('sertifikasi.index')
            ->with('success', 'Data Sertifikasi terpadu berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sertifikasi $sertifikasi)
    {
        return view('pages.sertifikasi.show', compact('sertifikasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikasi $sertifikasi)
    {
        $options = $this->getFormOptions();
        return view('pages.sertifikasi.edit', compact('options', 'sertifikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikasi $sertifikasi)
    {
        $validated = $request->validate([
            'level'                   => ['required', 'string'],
            'nama_sertifikasi'        => ['required', 'string', 'max:255'],
            'nama_penyelenggara'      => ['required', 'string', 'max:255'],
            'url_sertifikasi'         => ['nullable', 'url', 'max:255'],
            'link_dokumen_sertifikat' => ['nullable', 'url', 'max:255'],
            'tanggal_sertifikat'      => ['nullable', 'date'],
            'link_foto_kegiatan'      => ['nullable', 'url', 'max:255'],
            'link_dokumen_undangan'   => ['nullable', 'url', 'max:255'],
            'keterangan'              => ['nullable', 'string'],
            'data_mahasiswa'          => ['nullable', 'array'],
            'data_dosen'              => ['nullable', 'array'],
        ], [
            'level.required'              => 'Level wajib dipilih.',
            'nama_sertifikasi.required'   => 'Nama Sertifikasi wajib diisi.',
            'nama_penyelenggara.required' => 'Nama Penyelenggara wajib diisi.',
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

        $sertifikasi->update($validated);

        return redirect()->route('sertifikasi.index')
            ->with('success', 'Data Sertifikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Sertifikasi $sertifikasi)
    {
        $sertifikasi->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data Sertifikasi berhasil dihapus.']);
        }

        return redirect()->route('sertifikasi.index')
            ->with('success', 'Data Sertifikasi berhasil dihapus.');
    }
}
