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
                <div class="sl-form-group" style="margin-bottom:20px;">
                    <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Dirección</label>
                    <input type="text" id="direccion" name="direccion" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;" required>
                </div>
                <div class="sl-form-group" style="margin-bottom:20px;">
                    <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Ciudad</label>
                    <input type="text" id="ciudad" name="ciudad" style="width:100%; border:1px solid #ddd; padding:12px 16px; font-size:13px; outline:none;" required>
                </div>

                <h2 style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px; margin-bottom:24px; margin-top:32px;">DATOS DE PAGO</h2>

                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; letter-spacing:2px; text-transform:uppercase; font-weight:600; display:block; margin-bottom:8px;">Tarjeta</label>
                    <div id="card-element" style="border:1px solid #ddd; padding:12px 16px;"></div>
                    <div id="card-errors" style="color:#c00; font-size:12px; margin-top:8px;"></div>
                </div>

                <button type="submit" id="submit-btn" class="btn-stateless" style="width:100%; padding:16px; font-size:13px;">
                    Pagar ${{ number_format($carrito->total(), 2) }}
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
        style: {
            base: {
                fontSize: '13px',
                fontFamily: 'Inter, sans-serif',
                color: '#000',
            }
        }
    });
    cardElement.mount('#card-element');

    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', async function(e) {
    e.preventDefault();

    if (!confirm('¿Confirmas tu pedido por ${{ number_format($carrito->total(), 2) }}?')) {
        return;
    }
    // ... resto del código

        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.textContent = 'Procesando...';

        const { paymentIntent, error } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
            payment_method: {
                card: cardElement,
            }
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            btn.disabled = false;
            btn.textContent = 'Pagar ${{ number_format($carrito->total(), 2) }}';
        } else {
            const response = await fetch('{{ route("checkout.procesar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    direccion: document.getElementById('direccion').value,
                    ciudad: document.getElementById('ciudad').value,
                    payment_intent_id: paymentIntent.id,
                })
            });

            const data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        }
    });

    
</script>

@endsection