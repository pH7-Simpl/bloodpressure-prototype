<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Common login view for all roles
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string',
            'nik' => 'required|numeric',
        ]);

        // Check if Pasien exists
        $pasien = Pasien::where('nama', $request->name)->where('nik', $request->nik)->first();

        if ($pasien) {
            // Login Pasien (no password needed)
            Auth::guard('pasien')->login($pasien);
            return redirect()->route('pasien.home');
        }

        // Check if Dokter exists
        $dokter = Dokter::where('nama', $request->name)
        ->where('nik', $request->nik)
        ->first();

        if ($dokter) {
            // Pass user and role to the view for password modal
            return view('auth.password', [
                'user' => $dokter, 
                'role' => 'dokter'
            ]);
        }

        // Check if Kader exists
        $kader = Kader::where('nama', $request->name)
        ->where('nik', $request->nik)
        ->first();

        if ($kader) {
            // Pass user and role to the view for password modal
            return view('auth.password', [
                'user' => $kader, 
                'role' => 'kader'
            ]);
        }

        // If no match found
        return redirect()->back()->with('error', 'No user found with that name and NIK');
    }

    public function authenticate(Request $request)
    {
        // Validate the password
        $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the user is Dokter
        if ($request->role == 'dokter') {
            $user = Dokter::find($request->user_id);
            $guard = 'dokter';
        }
        // Check if the user is Kader
        else {
            $user = Kader::find($request->user_id);
            $guard = 'kader';
        }

        // Authenticate user
        if (Auth::guard($guard)->attempt(['nik' => $user->nik, 'password' => $request->password])) {
            // Redirect based on role
            return redirect()->route($request->role . '.dashboard');
        }

        // If password incorrect
        return redirect()->route('login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'golongan_darah' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'kecamatan' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed', // Password for Dokter and Kader only
        ]);

        // Create the user based on the role
        if ($request->role == 'dokter') {
            Dokter::create([
                'nama' => $request->name,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'golongan_darah' => $request->golongan_darah,
                'no_handphone' => $request->no_hp,
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kab_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('dokter.dashboard');
        } elseif ($request->role == 'kader') {
            Kader::create([
                'nama' => $request->name,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'golongan_darah' => $request->golongan_darah,
                'no_handphone' => $request->no_hp,
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kab_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('kader.dashboard');
        } else {
            Pasien::create([
                'nama' => $request->name,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'golongan_darah' => $request->golongan_darah,
                'no_handphone' => $request->no_hp,
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kab_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'email' => $request->email,
            ]);
            return redirect()->route('pasien.home');
        }
    }

    public function logout()
    {
        Auth::logout();
        Auth::guard('pasien')->logout();
        Auth::guard('dokter')->logout();
        Auth::guard('kader')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
