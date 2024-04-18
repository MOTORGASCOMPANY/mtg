<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehiculo extends Model
{
    use HasFactory;

    protected $table="vehiculo";

    public $fillable=[
        "id",
        "propietario",
        "placa",
        "categoria",
        "marca",
        "modelo",
        "version",
        "anioFab",
        "numSerie",
        "numMotor",
        "cilindros",
        "cilindrada",
        "combustible",
        "ejes",
        "ruedas",
        "asientos",
        "pasajeros",
        "largo",
        "ancho",
        "altura",
        "color",
        "pesoNeto",
        "pesoBruto",
        "cargaUtil",
        "created_at",
        "updated_at",
    ];

    public function Equipos(){
        return $this->belongsToMany(Equipo::class, 'equiposvehiculo','idVehiculo','idEquipo');
    }
    public function modificaciones()
    {
        return $this->belongsToMany(Modificacion::class, 'vehiculo_modificacion', 'idVehiculo', 'idModificacion');
    }

    public function cuentaDis($tipo){
        $cuenta=0;
            if($this->Equipos->count() >0){
                foreach($this->Equipos as $eq){
                    if($eq->idTipoEquipo == $tipo){
                        $cuenta++;
                    }
                }
            }
        return $cuenta;
    }

    public function getEsCertificableGnvAttribute(){
        $estado=false;
        $chips=$this->cuentaDis(1);
        $reg=$this->cuentaDis(2);
        $cil=$this->cuentaDis(3);
            if($chips>0 && $reg>0 && $cil >0){
                $estado=true;
            }
        return $estado;
    }

    public function getEsCertificableGlpAttribute(){
        $estado=false;
        $reg=$this->cuentaDis(4);
        $cil=$this->cuentaDis(5);
            if($reg>0 && $cil >0){
                $estado=true;
            }
        return $estado;
    }

    public function getEsCertificableModiAttribute(){
        $estado=false;
        return $estado;
    }

}
