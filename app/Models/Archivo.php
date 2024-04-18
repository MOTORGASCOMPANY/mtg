<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivo extends Model
{
    use HasFactory;
    protected $table = 'archivo';

    protected $fillable =
    [
        'nombre',
        'ruta',
        'extension',
        'estado',
        'idDocReferenciado'
    ];

    
    public function anulacion(): BelongsTo
    {
        return $this->belongsTo(Anulacion::class, 'idDocReferenciado');
    }
}
