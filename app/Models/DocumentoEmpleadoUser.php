<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoEmpleadoUser extends Model
{
    use HasFactory;

    protected $table="documentoempleado_user";

    public $fillable=[
        "idDocumentoEmpleado",
        "idUser",
        "estado",
    ];
}
