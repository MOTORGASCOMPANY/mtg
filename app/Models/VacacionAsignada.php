<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionAsignada extends Model
{
    use HasFactory;
    protected $table = 'vacacion_asignada';

    protected $fillable = [
        'idVacacion',
        'tipo',
        'razon',
        'd_tomados',
        'f_inicio',
        'observacion',
        'especial',
    ];

    public function Vacacion()
    {
        return $this->belongsTo(Vacacion::class, 'idVacacion');
    }
}
