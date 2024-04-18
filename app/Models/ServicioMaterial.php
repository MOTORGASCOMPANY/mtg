<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioMaterial extends Model
{
    use HasFactory;

    protected $table="serviciomaterial";

    public $fillable=[
        "id",
        "idCertificacion",
        "idMaterial",        
    ];


    
}
