<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionAsignada extends Model
{
    use HasFactory;
    protected $table = 'vacacion_asignada';

    protected $fillable = [
        'idContrato',
        'tipo',
        'razon',
        'd_tomados',
        'f_inicio',
        'observacion',
    ];

    public function contratoTrabajo()
    {
        return $this->belongsTo(ContratoTrabajo::class, 'idContrato');
    }
}
