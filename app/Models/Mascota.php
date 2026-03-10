<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
class Mascota extends Model
{
    //
    protected $connection = 'mongodb';
    protected $collection = 'mascotas';

    public $timestamps = true; 
    const UPDATED_AT = 'ultimaActualizacion';

    protected $fillable = [
        'nombre', 
        'especie', 
        'lat', 
        'lng', 
        'bateria',
        'usuario', // Aquí va el ID del dueño (69ac8291...)
        'ultimaActualizacion'
    ];

    // Si quieres que Laravel trate 'ultimaActualizacion' como una fecha real
    protected $casts = [
        'ultimaActualizacion' => 'datetime',
    ];
}
