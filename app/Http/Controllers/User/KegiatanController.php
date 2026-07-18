<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::where('status', 'aktif')
            ->orderBy('tanggal')
            ->paginate(9);

        return view('user.kegiatan.index', compact('kegiatans'));
    }

    public function show(Kegiatan $kegiatan)
    {
        // Cek apakah user sudah mendaftar
        $sudahDaftar = $kegiatan->pendaftarans()
            ->where('user_id', auth()->id())
            ->exists();

        $kegiatan->load('createdBy');

        return view('user.kegiatan.show', compact('kegiatan', 'sudahDaftar'));
    }
}
