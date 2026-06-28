<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VentaItem;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_venta', 'metodo_pago', 'total', 'user_id', 'codigo_pago', 'estado'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items()
{
    return $this->hasMany(VentaItem::class);
}

    public function envio()
    {
        return $this->hasOne(Envio::class);
    }
}