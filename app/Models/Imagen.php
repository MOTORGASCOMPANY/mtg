<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imagen extends Model
{


    use HasFactory;

    protected $table = 'imagenes';

    protected $fillable =
    [
        'nombre',
        'ruta',
        'extension',
        'estado',
        'Expediente_idExpediente',
        'migrado',
    ];

    public function Expediente(): BelongsTo
    {
        return $this->belongsTo(Expediente::class, 'Expediente_idExpediente');
    }
    public function anulacion(): BelongsTo
    {
        return $this->belongsTo(Anulacion::class, 'Expediente_idExpediente');
    }
}
