@extends('layouts.admin')

@section('page-title', 'USUARIOS')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn-sl">+ Registrar</a>
</div>

{{-- FILTROS --}}
<form method="GET" action="{{ route('usuarios.index') }}" style="display:flex; gap:12px; margin-bottom:24px; flex-wrap:wrap;">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Buscar por nombre o email..."
        style="padding:10px 16px; border:1px solid #000; font-family:'Inter',sans-serif; font-size:13px; flex:1; min-width:200px;"
    >
    <select
        name="rol"
        style="padding:10px 16px; border:1px solid #000; font-family:'Inter',sans-serif; font-size:13px; min-width:160px;"
    >
        <option value="">Todos los roles</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ request('rol') == $role->id ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn-sl">Filtrar</button>
    @if(request('search') || request('rol'))
        <a href="{{ route('usuarios.index') }}" class="btn-sl-outline">Limpiar</a>
    @endif
</form>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->name ?? '—' }}</td>
            <td style="display:flex; gap:8px;">
                <a href="{{ route('usuarios.edit', $user) }}" class="btn-sl-outline">Editar</a>
                <form action="{{ route('usuarios.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center; opacity:0.5; padding:40px;">
                No hay usuarios {{ request('search') || request('rol') ? 'con esos filtros' : 'registrados' }}.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection