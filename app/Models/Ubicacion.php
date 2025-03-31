<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';
    protected $fillable = [
        'nombre', 'latitud', 'longitud', 'tipo_id',
        'destacada', 'descripcion', 'estado', 'imagen_destacada'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoUbicacion::class, 'tipo_id');
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenUbicacion::class, 'ubicacion_id');
    }
}
