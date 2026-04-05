<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register_gudep');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'gudep',
            'permissions' => ['gudep', 'posts'], // Auto-assign gudep and posts permission
            'is_admin' => false,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Berhasil! Akun Anda sudah aktif sebagai Operator Gudep. Silakan login.');
    }
}
