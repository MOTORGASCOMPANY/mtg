<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duplicado extends Model
{
    use HasFactory;

    protected $table="duplicado";

    public $fillable=[
        "id",
        "taller",
        "fecha",
        "servicio",
        "externo",
        "idAnterior",
    ];


    //para euplicados externos glp nombre y direccion
    public function Taller()
    {
        return $this->belongsTo(Taller::class, 'taller');
    }


}
