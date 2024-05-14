<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = "documento";

    public $fillable = [
        "tipoDocumento",
        "nombreEmpleado",
        "fechaInicio",
        "fechaExpiracion",
        "extension",
        "ruta",
        "nombre",
        "estadoDocumento",
        "dias",
        "combustible",
    ];

    public function TipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipoDocumento');
    }


    //relacion entre documento y talleres por tabla intermedia documentostaller
    public function talleres()
    {
        return $this->belongsToMany(Taller::class, 'documentostaller', 'idDocumento', 'idTaller');
    }



    public function Taller()
    {
        return $this->belongsToMany(Taller::class, 'documentostaller', 'idDocumento', 'idTaller');
    }

    public function documentostaller()
    {
        return $this->hasMany(DocumentoTaller::class, 'idDocumento', 'id');
    }

    protected $casts = [
        'fechaExpiracion' => 'datetime:Y-m-d',
    ];

    public function getTiempoAttribute()
    {
        $resultMes = '';
        $resultDia = '';
        $resultHora = '';
        $hoy = now();
        $intervalo = $hoy->diff($this->attributes['fechaExpiracion']);

        if ($intervalo->m) {
            $resultMes = $intervalo->m . ' meses ';
        }

        if ($intervalo->d) {
            $resultDia = $intervalo->d . ' días ';
        }
        if ($intervalo->h) {
            $resultHora = $intervalo->h . ' horas.';
        }
        return $resultMes . $resultDia . $resultHora;
    }

    public function getDiasAttribute()
    {
        $hoy = now();
        $dias = $hoy->diff($this->attributes['fechaExpiracion'])->format('%R%a');
        return $dias;
    }
}
