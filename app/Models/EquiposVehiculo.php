<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquiposVehiculo extends Model
{
    use HasFactory;

    protected $table="equiposvehiculo";

    public $fillable=["id","idVehiculo","idEquipo"];

}
