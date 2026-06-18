@extends('layouts.app')

@section('content')
<section style="min-height:70vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:60px;">
    <div>
        <p style="font-family:'Bebas Neue', sans-serif; font-size:160px; letter-spacing:10px; line-height:1; opacity:0.1;">404</p>
        <h1 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:6px; margin-top:-40px; margin-bottom:16px;">PÁGINA NO ENCONTRADA</h1>
        <p style="font-size:14px; opacity:0.5; letter-spacing:1px; margin-bottom:40px;">Lo que buscas no existe o ha sido movido.</p>
        <a href="{{ url('/') }}" class="btn-stateless">Volver al inicio</a>
    </div>
</section>
@endsection