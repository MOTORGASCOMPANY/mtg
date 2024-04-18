<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    protected $table="tipodocumento";

    public $fillable=[
        "nombreTipo",
        "intervaloValides",
        "estado",
    ];

    //relacion para reporte de documentos vencidos
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'tipoDocumento');
    }
}
