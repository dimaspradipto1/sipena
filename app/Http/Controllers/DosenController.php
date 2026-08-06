<?php

namespace App\Http\Controllers;

use App\DataTables\DosenDataTable;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DosenDataTable $dataTable)
    {
        return $dataTable->render('pages.dosen.index');
    }

    /**
     * Form Options
     */
    private function getFormOptions(): array
    {
        return [
            'prodis' => [
                'S2-MAGISTER MANAJEMEN'            => 'S2-MAGISTER MANAJEMEN',
                'S2-KESEHATAN MASYARAKAT'          => 'S2-KESEHATAN MASYARAKAT',
                'S1-AKUNTANSI'                     => 'S1-AKUNTANSI',
                'S1-MANAJEMEN'                     => 'S1-MANAJEMEN',
                'S1-TEKNIK INDUSTRI'               => 'S1-TEKNIK INDUSTRI',
                'S1-TEKNIK INFORMATIKA'            => 'S1-TEKNIK INFORMATIKA',
                'S1-TEKNIK LOGISTIK'               => 'S1-TEKNIK LOGISTIK',
                'S1-SISTEM INFORMASI'              => 'S1-SISTEM INFORMASI',
                'S1-TEKNIK PERKAPALAN'             => 'S1-TEKNIK PERKAPALAN',
                'S1-KESEHATAN DAN KESELAMATAN KERJA' => 'S1-KESEHATAN DAN KESELAMATAN KERJA',
                'S1-KESEHATAN LINGKUNGAN'          => 'S1-KESEHATAN LINGKUNGAN',
            ],
            'statuses' => [
                'Aktif'     => 'Aktif',
                'Non-Aktif' => 'Non-Aktif',
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = $this->getFormOptions();
        $dosen = new Dosen();
        return view('pages.dosen.create', compact('options', 'dosen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn_nuptk'     => ['nullable', 'string', 'max:50'],
            'nama_dosen'     => ['required', 'string', 'max:255'],
            'program_studi' => ['nullable', 'string', 'max:255'],
            'email'          => ['nullable', 'email', 'max:255'],
            'no_hp'          => ['nullable', 'string', 'max:50'],
            'status'         => ['required', 'in:Aktif,Non-Aktif'],
        ], [
            'nama_dosen.required' => 'Nama Dosen wajib diisi.',
            'status.required'     => 'Status dosen wajib dipilih.',
        ]);

        Dosen::create($validated);

        return redirect()->route('dosen.index')
            ->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        return view('pages.dosen.show', compact('dosen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        $options = $this->getFormOptions();
        return view('pages.dosen.edit', compact('options', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nidn_nuptk'     => ['nullable', 'string', 'max:50'],
            'nama_dosen'     => ['required', 'string', 'max:255'],
            'program_studi' => ['nullable', 'string', 'max:255'],
            'email'          => ['nullable', 'email', 'max:255'],
            'no_hp'          => ['nullable', 'string', 'max:50'],
            'status'         => ['required', 'in:Aktif,Non-Aktif'],
        ], [
            'nama_dosen.required' => 'Nama Dosen wajib diisi.',
            'status.required'     => 'Status dosen wajib dipilih.',
        ]);

        $dosen->update($validated);

        return redirect()->route('dosen.index')
            ->with('success', 'Data Dosen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Dosen berhasil dihapus.'
        ]);
    }

    /**
     * Download Official Excel (.xls) Import Template
     */
    public function downloadTemplate()
    {
        $fileName = 'template_import_dosen.xls';

        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <!--[if gte mso 9]>
            <xml>
             <x:ExcelWorkbook>
              <x:ExcelWorksheets>
               <x:ExcelWorksheet>
                <x:Name>Template Import Dosen</x:Name>
                <x:WorksheetOptions>
                 <x:DisplayGridlines/>
                </x:WorksheetOptions>
               </x:ExcelWorksheet>
              </x:ExcelWorksheets>
             </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                th { background-color: #198754; color: #ffffff; font-weight: bold; border: 1px solid #cccccc; padding: 10px; text-align: center; font-family: Arial, sans-serif; }
                td { border: 1px solid #cccccc; padding: 8px; font-family: Arial, sans-serif; }
                .text-format { mso-number-format:"\@"; }
            </style>
        </head>
        <body>
            <table>
                <thead>
                    <tr>
                        <th>NIDN_NUPTK</th>
                        <th>Nama_Dosen</th>
                        <th>Program_Studi</th>
                        <th>Email</th>
                        <th>No_HP</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-format">0012058501</td>
                        <td>Hendra Wijaya, S.T., M.Eng.</td>
                        <td>S1-TEKNIK INFORMATIKA</td>
                        <td>hendra.dosen@uis.ac.id</td>
                        <td class="text-format">081234567801</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td class="text-format">0020038204</td>
                        <td>Maya Indah, S.Kom., M.T.</td>
                        <td>S1-SISTEM INFORMASI</td>
                        <td>maya.dosen@uis.ac.id</td>
                        <td class="text-format">081234567802</td>
                        <td>Aktif</td>
                    </tr>
                </tbody>
            </table>
        </body>
        </html>';

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    /**
     * Import Data Dosen from Excel / CSV File
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx,html', 'max:5120'],
        ], [
            'file.required' => 'File import wajib diunggah.',
            'file.mimes'    => 'Format file harus berupa Excel (.xls, .xlsx) atau CSV (.csv).',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $content = file_get_contents($path);

        $importedCount = 0;
        $updatedCount  = 0;

        // Check if file is HTML/XML Excel format (.xls)
        if (str_contains($content, '<table') || str_contains($content, '<tr')) {
            preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $content, $trMatches);

            $rows = [];
            foreach ($trMatches[1] as $tr) {
                preg_match_all('/<t[dh][^>]*>(.*?)<\/t[dh]>/is', $tr, $tdMatches);
                $row = array_map(function ($cell) {
                    return trim(html_entity_decode(strip_tags($cell), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                }, $tdMatches[1]);

                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            // Skip header row if matches NIDN_NUPTK or Nama_Dosen
            if (!empty($rows) && (str_contains(strtolower($rows[0][0] ?? ''), 'nidn') || str_contains(strtolower($rows[0][1] ?? ''), 'nama'))) {
                array_shift($rows);
            }

            foreach ($rows as $data) {
                if (count($data) < 2 || empty($data[1])) {
                    continue;
                }

                $nidn   = trim($data[0] ?? '');
                $nama   = trim($data[1] ?? '');
                $prodi  = trim($data[2] ?? 'S1-TEKNIK INFORMATIKA');
                $email  = trim($data[3] ?? '');
                $noHp   = trim($data[4] ?? '');
                $status = ucfirst(strtolower(trim($data[5] ?? 'Aktif')));

                if (!in_array($status, ['Aktif', 'Non-Aktif'])) {
                    $status = 'Aktif';
                }

                if (!empty($nama)) {
                    $dosen = Dosen::updateOrCreate(
                        ['nidn_nuptk' => $nidn ?: null, 'nama_dosen' => $nama],
                        [
                            'program_studi' => $prodi,
                            'email'          => $email,
                            'no_hp'          => $noHp,
                            'status'         => $status,
                        ]
                    );

                    if ($dosen->wasRecentlyCreated) {
                        $importedCount++;
                    } else {
                        $updatedCount++;
                    }
                }
            }
        } else {
            // Standard CSV parsing
            if (($handle = fopen($path, 'r')) !== false) {
                $bom = fread($handle, 3);
                if ($bom !== "\xEF\xBB\xBF") {
                    rewind($handle);
                }

                $header = fgetcsv($handle, 1000, ',');
                if ($header && count($header) == 1 && str_contains($header[0], ';')) {
                    rewind($handle);
                    if ($bom === "\xEF\xBB\xBF") {
                        fread($handle, 3);
                    }
                    $header = fgetcsv($handle, 1000, ';');
                    $delimiter = ';';
                } else {
                    $delimiter = ',';
                }

                while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (count($data) < 2 || empty($data[1])) {
                        continue;
                    }

                    $nidn   = trim($data[0] ?? '');
                    $nama   = trim($data[1] ?? '');
                    $prodi  = trim($data[2] ?? 'S1-TEKNIK INFORMATIKA');
                    $email  = trim($data[3] ?? '');
                    $noHp   = trim($data[4] ?? '');
                    $status = ucfirst(strtolower(trim($data[5] ?? 'Aktif')));

                    if (!in_array($status, ['Aktif', 'Non-Aktif'])) {
                        $status = 'Aktif';
                    }

                    if (!empty($nama)) {
                        $dosen = Dosen::updateOrCreate(
                            ['nidn_nuptk' => $nidn ?: null, 'nama_dosen' => $nama],
                            [
                                'program_studi' => $prodi,
                                'email'          => $email,
                                'no_hp'          => $noHp,
                                'status'         => $status,
                            ]
                        );

                        if ($dosen->wasRecentlyCreated) {
                            $importedCount++;
                        } else {
                            $updatedCount++;
                        }
                    }
                }
                fclose($handle);
            }
        }

        return redirect()->route('dosen.index')
            ->with('success', "Import berhasil! {$importedCount} data dosen baru ditambahkan, {$updatedCount} data diperbarui.");
    }
}
