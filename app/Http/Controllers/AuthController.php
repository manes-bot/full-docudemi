<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman/form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login (Alumni via NIS/NISN atau Email, Petugas via Email).
     */
    public function login(Request $request)
    {
        $request->validate([
            'identity'  => 'required|string',
            'password'  => 'required|string',
            'role_type' => 'nullable|string|in:alumni,petugas', // <--- Dikembalikan ke role: 'petugas'
        ], [
            'identity.required' => 'Email atau NIS/NISN wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identity = trim($request->identity);
        $password = $request->password;
        $roleType = $request->input('role_type', 'alumni'); // Default alumni jika tidak ada

        // =========================================================
        // 1. PROSES LOGIN KHUSUS TAB PETUGAS KURIKULUM
        // =========================================================
        if ($roleType === 'petugas') {
            // Petugas WAJIB login pakai Email resmi (bukan NISN)
            if (!filter_var($identity, FILTER_VALIDATE_EMAIL)) {
                return back()->withErrors([
                    'identity' => 'Login Petugas wajib menggunakan Email resmi (bukan NISN)!',
                ])->onlyInput('identity');
            }

            // Cari user dengan email & role wajib 'petugas'
            $user = User::where('email', $identity)
                ->where('role', 'petugas')
                ->first();

            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();

                return redirect()->intended(route('petugas.dashboard'));
            }

            return back()->withErrors([
                'identity' => 'Email/Password salah atau Anda bukan akun Petugas.',
            ])->onlyInput('identity');
        }

        // =========================================================
        // 2. PROSES LOGIN KHUSUS TAB ALUMNI (Via NIS/NISN atau Email)
        // =========================================================
        // A. Coba cari alumni via NIS/NISN
        $alumni = Alumni::where('nis_nisn', $identity)->first();

        if ($alumni) {
            $user = User::where('email', $alumni->email)
                ->where('role', 'alumni')
                ->first();

            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();

                return redirect()->intended(route('alumni.dashboard'));
            }
        }

        // B. Coba cari alumni via Email
        $user = User::where('email', $identity)
            ->where('role', 'alumni')
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(route('alumni.dashboard'));
        }

        return back()->withErrors([
            'identity' => 'Kredensial Alumni tidak cocok dengan data kami.',
        ])->onlyInput('identity');
    }

    /**
     * Menampilkan halaman register Alumni.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses pendaftaran Alumni baru.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email',
            'nis_nisn'    => 'required|string|max:30|unique:alumnis,nis_nisn',
            'no_hp'       => 'required|string|max:20',
            'tahun_lulus' => 'required|integer',
            'jurusan'     => 'required|string|max:100',
            'password'    => 'required|string|min:6|confirmed',
        ], [
            'nis_nisn.unique'    => 'NIS/NISN ini sudah terdaftar.',
            'email.unique'       => 'Email ini sudah digunakan.',
            'jurusan.required'   => 'Pilih jurusan Anda.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'alumni',
        ]);

        Alumni::create([
            'user_id'     => $user->id,
            'nama'        => $data['name'],
            'email'       => $data['email'],
            'nis_nisn'    => $data['nis_nisn'],
            'no_hp'       => $data['no_hp'],
            'tahun_lulus' => $data['tahun_lulus'],
            'jurusan'     => $data['jurusan'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('alumni.dashboard')->with('success', 'Pendaftaran akun Alumni berhasil!');
    }

    /**
     * Memproses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}