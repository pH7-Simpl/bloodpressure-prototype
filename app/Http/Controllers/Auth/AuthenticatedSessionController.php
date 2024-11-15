<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function authenticated(Request $request, $user)
    {
        // Redirect based on user role
        if ($user->role === 'pasien') {
            return redirect()->route('pasien.home');
        }

        if ($user->role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        }

        if ($user->role === 'kader') {
            return redirect()->route('kader.dashboard');
        }

        // Default redirect if role is undefined or unexpected
        return redirect('/');
    }
}
