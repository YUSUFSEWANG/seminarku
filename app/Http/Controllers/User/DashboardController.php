<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $pendaftaranSaya = Pendaftaran::where('user_id', $user->id)
            ->with('kegiatan')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $kegiatanTerbaru = Kegiatan::where('status', 'aktif')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->limit(3)
            ->get();

        $stats = [
            'total_daftar'   => Pendaftaran::where('user_id', $user->id)->count(),
            'dikonfirmasi'   => Pendaftaran::where('user_id', $user->id)->where('status', 'dikonfirmasi')->count(),
            'pending'        => Pendaftaran::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        return view('user.dashboard', compact('pendaftaranSaya', 'kegiatanTerbaru', 'stats'));
    }
}
