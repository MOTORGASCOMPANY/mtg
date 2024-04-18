<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesmontesImportados extends Model
{
    use HasFactory;

    public $fillable=[
        'placa',
        'serie',
        'certificador',
        'taller',
        'fecha',
        'estado',
        'tipoServicio',
        'precio',
        'otro',
    ];
}
