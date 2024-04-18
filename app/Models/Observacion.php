<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'observacion';

    protected $fillable=
    ['id',
    'detalle',
    'tipo',
    'estado',        
    ];
}

