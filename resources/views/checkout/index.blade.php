@extends('layouts.app')

@section('content')
<section style="padding: 60px; max-width: 1000px; margin: 0 auto;">

    <h1 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px; margin-bottom:8px;">CHECKOUT</h1>
    <p style="font-size:13px; opacity:0.5; letter-spacing:1px; margin-bottom:40px;">Completa tu pedido</p>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:60px;">

        <!-- FORMULARIO -->
        <div>
            <h2 style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:24px;">DATOS DE ENVÍO</h2>

            <form id="checkout-form">
                @csrf
                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Dirección</label>
                    <input type="text" id="direccion" name="direccion" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;" required>
                </div>
                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;" required>
                </div>

                <h2 style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:24px; margin-top:32px;">MÉTODO DE PAGO</h2>

                <!-- Opciones de pago -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:24px;">
                    <label id="opt-tarjeta" onclick="seleccionarMetodo('tarjeta')" style="border:2px solid #000; padding:16px; cursor:pointer; text-align:center;">
                        <p style="font-size:20px; margin-bottom:4px;">💳</p>
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">Tarjeta</p>
                        <p style="font-size:10px; opacity:0.5;">Débito / Crédito</p>
                    </label>
                    <label id="opt-nequi" onclick="seleccionarMetodo('nequi')" style="border:1px solid #ddd; padding:16px; cursor:pointer; text-align:center;">
                        <p style="font-size:20px; margin-bottom:4px;">📱</p>
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">Nequi</p>
                        <p style="font-size:10px; opacity:0.5;">Pago móvil</p>
                    </label>
                    <label id="opt-pse" onclick="seleccionarMetodo('pse')" style="border:1px solid #ddd; padding:16px; cursor:pointer; text-align:center;">
                        <p style="font-size:20px; margin-bottom:4px;">🏦</p>
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">PSE</p>
                        <p style="font-size:10px; opacity:0.5;">Débito bancario</p>
                    </label>
                    <label id="opt-efecty" onclick="seleccionarMetodo('efecty')" style="border:1px solid #ddd; padding:16px; cursor:pointer; text-align:center;">
                        <p style="font-size:20px; margin-bottom:4px;">💵</p>
                        <p style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600;">Efecty</p>
                        <p style="font-size:10px; opacity:0.5;">Pago en efectivo</p>
                    </label>
                </div>

                <!-- Panel Tarjeta -->
                <div id="panel-tarjeta">
                    <div style="margin-bottom:16px;">
                        <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Datos de tarjeta</label>
                        <div id="card-element" style="border:1px solid #ddd; padding:12px 16px;"></div>
                        <div id="card-errors" style="color:#c00; font-size:12px; margin-top:8px;"></div>
                    </div>
                </div>

                <!-- Panel Nequi -->
                <div id="panel-nequi" style="display:none;">
                    <div style="background:#f9f9f9; border:1px solid #eee; padding:20px; margin-bottom:16px;">
                        <p style="font-size:13px; font-weight:600; margin-bottom:8px;">Pagar con Nequi</p>
                        <input type="tel" id="telefono-nequi" placeholder="Número de celular Nequi" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;">
                        <p style="font-size:11px; opacity:0.5; margin-top:8px;">Recibirás una notificación en tu app Nequi</p>
                    </div>
                </div>

                <!-- Panel PSE -->
                <div id="panel-pse" style="display:none;">
                    <div style="background:#f9f9f9; border:1px solid #eee; padding:20px; margin-bottom:16px;">
                        <p style="font-size:13px; font-weight:600; margin-bottom:8px;">Pagar con PSE</p>
                        <select style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none; margin-bottom:8px;">
                            <option>Selecciona tu banco</option>
                            <option>Bancolombia</option>
                            <option>Banco de Bogotá</option>
                            <option>Davivienda</option>
                            <option>BBVA</option>
                            <option>Banco Popular</option>
                            <option>Scotiabank Colpatria</option>
                        </select>
                        <p style="font-size:11px; opacity:0.5;">Serás redirigido al portal de tu banco</p>
                    </div>
                </div>

                <!-- Panel Efecty -->
                <div id="panel-efecty" style="display:none;">
                    <div style="background:#f9f9f9; border:1px solid #eee; padding:20px; margin-bottom:16px;">
                        <p style="font-size:13px; font-weight:600; margin-bottom:8px;">Pagar con Efecty</p>
                        <p style="font-size:13px; opacity:0.7; margin-bottom:8px;">Recibirás un código de pago para realizar en cualquier punto Efecty.</p>
                        <p style="font-size:12px; opacity:0.5;">Tienes 48 horas para realizar el pago.</p>
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="btn-stateless" style="width:100%; padding:16px; font-size:13px;">
                    Pagar ${{ number_format($carrito->total(), 2) }} COP
                </button>
            </form>
        </div>

        <!-- RESUMEN -->
        <div>
            <h2 style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:24px;">RESUMEN</h2>
            @foreach($carrito->items as $item)
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #eee;">
                <div>
                    <p style="font-size:13px; font-weight:600;">{{ $item->producto->nombre }}</p>
                    <p style="font-size:12px; opacity:0.5;">Cantidad: {{ $item->cantidad }}</p>
                </div>
                <p style="font-size:13px; font-weight:600;">${{ number_format($item->subtotal(), 2) }}</p>
            </div>
            @endforeach
            <div style="display:flex; justify-content:space-between; padding:20px 0; border-top:2px solid #000; margin-top:8px;">
                <p style="font-family:'Bebas Neue', sans-serif; font-size:20px; letter-spacing:2px;">TOTAL</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:20px;">${{ number_format($carrito->total(), 2) }}</p>
            </div>
        </div>

    </div>
</section>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: { base: { fontSize: '13px', fontFamily: 'Inter, sans-serif', color: '#000' } }
    });
    cardElement.mount('#card-element');

    cardElement.on('change', function(event) {
        document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
    });

    let metodoSeleccionado = 'tarjeta';

    function seleccionarMetodo(metodo) {
        metodoSeleccionado = metodo;
        const opciones = ['tarjeta', 'nequi', 'pse', 'efecty'];
        opciones.forEach(op => {
            document.getElementById('opt-' + op).style.border = op === metodo ? '2px solid #000' : '1px solid #ddd';
            document.getElementById('panel-' + op).style.display = op === metodo ? 'block' : 'none';
        });
    }

    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!confirm('¿Confirmas tu pedido por ${{ number_format($carrito->total(), 2) }} COP?')) return;

        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.textContent = 'Procesando...';

        if (metodoSeleccionado === 'tarjeta') {
            const { paymentIntent, error } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                payment_method: { card: cardElement }
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                btn.disabled = false;
                btn.textContent = 'Pagar ${{ number_format($carrito->total(), 2) }} COP';
                return;
            }

            await procesarPedido(paymentIntent.id, metodoSeleccionado);
        } else {
            // Para Nequi, PSE y Efecty — simular pago exitoso
            await procesarPedido('sim_' + Date.now(), metodoSeleccionado);
        }
    });

    async function procesarPedido(paymentIntentId, metodo) {
        const response = await fetch('{{ route("checkout.procesar") }}', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                direccion: document.getElementById('direccion').value,
                ciudad: document.getElementById('ciudad').value,
                payment_intent_id: paymentIntentId,
                metodo_pago: metodo,
            })
        });

        const data = await response.json();
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    }
</script>

@endsection