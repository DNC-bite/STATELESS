@extends('layouts.admin')

@section('page-title', 'VENTAS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Editar Venta</h2>
    <a href="{{ route('ventas.index') }}" class="btn-sl-outline">← Volver</a>
</div>

@if($errors->any())
    <div style="background:#fff0f0; border:1px solid #c00; padding:12px 20px; margin-bottom:24px; font-size:13px;">
        <ul style="margin:0; padding-left:16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="background:#fff; border:1px solid #eee; padding:32px; max-width:600px;">
    <form action="{{ route('ventas.update', $venta) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="sl-form-group">
            <label class="sl-label">Tipo de Venta</label>
            <select name="tipo_venta" class="sl-input" required>
                <option value="fisica" {{ $venta->tipo_venta == 'fisica' ? 'selected' : '' }}>Física</option>
                <option value="online" {{ $venta->tipo_venta == 'online' ? 'selected' : '' }}>Online</option>
            </select>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Método de Pago</label>
            <select name="metodo_pa