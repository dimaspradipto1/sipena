<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Shared View Composer for Header Notifications
        \Illuminate\Support\Facades\View::composer('layouts.dashboard.header', function ($view) {
            if (!\Illuminate\Support\Facades\Auth::check()) {
                $view->with('headerNotifications', collect());
                $view->with('headerUnreadCount', 0);
                return;
            }

            $user = \Illuminate\Support\Facades\Auth::user();
            $notifications = collect();

            try {
                $belmawaQuery = \App\Models\PrestasiBelmawa::query();
                $mandiriQuery = \App\Models\PrestasiMandiri::query();
                $rekognisiQuery = \App\Models\Rekognisi::query();
                $sertifikasiQuery = \App\Models\Sertifikasi::query();

                if ($user->role === 'mahasiswa') {
                    $studentName = strtolower(trim($user->name));
                    $belmawaQuery->where('data_mahasiswa', 'LIKE', "%{$studentName}%");
                    $mandiriQuery->where('nama_mahasiswa', 'LIKE', "%{$studentName}%");
                    $rekognisiQuery->where('nama_mahasiswa', 'LIKE', "%{$studentName}%");
                    $sertifikasiQuery->where('nama_mahasiswa', 'LIKE', "%{$studentName}%");
                }

                $belmawas = $belmawaQuery->latest('updated_at')->take(4)->get();
                $mandiris = $mandiriQuery->latest('updated_at')->take(4)->get();
                $rekognisis = $rekognisiQuery->latest('updated_at')->take(4)->get();
                $sertifikasis = $sertifikasiQuery->latest('updated_at')->take(4)->get();

                foreach ($belmawas as $item) {
                    $st = $item->status_skpi ?? $item->status ?? 'Submitted';
                    $notifications->push([
                        'id' => 'b_' . $item->id,
                        'title' => 'Prestasi Belmawa: ' . \Illuminate\Support\Str::limit($item->judul_kegiatan ?? 'Pengajuan Belmawa', 30),
                        'sub' => ($user->role === 'mahasiswa') 
                            ? 'Status pengajuan: ' . $st 
                            : ($item->data_mahasiswa ?? 'Mahasiswa') . ' (' . $st . ')',
                        'status' => $st,
                        'time' => $item->updated_at ? $item->updated_at->diffForHumans() : 'Baru saja',
                        'timestamp' => $item->updated_at ? $item->updated_at->timestamp : 0,
                        'url' => route('prestasi-belmawa.index'),
                    ]);
                }

                foreach ($mandiris as $item) {
                    $st = $item->status ?? 'Submitted';
                    $notifications->push([
                        'id' => 'm_' . $item->id,
                        'title' => 'Prestasi Mandiri: ' . \Illuminate\Support\Str::limit($item->nama_kegiatan ?? 'Pengajuan Mandiri', 30),
                        'sub' => ($user->role === 'mahasiswa') 
                            ? 'Status pengajuan: ' . $st 
                            : ($item->nama_mahasiswa ?? 'Mahasiswa') . ' (' . $st . ')',
                        'status' => $st,
                        'time' => $item->updated_at ? $item->updated_at->diffForHumans() : 'Baru saja',
                        'timestamp' => $item->updated_at ? $item->updated_at->timestamp : 0,
                        'url' => route('prestasi-mandiri.index'),
                    ]);
                }

                foreach ($rekognisis as $item) {
                    $st = $item->status ?? 'Submitted';
                    $notifications->push([
                        'id' => 'r_' . $item->id,
                        'title' => 'Rekognisi: ' . \Illuminate\Support\Str::limit($item->nama_kegiatan ?? 'Pengajuan Rekognisi', 30),
                        'sub' => ($user->role === 'mahasiswa') 
                            ? 'Status pengajuan: ' . $st 
                            : ($item->nama_mahasiswa ?? 'Mahasiswa') . ' (' . $st . ')',
                        'status' => $st,
                        'time' => $item->updated_at ? $item->updated_at->diffForHumans() : 'Baru saja',
                        'timestamp' => $item->updated_at ? $item->updated_at->timestamp : 0,
                        'url' => route('rekognisi.index'),
                    ]);
                }

                foreach ($sertifikasis as $item) {
                    $st = $item->status ?? 'Submitted';
                    $notifications->push([
                        'id' => 's_' . $item->id,
                        'title' => 'Sertifikasi: ' . \Illuminate\Support\Str::limit($item->nama_kegiatan ?? $item->nama_sertifikasi ?? 'Pengajuan Sertifikasi', 30),
                        'sub' => ($user->role === 'mahasiswa') 
                            ? 'Status pengajuan: ' . $st 
                            : ($item->nama_mahasiswa ?? 'Mahasiswa') . ' (' . $st . ')',
                        'status' => $st,
                        'time' => $item->updated_at ? $item->updated_at->diffForHumans() : 'Baru saja',
                        'timestamp' => $item->updated_at ? $item->updated_at->timestamp : 0,
                        'url' => route('sertifikasi.index'),
                    ]);
                }
            } catch (\Throwable $e) {
                // Ignore if tables do not exist during initial migrations
            }

            $sortedNotifications = $notifications->sortByDesc('timestamp')->take(5)->values();

            $view->with('headerNotifications', $sortedNotifications);
            $view->with('headerUnreadCount', $sortedNotifications->count());
        });
    }
}
