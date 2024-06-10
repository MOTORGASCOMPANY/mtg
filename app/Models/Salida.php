<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Salida extends Model
{
    use HasFactory;

    protected $table="salidas";

    protected $fillable=
    ['id',
    'numero',
    'idUsuarioSalida',
    'idUsuarioAsignado',
    'motivo', 
    'estado',  
    'idSubGrupo',    
    ];


    public function getDetallesAttribute(){
        $tipos=TipoMaterial::all();       
        $res=[];
        foreach($tipos as $tipo){
            $aux=DB::table('material')
            ->select('material.idTipoMaterial','tipomaterial.descripcion')            
            ->join('tipomaterial','material.idTipoMaterial',"=",'tipomaterial.id')
            ->where([
                ['material.grupo',$this->attributes['numeroguia']],
                ['material.idTipoMaterial',$tipo->id],                
            ])            
            ->get();
            if(count($aux) > 0) {
                $a=array("tipo"=>$tipo->descripcion,"cantidad"=>count($aux));
                array_push($res,$a);
            }
        }        
        return $res;
    }

    public function materiales(){
        return $this->belongsToMany(Material::class, 'detallesalida','idSalida','idMaterial')
        ->as("detalle")
        ->withPivot("motivo");
    }

    //para filtro material en salida
    public function materiales2(){
        return $this->belongsToMany(Material::class, 'detallesalida','idSalida','idMaterial');
    }

    public function  getPorAsignacionAttribute(){
        return $this->belongsToMany(Material::class, 'detallesalida','idSalida','idMaterial')
        ->as("detalle")
        ->withPivot("motivo")
        ->wherePivot('motivo', "Solicitud de material");
    }

    public function getPorCambioAttribute(){
        return $this->belongsToMany(Material::class, 'detallesalida','idSalida','idMaterial')
        ->as("detalle")
        ->withPivot("motivo")
        ->wherePivot('motivo', "Cambio");
    }

    public function getPorPrestamoAttribute(){
        return $this->belongsToMany(Material::class, 'detallesalida','idSalida','idMaterial')
        ->as("detalle")
        ->withPivot("motivo")
        ->wherePivot('motivo',"Prestamo de Materiales");
    }
    
    /*
    public function materialesPorAsigancion(){
        $materiales=new Collection();
        $gnvs=$this->porAsignacion->where("idTipoMaterial",1);
        $glps=$this->porAsignacion->where("idTipoMaterial",3);
        $chips=$this->porAsignacion->where("idTipoMaterial",2);
        if($gnvs->count()>0){
            $materiales->push(["materiales"=>$gnvs,"cantidad"=>$gnvs->count(),"motivo"=>$gnvs->first()->detalle->motivo]);
        }       
        if($glps->count()>0){
            $materiales->push(["materiales"=>$glps,"cantidad"=>$glps->count(),"motivo"=>$glps->first()->detalle->motivo]);
        }
        if($chips->count()>0){
            $materiales->push(["materiales"=>$chips,"cantidad"=>$chips->count(),"motivo"=>$chips->first()->detalle->motivo]);
        }
        return $materiales;
    }

    public function materialesPorCambio(){
        $materiales=new Collection();
        $gnvs=$this->porCambio->where("idTipoMaterial",1);
        $glps=$this->porCambio->where("idTipoMaterial",3);
        $chips=$this->porCambio->where("idTipoMaterial",2);
        if($gnvs->count()>0){
            $materiales->push(["materiales"=>$gnvs,"cantidad"=>$gnvs->count(),"motivo"=>$gnvs->first()->detalle->motivo]);
        }       
        if($glps->count()>0){
            $materiales->push(["materiales"=>$glps,"cantidad"=>$glps->count(),"motivo"=>$glps->first()->detalle->motivo]);
        }
        if($chips->count()>0){
            $materiales->push(["materiales"=>$chips,"cantidad"=>$chips->count(),"motivo"=>$chips->first()->detalle->motivo]);
        }
        return $materiales;
    }

    public function materialesPorPrestamo(){
        $materiales=new Collection();
        $gnvs=$this->porPrestamo->where("idTipoMaterial",1);
        $glps=$this->porPrestamo->where("idTipoMaterial",3);
        $chips=$this->porPrestamo->where("idTipoMaterial",2);
        if($gnvs->count()>0){
            $materiales->push(["materiales"=>$gnvs,"cantidad"=>$gnvs->count(),"motivo"=>$gnvs->first()->detalle->motivo]);
        }       
        if($glps->count()>0){
            $materiales->push(["materiales"=>$glps,"cantidad"=>$glps->count(),"motivo"=>$glps->first()->detalle->motivo]);
        }
        if($chips->count()>0){
            $materiales->push(["materiales"=>$chips,"cantidad"=>$chips->count(),"motivo"=>$chips->first()->detalle->motivo]);
        }
        return $materiales;
    }
    */
    


    public function encuentraSeries($arreglo){
        //dd($arreglo);
        $inicio = $arreglo[0]["numSerie"];
        $final = $arreglo[0]["numSerie"];
        $nuevos=[];
        foreach($arreglo as $key=>$rec){
            if($key+1 < count($arreglo) ){
                if($arreglo[$key+1]["numSerie"] - $rec["numSerie"]==1){
                    $final=$arreglo[$key+1]["numSerie"];
                }else{
                    array_push($nuevos,["inicio"=>$inicio,"final"=>$final]);
                    $inicio=$arreglo[$key+1]["numSerie"];
                    $final=$arreglo[$key+1]["numSerie"];                    
                }
            }else{
                $final=$arreglo[$key]["numSerie"];
                array_push($nuevos,["inicio"=>$inicio,"final"=>$final]);
            }
        }
        return $nuevos;        
    }


    public function getFormatosGnvAttribute(){
        return $this->materiales->where('idTipoMaterial',1);
    }

    public function getInicioSerieGnvAttribute(){
        return $this->materiales->where('idTipoMaterial',1)->min('numSerie');
    }

    public function getFinalSerieGnvAttribute(){
        return $this->materiales->where('idTipoMaterial',1)->max('numSerie');
    }
    

    public function usuarioCreador(){
        return $this->belongsTo(User::class,'idUsuarioSalida');
    }

    public function usuarioAsignado(){
        return $this->belongsTo(User::class,'idUsuarioAsignado');
    }
    public function subgrupo(){
        return $this->belongsTo(Subgrupo::class,'idSubGrupo');
    }
}
