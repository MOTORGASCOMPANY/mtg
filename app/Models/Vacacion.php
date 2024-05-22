<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;
    protected $table = 'vacaciones';

    protected $fillable = [
        'idContrato',
        'dias_ganados',
        'dias_tomados',
        'dias_restantes',
    ];

    public function contrato()
    {
        return $this->belongsTo(ContratoTrabajo::class, 'idContrato');
    }
}
