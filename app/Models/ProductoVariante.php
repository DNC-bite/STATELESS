<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoVariante extends Model
{
    protected $table = 'producto_variantes';

    protected $fillable = [
        'producto_id',
        'color',
        'hex',
        'imagen',
        'stock_actual',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}