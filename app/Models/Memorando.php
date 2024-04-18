<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memorando extends Model
{
    use HasFactory;
    protected $table = 'memorando';

    protected $fillable = [
        'fecha',
        'remitente',
        'idUser',
        'cargo',
        'cargoremi',
        'motivo',
    ];

    // Relación con el usuario destinatario
    public function destinatario()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    /*public function archivo()
    {
        return $this->hasOne(Archivo::class, 'idDocReferenciado');
    }*/


    public function getRutaVistaMemorandoAttribute()
    {
        $ruta = route('certificadoMemo', ['id' => $this->attributes['id']]);
        return $ruta;
    }

    public function getRutaDescargaMemorandoAttribute()
    {
        $ruta = $ruta = route('descargarCertiMemo', ['id' => $this->attributes['id']]);
        return $ruta;
    }
}
