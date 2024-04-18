<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class Ingreso extends Model
{
    use HasFactory;

    protected $table="ingresos";

    protected $fillable=
    ['id',
    'idDetalleIngreso',
    'idUsuario',
    'motivo',
    'numeroguia',
    'estado',
    'created_at',
    'updated_at',        
    ];

    /*
    public function detalleIngreso(){
        return $this->hasMany(DetalleIngreso::class,'idDetalleIngreso');
    }
    */

    public function usuario(){
        return $this->belongsTo(User::class,'idUsuario');
    }


    public function getTipoMaterialAttribute(){
        return $this->materiales->first();
    }


    public function materiales(){
        return $this->belongsToMany(Material::class, 'detalleingreso','idIngreso','idMaterial');
    }

    //Datos de los formatos de GNV
    public function getFormatosGnvAttribute(){
        return $this->materiales->where('idTipoMaterial',1);
    }

    public function getInicioSerieGnvAttribute(){
        return $this->materiales->where('idTipoMaterial',1)->min('numSerie');
    }

    public function getFinalSerieGnvAttribute(){
        return $this->materiales->where('idTipoMaterial',1)->max('numSerie');
    }


    //Datos de chip

    public function getChipsAttribute(){
        return $this->materiales->where('idTipoMaterial',2);
    }


    //Datos de los formatos de GLP
    public function getFormatosGlpAttribute(){
        return $this->materiales->where('idTipoMaterial',3);
    }

    public function getInicioSerieGlpAttribute(){
        return $this->materiales->where('idTipoMaterial',3)->min('numSerie');
    }

    public function getFinalSerieGlpAttribute(){
        return $this->materiales->where('idTipoMaterial',3)->max('numSerie');
    }

    //Datos de los formatos de MODIFICACION
    public function getFormatosModiAttribute(){
        return $this->materiales->where('idTipoMaterial',4);
    }

    public function getInicioSerieModiAttribute(){
        return $this->materiales->where('idTipoMaterial',4)->min('numSerie');
    }

    public function getFinalSerieModiAttribute(){
        return $this->materiales->where('idTipoMaterial',4)->max('numSerie');
    }





    
}
