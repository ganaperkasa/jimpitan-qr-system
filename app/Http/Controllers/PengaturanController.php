<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    /** Menu "Lainnya" (semua pengguna). */
    public function index(): View
    {
        return view('lainnya.index');
    }

    public function edit(): View
    {
        return view('lainnya.pengaturan', ['setting' => Setting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_rt' => ['required', 'string', 'max:50'],
            'nama_rw' => ['required', 'string', 'max:50'],
            'desa' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'nominal_default' => ['required', 'integer', 'min:1', 'max:10000000'],
            'nominal_cepat' => ['required', 'string', 'max:100', 'regex:/^\s*\d+(\s*,\s*\d+)*\s*$/'],
        ], [
            'nominal_cepat.regex' => 'Isi nominal cepat dengan angka dipisah koma, misalnya 1000,2000,5000.',
        ]);

        Setting::current()->update($data);

        return back()->with('sukses', 'Pengaturan disimpan.');
    }

    public function petugas(): View
    {
        return view('lainnya.petugas', [
            'daftar' => User::orderByDesc('role')->orderBy('name')->get(),
        ]);
    }

    public function simpanPetugas(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(8)],
        ], [
            'email.unique' => 'Email ini sudah dipakai akun lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        User::create($data + ['role' => 'petugas', 'aktif' => true]);

        return back()->with('sukses', 'Akun petugas dibuat.');
    }

    public function statusPetugas(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('galat', 'Akun yang sedang dipakai tidak dapat dinonaktifkan.');
        }

        $user->update(['aktif' => ! $user->aktif]);

        return back()->with('sukses', $user->aktif ? 'Akun diaktifkan.' : 'Akun dinonaktifkan.');
    }
}
