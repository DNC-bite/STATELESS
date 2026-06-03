<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    use HasFactory;

    protected $fillable = ['carrito_id', 'producto_id', 'cantidad', 'precio_unitario'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function subtotal()
    {
        return $this->precio_unitario * $this->cantidad;
    }
}