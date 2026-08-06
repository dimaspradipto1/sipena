<?php

namespace App\Http\Controllers;

use App\Models\Kejuaraan;
use App\Models\PrestasiBelmawa;
use App\Models\PrestasiMandiri;
use App\Models\Rekognisi;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    /**
     * Master List of Program Studi
     */
    private function getProdiList(): array
    {
        return [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Industri',
            'Manajemen',
            'Akuntansi',
            'Kesehatan Masyarakat',
            'Farmasi',
            'Teknik Sipil',
        ];
    }

    /**
     * Get Consolidated Dataset with Filters
     */
    private function getConsolidatedData(Request $request): array
    {
        $selectedTahun = $request->query('tahun', 'all');
        $selectedProdi = $request->query('prodi', 'all');
        $selectedJenis = $request->query('jenis', 'all');
        $selectedModul = $request->query('modul', 'all');

        $allBelmawa    = PrestasiBelmawa::all();
        $allMandiri    = PrestasiMandiri::all();
        $allRekognisi  = Rekognisi::all();
        $allSertifikasi= Sertifikasi::all();
        $allKejuaraan  = Kejuaraan::all();

        // Extract available years
        $availableYears = collect()
            ->concat($allBelmawa->pluck('tahun'))
            ->concat($allMandiri->pluck('tahun'))
            ->concat($allRekognisi->pluck('tahun'))
            ->concat($allSertifikasi->pluck('tahun'))
            ->concat($allKejuaraan->pluck('tahun'))
            ->filter()
            ->map(fn($y) => (int)$y)
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        $records = [];

        // 1. Process Belmawa
        if ($selectedModul === 'all' || $selectedModul === 'belmawa') {
            foreach ($allBelmawa as $item) {
                $prodi = $item->program_studi ?? 'Teknik Informatika';
                $tahun = (int)($item->tahun ?? date('Y'));
                $jenis = 'Akademik';
                $level = $item->tingkat ?? 'Nasional';

                $records[] = [
                    'modul'          => 'Prestasi Belmawa',
                    'judul_kegiatan' => $item->nama_lomba,
                    'kategori'       => $item->kategori_lomba ?? 'Kemendikbud',
                    'level'          => $level,
                    'capaian'        => $item->capaian_prestasi,
                    'mahasiswa'      => $item->nama_mahasiswa ?? '-',
                    'nim'            => $item->nim ?? '-',
                    'prodi'          => $prodi,
                    'tahun'          => $tahun,
                    'jenis'          => $jenis,
                    'status'         => $item->status,
                ];
            }
        }

        // 2. Process Prestasi Mandiri
        if ($selectedModul === 'all' || $selectedModul === 'mandiri') {
            foreach ($allMandiri as $item) {
                $tahun = (int)($item->tahun ?? date('Y'));
                $kat   = strtolower($item->kategori ?? '');
                $jenis = (str_contains($kat, 'sains') || str_contains($kat, 'teknologi') || str_contains($kat, 'wirausaha') || str_contains($kat, 'ssi')) ? 'Akademik' : 'Non-Akademik';
                $level = $item->level ?? 'Nasional';

                $mhsList = !empty($item->data_mahasiswa) && is_array($item->data_mahasiswa) ? $item->data_mahasiswa : [];
                $firstMhs = $mhsList[0] ?? [];
                $namaMhs = $firstMhs['nama'] ?? '-';
                $nimMhs  = $firstMhs['nim'] ?? '-';
                $prodiMhs= $firstMhs['prodi'] ?? 'Teknik Informatika';

                $records[] = [
                    'modul'          => 'Prestasi Mandiri',
                    'judul_kegiatan' => $item->nama_kompetisi,
                    'kategori'       => $item->kategori,
                    'level'          => $level,
                    'capaian'        => $item->peringkat,
                    'mahasiswa'      => $namaMhs,
                    'nim'            => $nimMhs,
                    'prodi'          => $prodiMhs,
                    'tahun'          => $tahun,
                    'jenis'          => $jenis,
                    'status'         => $item->status,
                ];
            }
        }

        // 3. Process Rekognisi
        if ($selectedModul === 'all' || $selectedModul === 'rekognisi') {
            foreach ($allRekognisi as $item) {
                $tahun = (int)($item->tahun ?? date('Y'));
                $level = $item->level ?? 'Nasional';

                $mhsList = !empty($item->data_mahasiswa) && is_array($item->data_mahasiswa) ? $item->data_mahasiswa : [];
                $firstMhs = $mhsList[0] ?? [];
                $namaMhs = $firstMhs['nama'] ?? '-';
                $nimMhs  = $firstMhs['nim'] ?? '-';
                $prodiMhs= $firstMhs['prodi'] ?? 'Teknik Informatika';

                $records[] = [
                    'modul'          => 'Rekognisi',
                    'judul_kegiatan' => $item->nama_rekognisi,
                    'kategori'       => $item->jenis,
                    'level'          => $level,
                    'capaian'        => 'Rekognisi ' . $item->jenis,
                    'mahasiswa'      => $namaMhs,
                    'nim'            => $nimMhs,
                    'prodi'          => $prodiMhs,
                    'tahun'          => $tahun,
                    'jenis'          => 'Akademik',
                    'status'         => $item->status,
                ];
            }
        }

        // 4. Process Sertifikasi
        if ($selectedModul === 'all' || $selectedModul === 'sertifikasi') {
            foreach ($allSertifikasi as $item) {
                $tahun = (int)($item->tahun ?? date('Y'));
                $level = $item->level ?? 'Nasional';

                $mhsList = !empty($item->data_mahasiswa) && is_array($item->data_mahasiswa) ? $item->data_mahasiswa : [];
                $firstMhs = $mhsList[0] ?? [];
                $namaMhs = $firstMhs['nama'] ?? '-';
                $nimMhs  = $firstMhs['nim'] ?? '-';
                $prodiMhs= $firstMhs['prodi'] ?? 'Teknik Informatika';

                $records[] = [
                    'modul'          => 'Sertifikasi',
                    'judul_kegiatan' => $item->nama_sertifikasi,
                    'kategori'       => 'Kompetensi Profesi',
                    'level'          => $level,
                    'capaian'        => 'Lulus Sertifikasi',
                    'mahasiswa'      => $namaMhs,
                    'nim'            => $nimMhs,
                    'prodi'          => $prodiMhs,
                    'tahun'          => $tahun,
                    'jenis'          => 'Akademik',
                    'status'         => $item->status,
                ];
            }
        }

        // Filter Dataset
        $user = auth()->user();
        $isMahasiswa = ($user && $user->role === 'mahasiswa');
        $studentName = $user ? strtolower(trim($user->name)) : '';

        $filteredRecords = array_filter($records, function ($row) use ($selectedTahun, $selectedProdi, $selectedJenis, $isMahasiswa, $studentName) {
            if ($isMahasiswa) {
                if (!str_contains(strtolower($row['mahasiswa']), $studentName)) {
                    return false;
                }
            }
            if ($selectedTahun !== 'all' && (int)$row['tahun'] !== (int)$selectedTahun) {
                return false;
            }
            if ($selectedProdi !== 'all' && strtolower($row['prodi']) !== strtolower($selectedProdi)) {
                return false;
            }
            if ($selectedJenis !== 'all' && strtolower($row['jenis']) !== strtolower($selectedJenis)) {
                return false;
            }
            return true;
        });

        // Generate Matrix per Prodi & Level
        $levels = ['Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $matrix = [];
        $prodis = $this->getProdiList();

        foreach ($prodis as $p) {
            $matrix[$p] = [
                'Kabupaten/Kota' => 0,
                'Provinsi'       => 0,
                'Nasional'       => 0,
                'Internasional'  => 0,
                'total'          => 0,
            ];
        }

        foreach ($filteredRecords as $row) {
            $p = $row['prodi'];
            $lvl = $row['level'];

            if (!isset($matrix[$p])) {
                $matrix[$p] = [
                    'Kabupaten/Kota' => 0,
                    'Provinsi'       => 0,
                    'Nasional'       => 0,
                    'Internasional'  => 0,
                    'total'          => 0,
                ];
            }

            if (isset($matrix[$p][$lvl])) {
                $matrix[$p][$lvl]++;
            } else {
                $matrix[$p]['Nasional']++;
            }
            $matrix[$p]['total']++;
        }

        return [
            'availableYears'  => $availableYears,
            'defaultProdis'   => $prodis,
            'selectedTahun'   => $selectedTahun,
            'selectedProdi'   => $selectedProdi,
            'selectedJenis'   => $selectedJenis,
            'selectedModul'   => $selectedModul,
            'filteredRecords' => array_values($filteredRecords),
            'matrix'          => $matrix,
            'totalRecords'    => count($filteredRecords),
        ];
    }

    /**
     * Display Rekapitulasi Dashboard Page
     */
    public function index(Request $request)
    {
        $data = $this->getConsolidatedData($request);
        return view('pages.rekapitulasi.index', $data);
    }

    /**
     * Export Printable Official PDF Laporan
     */
    public function exportPdf(Request $request)
    {
        $data = $this->getConsolidatedData($request);
        $data['printedAt'] = date('d F Y - H:i') . ' WIB';
        return view('pages.rekapitulasi.pdf', $data);
    }

    /**
     * Export Excel (.xls / .csv) Spreadsheet Format
     */
    public function exportExcel(Request $request)
    {
        $data = $this->getConsolidatedData($request);
        $fileName = 'Rekapitulasi_Prestasi_UIS_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        return view('pages.rekapitulasi.excel', $data);
    }
}
