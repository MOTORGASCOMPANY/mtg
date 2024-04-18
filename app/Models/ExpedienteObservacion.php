<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteObservacion extends Model
{
    use HasFactory;

    protected $table = 'expedienteobservacion';

    protected $fillable=
    [
    'id',
    'idExpediente',
    'idObservacion'      
    ];
}
