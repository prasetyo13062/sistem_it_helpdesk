<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh akun pegawai.
     */
    public function index(Request $request): View
    {
        $departments = Department::orderBy('name')->get();

        $query = User::with('department')
            ->where('role', 'pegawai');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->withCount('tickets')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPegawai = User::where('role', 'pegawai')->count();

        return view('it.users.index', compact('users', 'departments', 'totalPegawai'));
    }

    /**
     * Tampilkan formulir pembuatan akun pegawai baru.
     */
    public function create(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('it.users.create', compact('departments'));
    }

    /**
     * Simpan akun pegawai baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'department_id' => [
                'required',
                'exists:departments,id',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Nama lengkap pegawai wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'department_id.exists' => 'Departemen yang dipilih tidak valid.',
            'password.required' => 'Password akun wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'department_id' => $validated['department_id'],
            'role' => 'pegawai',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('it.users.index')
            ->with('success', 'Akun pegawai atas nama ' . $validated['name'] . ' berhasil dibuat.');
    }

    /**
     * Hapus akun pegawai.
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::where('role', 'pegawai')->findOrFail($id);

        $name = $user->name;
        $user->delete();

        return back()->with('success', 'Akun pegawai ' . $name . ' berhasil dihapus.');
    }
}
