<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::with('createdBy')->orderByDesc('created_at')->paginate(10);
        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'lokasi'        => 'required|string|max:255',
            'tanggal'       => 'required|date|after_or_equal:today',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'kuota'         => 'required|integer|min:1|max:10000',
            'biaya'         => 'required|numeric|min:0',
            'penyelenggara' => 'required|string|max:255',
            'status'        => 'required|in:aktif,nonaktif,selesai',
        ]);

        $validated['created_by'] = auth()->id();
        $kegiatan = Kegiatan::create($validated);

        ActivityLog::record('kegiatan_created', 'Kegiatan baru dibuat: ' . $kegiatan->nama, null, Kegiatan::class, $kegiatan->id);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load(['pendaftarans.user', 'createdBy']);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'lokasi'        => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'kuota'         => 'required|integer|min:1|max:10000',
            'biaya'         => 'required|numeric|min:0',
            'penyelenggara' => 'required|string|max:255',
            'status'        => 'required|in:aktif,nonaktif,selesai',
        ]);

        $kegiatan->update($validated);

        ActivityLog::record('kegiatan_updated', 'Kegiatan diperbarui: ' . $kegiatan->nama, null, Kegiatan::class, $kegiatan->id);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $nama = $kegiatan->nama;
        $id   = $kegiatan->id;
        $kegiatan->delete();

        ActivityLog::record('kegiatan_deleted', 'Kegiatan dihapus: ' . $nama, null, Kegiatan::class, $id);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
