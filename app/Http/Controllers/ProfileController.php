<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // =====================================================
    // HALAMAN PROFIL
    // =====================================================

    /**
     * Tampilkan halaman edit profil.
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Perbarui data profil pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi data
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',

            'email.email' => 'Format email tidak valid.',

            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        // Update data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }

    /**
     * Perbarui password pengguna.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => [
                'required',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',

            'password.required' => 'Password baru wajib diisi.',

            'password.min' => 'Password baru minimal 8 karakter.',

            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        // Cek password lama
        if (! Hash::check(
            $validated['current_password'],
            $user->password
        )) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini salah.',
                ])
                ->withInput();
        }

        // Simpan password baru
        $user->password = Hash::make(
            $validated['password']
        );
        $user->save();

        return back()->with(
            'success',
            'Password berhasil diubah.'
        );
    }
}
