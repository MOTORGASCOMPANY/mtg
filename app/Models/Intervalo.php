<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervalo extends Model
{
    use HasFactory;

    protected $table="intervalo";

    public $fillable=[
        "nombreIntervalo",
        "unidadMedida",
        "cantidad",
        "estado",
    ];
}
