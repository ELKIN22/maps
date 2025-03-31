<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUbicacion extends Model
{
    use HasFactory;

    protected $table = 'tipos_ubicacion';
    protected $fillable = ['nombre'];

    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'tipo_id');
    }
}