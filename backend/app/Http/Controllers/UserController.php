<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class UserController extends Controller
{
    public function changeRole(Request $request, $id)
    {
        // Cek apakah user yang login adalah admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Tidak diizinkan'], 403);
        }

        $request->validate([
            'role' => 'required|in:admin,instruktur,siswa'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'message' => 'Role berhasil diperbarui',
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,instruktur,siswa',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat.',
            'user' => $user
        ], 201);
    }

}