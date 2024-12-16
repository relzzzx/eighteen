<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:users|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:AKL,MP,BR,BD,ULW,RPL',
            'phone' => 'required|string|max:15',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'phone' => $request->phone,
            'role' => 'user',
        ]);

        // Event dan login user
        event(new Registered($user));
        Auth::login($user);

        // Redirect ke halaman dashboard atau lainnya
        return redirect(route('dashboard'));
    }
}
