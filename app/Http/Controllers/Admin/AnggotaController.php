<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    private const ROLES = ['ipb', 'umum'];

    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $anggota = User::query()
            ->whereIn('role', self::ROLES)
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(in_array($role, self::ROLES, true), fn ($query) => $query->where('role', $role))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalAnggota = User::whereIn('role', self::ROLES)->count();

        return view('admin.anggota', compact('anggota', 'search', 'role', 'totalAnggota'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(self::ROLES)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($validated);

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, User $anggota)
    {
        abort_if($anggota->role === 'admin', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($anggota->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($anggota->id)],
            'role' => ['required', Rule::in(self::ROLES)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $anggota->update($validated);

        return back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $anggota)
    {
        abort_if($anggota->role === 'admin', 404);

        $anggota->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }
}
