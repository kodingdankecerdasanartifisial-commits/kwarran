<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menambah user.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'role'        => 'required|in:admin,humas,lpk,operator_gudep,dkr',
            'permissions' => 'nullable|array',
        ], [
            'password.min'      => 'Password minimal harus 8 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'email.unique'      => 'Alamat email sudah digunakan oleh user lain.',
            'name.required'     => 'Nama lengkap wajib diisi.',
        ]);

        // Auto-assign gudep permission for operator_gudep role
        $permissions = $request->permissions;
        if ($validated['role'] === 'operator_gudep') {
            $permissions = ['gudep'];
        } elseif ($validated['role'] === 'dkr') {
            $permissions = ['dkr', 'posts'];
        } elseif ($validated['role'] === 'lpk') {
            $permissions = ['lpk'];
        } elseif ($validated['role'] === 'admin') {
            $permissions = array_unique(array_merge($permissions ?? [], ['lpk']));
        }

        \App\Models\User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role'        => $validated['role'],
            'is_admin'    => in_array($validated['role'], ['admin', 'dkr']),
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat mengubah user.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'    => 'nullable|string|min:8|confirmed',
            'role'        => 'required|in:admin,humas,lpk,operator_gudep,dkr',
            'permissions' => 'nullable|array',
        ], [
            'password.min'      => 'Password minimal harus 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'email.unique'      => 'Alamat email sudah digunakan oleh user lain.',
        ]);

        // Auto-assign gudep permission for operator_gudep role
        $permissions = $request->permissions;
        if ($validated['role'] === 'operator_gudep') {
            $permissions = ['gudep'];
        } elseif ($validated['role'] === 'dkr') {
            $permissions = ['dkr', 'posts'];
        } elseif ($validated['role'] === 'lpk') {
            $permissions = ['lpk'];
        } elseif ($validated['role'] === 'admin') {
            $permissions = array_unique(array_merge($permissions ?? [], ['lpk']));
        }

        $data = [
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'role'        => $validated['role'],
            'is_admin'    => in_array($validated['role'], ['admin', 'dkr']),
            'permissions' => $permissions,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(\App\Models\User $user)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus user.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
