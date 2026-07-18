<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_kegiatan'     => Kegiatan::count(),
            'kegiatan_aktif'     => Kegiatan::where('status', 'aktif')->count(),
            'total_pendaftaran'  => Pendaftaran::count(),
            'pending'            => Pendaftaran::where('status', 'pending')->count(),
            'dikonfirmasi'       => Pendaftaran::where('status', 'dikonfirmasi')->count(),
            'total_user'         => User::where('role', 'user')->count(),
        ];

        $recentLogs    = ActivityLog::with('user')->orderByDesc('created_at')->limit(10)->get();
        $recentDaftar  = Pendaftaran::with(['user', 'kegiatan'])->orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentLogs', 'recentDaftar'));
    }
}
