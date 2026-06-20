<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OCTANE - STATELESS </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap');

:root{
    --drift-blue:#00e5ff;
    --drift-purple:#8b5cf6;
    --drift-dark:#050505;
    --drift-card:#101010;
    --drift-border:#232323;
    --drift-text:#ffffff;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:
        radial-gradient(
            circle at top,
            rgba(0,229,255,.06),
            transparent 40%
        ),
        #000;
    color:var(--drift-text);
}

/* NAVBAR */

.navbar-stateless{

    background:rgba(0,0,0,.85);

    backdrop-filter:blur(15px);

    border-bottom:1px solid rgba(255,255,255,.08);

    padding:18px 40px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    position:sticky;

    top:0;

    z-index:1000;
}

.sr-only{
    position:absolute;
    width:1px;
    height:1px;
    padding:0;
    margin:-1px;
    overflow:hidden;
    clip:rect(0,0,0,0);
    white-space:nowrap;
    border:0;
}

.navbar-stateless .brand{

    font-family:'Bebas Neue',sans-serif;

    font-size:32px;

    color:var(--drift-blue);

    text-decoration:none;

    letter-spacing:6px;

    transition:.3s;
}

.navbar-stateless .brand:hover{

    text-shadow:
        0 0 10px var(--drift-blue),
        0 0 25px var(--drift-blue);
}

.navbar-stateless .nav-links{

    display:flex;

    gap:35px;

    list-style:none;

    margin:0;
}

.navbar-stateless .nav-links a{

    color:#fff;

    text-decoration:none;

    font-size:13px;

    letter-spacing:2px;

    text-transform:uppercase;

    transition:.3s;
}

.navbar-stateless .nav-links a:hover{

    color:var(--drift-blue);

    text-shadow:0 0 10px var(--drift-blue);
}

.nav-actions{

    display:flex;

    gap:20px;

    align-items:center;
}

.nav-actions a{

    color:#fff;

    text-decoration:none;

    font-size:12px;

    letter-spacing:1px;

    text-transform:uppercase;

    transition:.3s;
}

.nav-actions a:hover{

    color:var(--drift-blue);
}

/* BOTONES */

.btn-stateless{

    background:transparent;

    color:#fff;

    border:1px solid var(--drift-blue);

    padding:10px 28px;

    font-size:12px;

    font-weight:600;

    letter-spacing:2px;

    text-transform:uppercase;

    text-decoration:none;

    transition:.3s;

    display:inline-block;
}

.btn-stateless:hover{

    background:var(--drift-blue);

    color:#000;

    box-shadow:
        0 0 10px var(--drift-blue),
        0 0 25px rgba(0,229,255,.3);
}

.btn-stateless-outline{

    background:transparent;

    color:#fff;

    border:1px solid var(--drift-purple);

    padding:10px 28px;

    font-size:12px;

    font-weight:600;

    letter-spacing:2px;

    text-transform:uppercase;

    text-decoration:none;

    transition:.3s;
}

.btn-stateless-outline:hover{

    background:var(--drift-purple);

    color:#fff;

    box-shadow:
        0 0 10px var(--drift-purple),
        0 0 25px rgba(139,92,246,.3);
}

/* CARRITO */

#carrito-contador{

    background:var(--drift-blue)!important;

    color:#000!important;

    font-weight:700!important;

    box-shadow:
        0 0 10px var(--drift-blue);
}

/* FOOTER */

.footer-stateless{

    margin-top:80px;

    background:#050505;

    border-top:1px solid rgba(255,255,255,.08);

    padding:60px 40px;

    text-align:center;
}

.footer-stateless .brand{

    font-family:'Bebas Neue',sans-serif;

    font-size:42px;

    letter-spacing:8px;

    color:var(--drift-blue);

    margin-bottom:10px;
}

.footer-stateless p{

    font-size:12px;

    opacity:.5;

    letter-spacing:2px;

    text-transform:uppercase;
}

/* SCROLLBAR */

::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-track{
    background:#050505;
}

::-webkit-scrollbar-thumb{
    background:var(--drift-blue);
    border-radius:20px;
}

/* MOBILE */

@media(max-width:900px){

    .navbar-stateless{

        flex-direction:column;

        gap:15px;
    }

    .nav-links{

        flex-wrap:wrap;

        justify-content:center;
    }

}

</style>

</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar-stateless">
        <a href="{{ url('/') }}" class="brand"> STATELESS </a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Inicio</a></li>
            <li><a href="{{ route('essentials') }}">Essentials</a></li>
            <li><a href="{{ route('waves') }}">Waves</a></li>
            <li><a href="{{ route('octane') }}">Octane</a></li>
        </ul>

        <div class="nav-actions">
        @auth
    <a href="{{ route('carrito.index') }}" style="position:relative; display:inline-flex; align-items:center; gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
        </svg>
        @php
            $cantidadCarrito = 0;
            if(Auth::check()) {
                $carritoNav = \App\Models\Carrito::where('user_id', Auth::id())->first();
                $cantidadCarrito = $carritoNav ? $carritoNav->items->sum('cantidad') : 0;
            }
        @endphp
       <span id="carrito-contador" 
    @if($cantidadCarrito > 0) 
        style="border-radius:50%; width:18px; height:18px; font-size:10px; display:flex; align-items:center; justify-content:center; font-weight:700;" 
    @else 
        style="display:none;" 
    @endif>{{ $cantidadCarrito }}</span>
    </a>
    <a href="{{ route('account') }}">Mi Cuenta</a>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" style="background:none; border:none; color:#fff; font-size:12px; letter-spacing:1px; text-transform:uppercase; cursor:pointer; opacity:1;" onmouseover="this.style.opacity=0.6" onmouseout="this.style.opacity=1">Salir</button>
    </form>
@else
    <a href="{{ route('login') }}">Iniciar Sesión</a>
    <a href="{{ route('register') }}" class="btn-stateless">Registrarse</a>
@endauth
        </div>
    </nav>

    <!-- CONTENIDO -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-stateless">
        <div class="brand">STATELESS</div>
        <p>© {{ date('Y') }} STATELESS. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>