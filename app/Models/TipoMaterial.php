<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMaterial extends Model
{
    use HasFactory;

    protected $table="tipomaterial";

    protected $fillable=
    ['id',
    'descripcion',    
    'created_at',
    'updated_at',        
    ];
}
