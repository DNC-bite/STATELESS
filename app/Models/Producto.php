<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
    'nombre',
    'descripcion',
    'precio',
    'estado',
    'imagen',
    'stock_actual',
    'stock_minimo',
    'stock_maximo',
    'categoria_id',
    'proveedor_id',
];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function imagenes()
{
    return $this->hasMany(ProductoImagen::class)->orderBy('orden');
}
}