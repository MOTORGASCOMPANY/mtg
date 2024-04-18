<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    use HasFactory;

    protected $table="detalleingreso";

    protected $fillable=
    ['id',
    'idIngreso',
    'idMaterial',
    'cantidad',  
    'estado',
    'created_at',
    'updated_at',        
    ];

    
}
