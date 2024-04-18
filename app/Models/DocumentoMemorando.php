<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoMemorando extends Model
{
    use HasFactory;

    protected $table = "documentomemorando";

    protected $fillable =
    [
        'nombre',
        'ruta',
        'extension',
        'estado',
        'idDocReferenciado'
    ];

    
    // Define la relación con el modelo Memorando
    public function memorando(): BelongsTo
    {
        return $this->belongsTo(Memorando::class, 'idDocReferenciado');
    }
}
