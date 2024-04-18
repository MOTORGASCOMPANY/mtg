<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoEmpleado extends Model
{
    use HasFactory;

    protected $table = "documentoempleado";

    public $fillable = [
        "tipoDocumento",
        "fechaInicio",
        "fechaExpiracion",
        "extension",
        "ruta",
    ];

    public function TipoDocumento()
    {
        return $this->belongsTo(TipoDocumentoEmpleado::class, 'tipoDocumento');
    }

    public function Empleado()
    {
        return $this->belongsToMany(ContratoTrabajo::class, 'documentoempleado_user', 'idDocumentoEmpleado', 'idUser');
    }

    public function documentoempleado()
    {
        return $this->hasMany(DocumentoEmpleadoUser::class, 'idDocumentoEmpleado', 'id');
    }
}
