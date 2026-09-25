<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('layouts.auth.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('layouts.auth.register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format alamat email tidak valid.',
            'email.unique'       => 'Email ini telah terdaftar, silakan gunakan email lain atau login.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'      => trim($request->name),
            'email'     => strtolower(trim($request->email)),
            'password'  => Hash::make($request->password),
            'role'      => 'mahasiswa', // Default Role Mahasiswa
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.index')
            ->with('success', 'Pendaftaran berhasil! Selamat datang di SIPENA UIS, ' . $user->name . '.');
    }

    public function authenticate(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return redirect()->back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors(['email' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard.index'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    public function editPassword()
    {
        return view('pages.users.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => $request->password,
        ]);

        return redirect()->back()->with('success', 'Password Anda berhasil diperbarui.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages.users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah terdaftar pada pengguna lain.',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}

