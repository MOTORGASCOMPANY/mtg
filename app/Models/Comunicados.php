<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicados extends Model
{
    use HasFactory;
    protected $table = 'comunicados';

    protected $fillable =
    [
        'titulo',
        'contenido',
        'imagen',
        'activo',
    ];
}
