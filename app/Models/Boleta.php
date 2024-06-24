<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boleta extends Model
{
    use HasFactory;
    protected $table = 'boleta';

    protected $fillable =
    [
        'idTaller',
        'fechaInicio',
        'fechaFin',
        'monto',
        'observacion'
    ];

    
    public function taller(): BelongsTo
    {
        return $this->belongsTo(Taller::class, 'idTaller');
    }

    public function boletaarchivo()
    {
        return $this->hasMany(BoletaArchivo::class, 'boleta_id', 'id');
    }

    
}
