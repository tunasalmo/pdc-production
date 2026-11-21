<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Tampilkan halaman login ──────────────────────────
    public function showLogin()
    {
        // Kalau sudah login, langsung ke dashboard
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // ── Proses login ─────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Cari user berdasarkan email
        $user = ApUser::where('email', $request->email)->first();

        // Cek user ada dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // Simpan data ke session
        session([
            'admin_logged_in' => true,
            'admin_id'        => $user->id,
            'admin_username'  => $user->username,
            'admin_email'     => $user->email,
            'admin_role'      => $user->role,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Selamat datang, ' . $user->username . '!');
    }

    // ── Logout ───────────────────────────────────────────
    public function logout(Request $request)
    {
        $request->session()->forget([
            'admin_logged_in',
            'admin_id',
            'admin_username',
            'admin_email',
            'admin_role',
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Berhasil logout.');
    }
}
