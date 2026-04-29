<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    //  SHOW LOGIN FORM
    // ─────────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // ─────────────────────────────────────────
    //  PROCESS LOGIN (with brute force protection)
    // ─────────────────────────────────────────
    public function login(Request $request)
    {
        // Rate limiting: max 5 attempts per minute
        $key = 'login_attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."]);
        }

        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        RateLimiter::hit($key, 60); // 1 minute window

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($key); // Clear on success
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    // ─────────────────────────────────────────
    //  SHOW REGISTER FORM
    // ─────────────────────────────────────────
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    // ─────────────────────────────────────────
    //  PROCESS REGISTER (with strong password)
    // ─────────────────────────────────────────
    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'alamat'   => 'nullable|string|max:500',
        'password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->mixedCase()
                ->numbers(),
        ],
    ], [
        'email.unique'       => 'Email sudah terdaftar.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'password.min'       => 'Password minimal 8 karakter.',
        'password.mixed_case' => 'Password harus mengandung huruf besar dan huruf kecil.',
        'password.numbers'   => 'Password harus mengandung setidaknya 1 angka.',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'alamat'   => $request->alamat,
        'password' => Hash::make($request->password),
        'role'     => 'anggota',
        'status'   => 'aktif',
    ]);

    return redirect()->route('login')
        ->with('success', 'Pendaftaran berhasil! Silakan login dengan akun yang baru dibuat.');
}

    // ─────────────────────────────────────────
    //  LOGOUT
    // ─────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda berhasil keluar.');
    }
}