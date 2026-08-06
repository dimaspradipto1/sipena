<?php

namespace App\Http\Controllers;

use App\Models\Institusi;
use App\Models\Kejuaraan;
use App\Models\PrestasiBelmawa;
use App\Models\PrestasiMandiri;
use App\Models\Rekognisi;
use App\Models\Sertifikasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedTahun = $request->query('tahun', date('Y'));
        $selectedProdi = $request->query('prodi', 'all');
        $selectedJenis = $request->query('jenis', 'all');

        // Master List of Official Prodi at Universitas Ibnu Sina
        $defaultProdis = [
            'S2-MAGISTER MANAJEMEN',
            'S2-KESEHATAN MASYARAKAT',
            'S1-AKUNTANSI',
            'S1-MANAJEMEN',
            'S1-TEKNIK INDUSTRI',
            'S1-TEKNIK INFORMATIKA',
            'S1-TEKNIK LOGISTIK',
            'S1-SISTEM INFORMASI',
            'S1-TEKNIK PERKAPALAN',
            'S1-KESEHATAN DAN KESELAMATAN KERJA',
            'S1-KESEHATAN LINGKUNGAN',
        ];

        // Retrieve all records for memory-efficient mapping & filtering
        $allBelmawa   = PrestasiBelmawa::all();
        $allMandiri   = PrestasiMandiri::all();
        $allRekognisi = Rekognisi::all();
        $allSertifikasi = Sertifikasi::all();
        $allKejuaraan = Kejuaraan::all();

        // Collect available years
        $yearsFromDb = collect()
            ->concat($allBelmawa->pluck('tahun'))
            ->concat($allMandiri->pluck('tahun'))
            ->concat($allRekognisi->pluck('tahun'))
            ->concat($allSertifikasi->pluck('tahun'))
            ->concat($allKejuaraan->pluck('tahun'))
            ->filter()
            ->map(fn($y) => (int) $y)
            ->push((int) date('Y'))
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        $availableYears = $yearsFromDb;

        // Helper to extract prodi from item
        $getProdisFromItem = function ($item, $type) {
            if ($type === 'belmawa') {
                return array_filter([$item->program_studi]);
            }
            $prodis = [];
            if (!empty($item->data_mahasiswa) && is_array($item->data_mahasiswa)) {
                foreach ($item->data_mahasiswa as $mhs) {
                    if (!empty($mhs['prodi'])) {
                        $prodis[] = $mhs['prodi'];
                    }
                }
            }
            return array_unique($prodis);
        };

        // Helper to categorize Academic vs Non-Academic
        $getJenisFromItem = function ($item, $type) {
            if ($type === 'belmawa' || $type === 'sertifikasi' || $type === 'rekognisi') {
                return 'Akademik';
            }
            if ($type === 'mandiri') {
                $kat = strtolower($item->kategori ?? '');
                if (str_contains($kat, 'sains') || str_contains($kat, 'teknologi') || str_contains($kat, 'wirausaha') || str_contains($kat, 'ssi')) {
                    return 'Akademik';
                }
                return 'Non-Akademik';
            }
            return 'Non-Akademik';
        };

        // Helper to check if item belongs to current student (when role == mahasiswa)
        $isForCurrentStudent = function ($item, $type) {
            $user = auth()->user();
            if (!$user || $user->role !== 'mahasiswa') {
                return true;
            }
            $studentName = strtolower(trim($user->name));
            if ($type === 'belmawa') {
                return str_contains(strtolower($item->nama_mahasiswa ?? ''), $studentName);
            }
            if (!empty($item->data_mahasiswa) && is_array($item->data_mahasiswa)) {
                foreach ($item->data_mahasiswa as $mhs) {
                    if (!empty($mhs['nama']) && str_contains(strtolower($mhs['nama']), $studentName)) {
                        return true;
                    }
                }
            }
            return false;
        };

        // Standardized Dataset items
        $dataset = [];

        foreach ($allMandiri as $item) {
            if (!$isForCurrentStudent($item, 'mandiri')) continue;
            $prodis = $getProdisFromItem($item, 'mandiri');
            $jenis  = $getJenisFromItem($item, 'mandiri');
            $dataset[] = [
                'type'   => 'mandiri',
                'tahun'  => (int) ($item->tahun ?? date('Y')),
                'prodis' => !empty($prodis) ? $prodis : ['Teknik Informatika'],
                'jenis'  => $jenis,
                'model'  => $item,
            ];
        }

        foreach ($allBelmawa as $item) {
            if (!$isForCurrentStudent($item, 'belmawa')) continue;
            $prodis = $getProdisFromItem($item, 'belmawa');
            $jenis  = $getJenisFromItem($item, 'belmawa');
            $dataset[] = [
                'type'   => 'belmawa',
                'tahun'  => (int) ($item->tahun ?? date('Y')),
                'prodis' => !empty($prodis) ? $prodis : ['Teknik Informatika'],
                'jenis'  => $jenis,
                'model'  => $item,
            ];
        }

        foreach ($allRekognisi as $item) {
            if (!$isForCurrentStudent($item, 'rekognisi')) continue;
            $prodis = $getProdisFromItem($item, 'rekognisi');
            $jenis  = $getJenisFromItem($item, 'rekognisi');
            $dataset[] = [
                'type'   => 'rekognisi',
                'tahun'  => (int) ($item->tahun ?? date('Y')),
                'prodis' => !empty($prodis) ? $prodis : ['Teknik Informatika'],
                'jenis'  => $jenis,
                'model'  => $item,
            ];
        }

        foreach ($allSertifikasi as $item) {
            if (!$isForCurrentStudent($item, 'sertifikasi')) continue;
            $prodis = $getProdisFromItem($item, 'sertifikasi');
            $jenis  = $getJenisFromItem($item, 'sertifikasi');
            $dataset[] = [
                'type'   => 'sertifikasi',
                'tahun'  => (int) ($item->tahun ?? date('Y')),
                'prodis' => !empty($prodis) ? $prodis : ['Teknik Informatika'],
                'jenis'  => $jenis,
                'model'  => $item,
            ];
        }

        // Apply Active Filters to Dataset
        $filteredDataset = array_filter($dataset, function ($row) use ($selectedTahun, $selectedProdi, $selectedJenis) {
            if ($selectedTahun !== 'all' && (int)$row['tahun'] !== (int)$selectedTahun) {
                return false;
            }
            if ($selectedProdi !== 'all' && !in_array($selectedProdi, $row['prodis'])) {
                return false;
            }
            if ($selectedJenis !== 'all' && strtolower($row['jenis']) !== strtolower($selectedJenis)) {
                return false;
            }
            return true;
        });

        // 1. Statistics Cards
        $stats = [
            'mandiri'     => count(array_filter($filteredDataset, fn($r) => $r['type'] === 'mandiri')),
            'belmawa'     => count(array_filter($filteredDataset, fn($r) => $r['type'] === 'belmawa')),
            'rekognisi'   => count(array_filter($filteredDataset, fn($r) => $r['type'] === 'rekognisi')),
            'sertifikasi' => count(array_filter($filteredDataset, fn($r) => $r['type'] === 'sertifikasi')),
            'kejuaraan'   => $allKejuaraan->count(),
            'institusi'   => Institusi::query()->count(),
            'users'       => User::query()->count(),
        ];

        // 2. Chart per Program Studi
        $prodiCounts = array_fill_keys($defaultProdis, 0);
        foreach ($filteredDataset as $row) {
            foreach ($row['prodis'] as $p) {
                if (isset($prodiCounts[$p])) {
                    $prodiCounts[$p]++;
                } else {
                    $prodiCounts[$p] = 1;
                }
            }
        }
        $chartProdiLabels = array_keys($prodiCounts);
        $chartProdiSeries = array_values($prodiCounts);

        // 3. Chart Akademik vs Non-Akademik
        $akademikCount = count(array_filter($filteredDataset, fn($r) => $r['jenis'] === 'Akademik'));
        $nonAkademikCount = count(array_filter($filteredDataset, fn($r) => $r['jenis'] === 'Non-Akademik'));
        $chartJenisLabels = ['Akademik', 'Non-Akademik'];
        $chartJenisSeries = [$akademikCount, $nonAkademikCount];

        // 4. Chart Tren per Tahun (Use full timeline or filtered timeline)
        $timelineYears = array_reverse($availableYears);
        $chartTahunSeries = [];
        foreach ($timelineYears as $year) {
            $countForYear = count(array_filter($dataset, function ($row) use ($year, $selectedProdi, $selectedJenis) {
                if ((int)$row['tahun'] !== (int)$year) return false;
                if ($selectedProdi !== 'all' && !in_array($selectedProdi, $row['prodis'])) return false;
                if ($selectedJenis !== 'all' && strtolower($row['jenis']) !== strtolower($selectedJenis)) return false;
                return true;
            }));
            $chartTahunSeries[] = $countForYear;
        }

        // Latest Data
        $latestBelmawa   = $allBelmawa->filter(fn($item) => $isForCurrentStudent($item, 'belmawa'))->sortByDesc('created_at')->take(5);
        $latestMandiri   = $allMandiri->filter(fn($item) => $isForCurrentStudent($item, 'mandiri'))->sortByDesc('created_at')->take(5);
        $latestKejuaraan = $allKejuaraan->sortByDesc('created_at')->take(5);

        return view('layouts.dashboard.index', compact(
            'stats',
            'latestBelmawa',
            'latestMandiri',
            'latestKejuaraan',
            'availableYears',
            'defaultProdis',
            'selectedTahun',
            'selectedProdi',
            'selectedJenis',
            'chartProdiLabels',
            'chartProdiSeries',
            'chartJenisLabels',
            'chartJenisSeries',
            'timelineYears',
            'chartTahunSeries'
        ));
    }
}
