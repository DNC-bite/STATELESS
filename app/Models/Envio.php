<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $fillable = ['venta_id', 'fecha_envio', 'direccion', 'ciudad', 'estado'];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}