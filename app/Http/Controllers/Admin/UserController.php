<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->orderByDesc('created_at')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
            'password'    => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'role'        => 'required|in:admin,user',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        ActivityLog::record('user_created', 'Akun baru dibuat oleh admin: ' . $user->email, null, User::class, $user->id);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function show(User $user)
    {
        $user->load('pendaftarans.kegiatan');
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
            'role'        => 'required|in:admin,user',
            'is_active'   => 'boolean',
        ]);

        // Cegah admin mennonaktifkan dirinya sendiri
        if ($user->id === auth()->id() && isset($validated['is_active']) && !$validated['is_active']) {
            return back()->withErrors(['is_active' => 'Anda tidak dapat menonaktifkan akun sendiri.']);
        }

        $oldRole = $user->role;
        $user->update($validated);

        if ($oldRole !== $user->role) {
            ActivityLog::record('role_changed', "Hak akses {$user->email} diubah dari {$oldRole} ke {$user->role}", null, User::class, $user->id);
        }

        ActivityLog::record('user_updated', 'Data pengguna diperbarui: ' . $user->email, null, User::class, $user->id);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        $email = $user->email;
        $id    = $user->id;
        $user->delete();

        ActivityLog::record('user_deleted', 'Akun dihapus: ' . $email, null, User::class, $id);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak dapat mengubah status akun sendiri.']);
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::record('user_status_changed', "Akun {$user->email} {$status}", null, User::class, $user->id);

        return back()->with('success', "Akun pengguna berhasil {$status}.");
    }
}
