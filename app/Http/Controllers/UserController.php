<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
{
    $roles = Role::all();

    $users = User::with('role')
        ->when($request->search, fn($q) =>
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('email', 'like', '%'.$request->search.'%')
        )
        ->when($request->rol, fn($q) =>
            $q->where('role_id', $request->rol)
        )
        ->get();

    return view('admin.usuarios.index', compact('users', 'roles'));
}



    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Si solo viene el estado (desde el botón habilitar/inhabilitar)
    if ($request->has('estado') && !$request->has('name')) {
        $user->estado = $request->estado;
        $user->save();
        return redirect()->route('usuarios.index')->with('success', 'Estado actualizado correctamente.');
    }

    // Actualización completa
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|unique:users,email,' . $user->id,
        'role_id' => 'required|exists:roles,id',
    ]);

    $user->name    = $request->name;
    $user->email   = $request->email;
    $user->role_id = $request->role_id;
    $user->estado  = $request->estado ?? $user->estado;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();
    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}