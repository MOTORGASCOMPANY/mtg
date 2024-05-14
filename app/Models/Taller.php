<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'taller';
    protected $fillable=
    [
     'id',   
    'nombre',
    'direccion',
    'ruc',
    'representante',
    'idDistrito',
    'rutaLogo',
    'rutaFirma',
    'autorizado_gnv',
    'autorizado_glp',
    ];




    public function servicios(){
        return $this->hasMany(Servicio::class,'taller_idtaller');
    }    

    public function Distrito(){
        return $this->belongsTo(Distrito::class,'idDistrito');
    }

    public function Documentos(){
        return $this->belongsToMany(Documento::class,'documentostaller','idTaller','idDocumento');
    }
    
   
}
