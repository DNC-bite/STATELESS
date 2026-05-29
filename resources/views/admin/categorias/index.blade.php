@extends('layouts.admin')

@section('page-title', 'CATEGORÍAS')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Categorías</h2>
    <a href="{{ route('categorias.create') }}" class="btn-sl">+ Registrar</a>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categorias as $categoria)
        <tr>
            <td>{{ $categoria->id }}</td>
            <td>{{ $categoria->nombre }}</td>
            <td>{{ $categoria->descripcion ?? '—' }}</td>
            <td>{{ $categoria->estado ? 'Activo' : 'Inactivo' }}</td>
            <td style="display:flex; gap:8px;">
                <a href="{{ route('categorias.edit', $categoria) }}" class="btn-sl-outline">Editar</a>
                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center; opacity:0.5; padding:40px;">No hay categorías registradas.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection