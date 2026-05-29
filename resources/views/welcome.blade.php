@extends('layouts.app')

@section('content')

<!-- HERO -->
<section style="background:#000; color:#fff; min-height:90vh; display:flex; align-items:center; justify-content:center; text-align:center; padding: 60px 40px;">
    <div>
        <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:20px;">Nueva Colección 2025</p>
        <h1 style="font-family:'Bebas Neue', sans-serif; font-size:120px; letter-spacing:10px; line-height:1; margin-bottom:20px;">STATELESS</h1>
        <p style="font-size:14px; letter-spacing:3px; text-transform:uppercase; opacity:0.7; margin-bottom:40px;">Define tu mundo. Sin etiquetas.</p>
        <div style="display:flex; gap:20px; justify-content:center;">
            <a href="#" class="btn-stateless">Ver Essentials</a>
            <a href="#" class="btn-stateless-outline" style="color:#fff; border-color:#fff;">The Chroma Life</a>
        </div>
    </div>
</section>

<!-- SECCIÓN ESSENTIALS -->
<section style="padding: 80px 60px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
        <h2 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px;">ESSENTIAL</h2>
        <a href="#" style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000;">Ver todo</a>
    </div>
    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:30px;">
        @for($i = 0; $i < 3; $i++)
        <div>
            <div style="background:#f2f2f2; aspect-ratio:3/4; margin-bottom:16px;"></div>
            <p style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">Nombre Producto</p>
            <p style="font-size:13px; opacity:0.5;">$100.000</p>
        </div>
        @endfor
    </div>
</section>

<!-- BANNER THE CHROMA LIFE -->
<section style="background:#000; color:#fff; padding:100px 60px; text-align:center;">
    <p style="font-size:12px; letter-spacing:6px; text-transform:uppercase; opacity:0.5; margin-bottom:16px;">Colección</p>
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:72px; letter-spacing:6px; margin-bottom:20px;">¿CUÁL ES TU MUNDO?</h2>
    <p style="font-size:14px; opacity:0.6; margin-bottom:40px; letter-spacing:1px;">Explora The Chroma Life — color, actitud y movimiento.</p>
    <a href="#" class="btn-stateless-outline" style="color:#fff; border-color:#fff;">Explorar colección</a>
</section>

<!-- SECCIÓN THE CHROMA LIFE -->
<section style="padding: 80px 60px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
        <h2 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px;">THE CHROMA LIFE</h2>
        <a href="#" style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#000; text-decoration:none; border-bottom:1px solid #000;">Ver todo</a>
    </div>
    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:30px;">
        @for($i = 0; $i < 3; $i++)
        <div>
            <div style="background:#f2f2f2; aspect-ratio:3/4; margin-bottom:16px;"></div>
            <p style="font-size:13px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">Nombre Producto</p>
            <p style="font-size:13px; opacity:0.5;">$100.000</p>
        </div>
        @endfor
    </div>
</section>

@endsection