<?php

namespace App\Http\Controllers;

use App\DataTables\RekognisiDataTable;
use App\Models\Rekognisi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekognisiController extends Controller
{
    /**
     * Helper to get dropdown options for Rekognisi
     */
    private function getFormOptions(): array
    {
        return [
            'levels' => [
                'Provinsi'      => 'Provinsi',
                'Nasional'      => 'Nasional',
                'Internasional' => 'Internasional',
            ],
            'jenises' => [
                'Juri / Dewan Hakim'            => 'Juri / Dewan Hakim',
                'Narasumber / Keynote Speaker'  => 'Narasumber / Keynote Speaker',
                'Visiting Professor / Lecturer' => 'Visiting Professor / Lecturer',
                'Wasit'                         => 'Wasit',
                'Editor / Reviewer Jurnal'      => 'Editor / Reviewer Jurnal',
                'Lainnya'                       => 'Lainnya',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(RekognisiDataTable $dataTable)
    {
        return $dataTable->render('pages.rekognisi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $rekognisi = new Rekognisi();
        return view('pages.rekognisi.create', compact('options', 'rekognisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'level'                   => ['required', 'string'],
            'nama_rekognisi'          => ['required', 'string', 'max:255'],
            'jenis'                   => ['required', 'string'],
            'nama_penyelenggara'      => ['required', 'string', 'max:255'],
            'url_rekognisi'           => ['nullable', 'url', 'max:255'],
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
            'level.required'            => 'Level wajib dipilih.',
            'nama_rekognisi.required'   => 'Nama Rekognisi wajib diisi.',
            'jenis.required'            => 'Jenis wajib dipilih.',
            'nama_penyelenggara.required' => 'Nama Penyelenggara/Mitra wajib diisi.',
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

        Rekognisi::create($validated);

        return redirect()->route('rekognisi.index')
            ->with('success', 'Data Rekognisi terpadu berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rekognisi $rekognisi)
    {
        return view('pages.rekognisi.show', compact('rekognisi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rekognisi $rekognisi)
    {
        $options = $this->getFormOptions();
        return view('pages.rekognisi.edit', compact('options', 'rekognisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rekognisi $rekognisi)
    {
        $validated = $request->validate([
            'level'                   => ['required', 'string'],
            'nama_rekognisi'          => ['required', 'string', 'max:255'],
            'jenis'                   => ['required', 'string'],
            'nama_penyelenggara'      => ['required', 'string', 'max:255'],
            'url_rekognisi'           => ['nullable', 'url', 'max:255'],
            'link_dokumen_sertifikat' => ['nullable', 'url', 'max:255'],
            'tanggal_sertifikat'      => ['nullable', 'date'],
            'link_foto_kegiatan'      => ['nullable', 'url', 'max:255'],
            'link_dokumen_undangan'   => ['nullable', 'url', 'max:255'],
            'keterangan'              => ['nullable', 'string'],
            'data_mahasiswa'          => ['nullable', 'array'],
            'data_dosen'              => ['nullable', 'array'],
        ], [
            'level.required'            => 'Level wajib dipilih.',
            'nama_rekognisi.required'   => 'Nama Rekognisi wajib diisi.',
            'jenis.required'            => 'Jenis wajib dipilih.',
            'nama_penyelenggara.required' => 'Nama Penyelenggara/Mitra wajib diisi.',
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

        $rekognisi->update($validated);

        return redirect()->route('rekognisi.index')
            ->with('success', 'Data Rekognisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Rekognisi $rekognisi)
    {
        $rekognisi->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data Rekognisi berhasil dihapus.']);
        }

        return redirect()->route('rekognisi.index')
            ->with('success', 'Data Rekognisi berhasil dihapus.');
    }
}
