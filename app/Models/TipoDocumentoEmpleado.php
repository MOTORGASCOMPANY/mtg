<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentoEmpleado extends Model
{
    use HasFactory;

    protected $table="tipodocumentoempleado";

    public $fillable = [
        'nombreTipo',
    ];

    public function documentos()
    {
        return $this->hasMany(DocumentoEmpleado::class, 'tipoDocumento');
    }

}
