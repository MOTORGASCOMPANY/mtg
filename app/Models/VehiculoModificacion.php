<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoModificacion extends Model
{
    use HasFactory;
    protected $table="vehiculo_modificacion";

    public $fillable=[
        "id",
        "idVehiculo",
        "idModificacion",
    ];
}
