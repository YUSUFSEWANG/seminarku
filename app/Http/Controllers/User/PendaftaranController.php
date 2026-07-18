<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::where('user_id', auth()->id())
            ->with('kegiatan')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.pendaftaran.index', compact('pendaftarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|integer|exists:kegiatans,id',
            'catatan'     => 'nullable|string|max:500',
        ]);

        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);

        // Validasi: kegiatan harus aktif
        if (!$kegiatan->isAktif()) {
            return back()->withErrors(['error' => 'Kegiatan ini tidak lagi tersedia untuk pendaftaran.']);
        }

        // Validasi: cegah pendaftaran ganda
        $sudahDaftar = Pendaftaran::where('user_id', auth()->id())
            ->where('kegiatan_id', $kegiatan->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->withErrors(['error' => 'Anda sudah terdaftar pada kegiatan ini.']);
        }

        // Validasi kuota
        if ($kegiatan->isFull()) {
            return back()->withErrors(['error' => 'Maaf, kuota kegiatan sudah penuh.']);
        }

        // Buat pendaftaran
        $pendaftaran = Pendaftaran::create([
            'user_id'           => auth()->id(),
            'kegiatan_id'       => $kegiatan->id,
            'status'            => 'pending',
            'nomor_pendaftaran' => Pendaftaran::generateNomor(),
            'catatan'           => $request->catatan,
        ]);

        ActivityLog::record(
            'pendaftaran_created',
            "Mendaftar kegiatan: {$kegiatan->nama} | Nomor: {$pendaftaran->nomor_pendaftaran}",
            null, Pendaftaran::class, $pendaftaran->id
        );

        return redirect()->route('user.pendaftaran.index')
            ->with('success', "Pendaftaran berhasil! Nomor pendaftaran Anda: {$pendaftaran->nomor_pendaftaran}");
    }

    public function show(Pendaftaran $pendaftaran)
    {
        // Pastikan pendaftaran milik user yang sedang login (cegah IDOR)
        if ($pendaftaran->user_id !== auth()->id()) {
            ActivityLog::record('access_denied', 'Percobaan akses pendaftaran orang lain: ID ' . $pendaftaran->id);
            abort(403, 'Anda tidak berhak mengakses data ini.');
        }

        $pendaftaran->load('kegiatan');
        return view('user.pendaftaran.show', compact('pendaftaran'));
    }

    public function batalkan(Pendaftaran $pendaftaran)
    {
        // Pastikan pendaftaran milik user yang sedang login (cegah IDOR)
        if ($pendaftaran->user_id !== auth()->id()) {
            ActivityLog::record('access_denied', 'Percobaan pembatalan pendaftaran orang lain: ID ' . $pendaftaran->id);
            abort(403, 'Anda tidak berhak mengakses data ini.');
        }

        // Cegah pembatalan jika sudah dikonfirmasi atau dibatalkan
        if ($pendaftaran->status !== 'pending') {
            return back()->withErrors(['error' => 'Pendaftaran yang sudah dikonfirmasi atau dibatalkan tidak dapat dibatalkan lagi.']);
        }

        $pendaftaran->update(['status' => 'dibatalkan']);

        ActivityLog::record(
            'pendaftaran_cancelled',
            "Membatalkan pendaftaran: {$pendaftaran->nomor_pendaftaran}",
            null, Pendaftaran::class, $pendaftaran->id
        );

        return redirect()->route('user.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
