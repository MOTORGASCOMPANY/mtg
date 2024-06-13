<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoTrabajo extends Model
{
    use HasFactory;
    protected $table = 'contrato_trabajo';

    protected $fillable = [
        'idUser',
        'dniEmpleado',
        'domicilioEmpleado',
        'fechaInicio',
        'fechaExpiracion',
        'cargo',
        'pago',
        'celularEmpleado',
        'correoEmpleado',
        'cumpleañosEmpleado',
        //'renovacion_id',
    ];

    // Relación con el usuario empleado
    public function empleado()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function Documentos()
    {
        return $this->belongsToMany(DocumentoEmpleado::class, 'documentoempleado_user', 'idUser', 'idDocumentoEmpleado');
    }

    /*public function renovacion()
    {
        return $this->belongsTo(ContratoTrabajo::class, 'renovacion_id');
    }

    public function renovaciones()
    {
        return $this->hasMany(ContratoTrabajo::class, 'renovacion_id');
    }*/

    public function vacaciones()
    {
        return $this->hasOne(Vacacion::class, 'idContrato');
    }

    public function getRutaVistaContratoTrabajoAttribute()
    {
        $ruta = route('contratoTrabajo', ['id' => $this->attributes['id']]);
        return $ruta;
    }

    public function getRutaDescargaContratoTrabajoAttribute()
    {
        $ruta = $ruta = route('descargarContratoTrabajo', ['id' => $this->attributes['id']]);
        return $ruta;
    }
}
