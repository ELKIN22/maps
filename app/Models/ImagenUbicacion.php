<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenUbicacion extends Model
{
    use HasFactory;

    protected $table = 'imagenes_ubicacion';
    protected $fillable = ['ubicacion_id', 'url', 'orden'];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }
}
