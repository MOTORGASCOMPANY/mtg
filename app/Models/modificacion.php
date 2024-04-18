<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modificacion extends Model
{
    use HasFactory;
    protected $table="modificacion";

    public $fillable=[
        "id",
        "direccion",
        "chasis",
        "carroceria",
        "potencia",
        "rodante",
        "rectificacion",
        "carga",
    ];

    //vamos a probar

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'vehiculo_modificacion', 'idModificacion', 'idVehiculo');
    }
}
