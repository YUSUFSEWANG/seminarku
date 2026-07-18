<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'kegiatan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kegiatan_id')) {
            $query->where('kegiatan_id', $request->kegiatan_id);
        }

        $pendaftarans = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['user', 'kegiatan']);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function konfirmasi(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status !== 'pending') {
            return back()->withErrors(['error' => 'Pendaftaran tidak dalam status pending.']);
        }

        // Cek kuota sebelum konfirmasi
        if ($pendaftaran->kegiatan->isFull()) {
            return back()->withErrors(['error' => 'Kuota kegiatan sudah penuh.']);
        }

        $pendaftaran->update(['status' => 'dikonfirmasi']);

        ActivityLog::record(
            'pendaftaran_confirmed',
            "Pendaftaran {$pendaftaran->nomor_pendaftaran} dikonfirmasi",
            null, Pendaftaran::class, $pendaftaran->id
        );

        return back()->with('success', 'Pendaftaran berhasil dikonfirmasi.');
    }

    public function tolak(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->status === 'dibatalkan') {
            return back()->withErrors(['error' => 'Pendaftaran sudah dibatalkan.']);
        }

        $pendaftaran->update(['status' => 'dibatalkan']);

        ActivityLog::record(
            'pendaftaran_rejected',
            "Pendaftaran {$pendaftaran->nomor_pendaftaran} ditolak/dibatalkan oleh admin",
            null, Pendaftaran::class, $pendaftaran->id
        );

        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
