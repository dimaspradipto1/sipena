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
    public function index()
    {
        $stats = [
            'belmawa'    => PrestasiBelmawa::count(),
            'mandiri'    => PrestasiMandiri::count(),
            'rekognisi'  => Rekognisi::count(),
            'sertifikasi'=> Sertifikasi::count(),
            'kejuaraan'  => Kejuaraan::count(),
            'institusi'  => Institusi::count(),
            'users'      => User::count(),
        ];

        $latestBelmawa   = PrestasiBelmawa::latest()->take(5)->get();
        $latestMandiri   = PrestasiMandiri::latest()->take(5)->get();
        $latestKejuaraan = Kejuaraan::latest()->take(5)->get();

        return view('layouts.dashboard.index', compact('stats', 'latestBelmawa', 'latestMandiri', 'latestKejuaraan'));
    }
}
