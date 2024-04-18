<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table="equipo";

    public $fillable=[
        "id",
        "idTipoEquipo",
        "numSerie",
        "marca",
        "modelo",
        "capacidad",
        "fechaFab",
        "peso",
        "combustible",
        "created_at",
        "updated_at"
    ];

    public function tipo(){
        return $this->belongsTo(TipoEquipo::class,'idTipoEquipo');
    }

}
