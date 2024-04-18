<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaDetalle extends Model
{
    use HasFactory;

    protected $table="detallesalida";

    protected $fillable=
    ['id',
    'idSalida',
    'idMaterial',
    'motivo',  
    'estado',
    'grupo', 
    'created_at',
    'updated_at',        
    ];   
}
