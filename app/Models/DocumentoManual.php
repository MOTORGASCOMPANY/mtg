<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoManual extends Model
{
    use HasFactory;

    protected $table = "documentomanual";

    public $fillable = [
        'fechaInicio',
        'fechaExpiracion',
        'extension',
        'ruta',
        'tipomanual_id', 
    ];

    public function tipoManual()
    {
        return $this->belongsTo(TipoManual::class, 'tipomanual_id');
    }

}
