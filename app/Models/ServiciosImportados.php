<?php

namespace App\Models;

use Doctrine\DBAL\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use PhpParser\Node\Stmt\Return_;

class ServiciosImportados extends Model
{
    use HasFactory;

    protected $table="servicios_importados";

    protected $fillable=[
                    "placa",
                    "serie",
                    "certificador",
                    "taller", 
                    "precio",
                    "fecha",  
                    "tipoServicio",    
                    "estado",
                    "pagado",
                    "idImportado",                
                    ];


    public function TipoServicio(){
        return $this->belongsTo(TipoServicio::class,'tipoServicio');
    }

    /*Para rpta tallere resumen excluya a inspectores servicios importados
    public function Inspector()
    {
        return $this->belongsTo(User::class, 'certificador');
    }*/

    public function Precio(){
        $precio=0;
        $taller=Taller::where("nombre",$this->attributes['taller'])->first();
        if($taller!=null){
            $servicio=Servicio::where([['taller_idtaller',$taller->id],["tipoServicio_idtipoServicio",$this->attributes["tipoServicio"]]])->first()->precio;  
            $precio=var_export($servicio);
        }
        return $precio;
    }

    public function conSistema(){        
        $estado=0;
        $fecha=date('Y-m-d',strtotime($this->attributes['fecha']));
        $placa=$this->attributes['placa'];           
        $encontrado=Certificacion::whereHas('Vehiculo',function ($query) use ($placa){
            $query->where('placa',$placa);
        })->whereBetween('created_at',[$fecha.' 00:00',$fecha.' 23:59']);
        if($encontrado->count()){
            $estado=1;
        }
        return $estado;
    }


    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {   
        if($desde && $hasta){            
            $query->whereBetween('fecha', [$desde.' 00:00:00',$hasta.' 23:59:59']);
        }       
    }

    public function scopeCertificador(Builder $query, string $search): void{   
        if($search){
            $query->where('certificador', $search);
        }       
    }    

    public function scopeTalleres(Builder $query,  $search): void{   
        $nombres=[];
        foreach($search as $id){
           $taller=Taller::find($id);
           //dd($taller);
           if($taller){
            array_push($nombres, $taller->nombre);
           }
        }

        if(!empty($nombres)){ //count($nombres)>1
            $query->whereIn('taller', $nombres);
        }       
    }

    public function scopeInspectores(Builder $query,  $search): void{   
        $nombres=[];
        foreach($search as $id){
           $inspector=User::find($id);           
           if($inspector){
            array_push($nombres, $inspector->name);
           }
        }

        if(!empty($nombres)){
            $query->whereIn('certificador', $nombres);
        }       
    }

    public function scopeTipoServicios(Builder $query,  $search): void{   
        $nombres=[];
        foreach($search as $id){
           $tipos=TipoServicio::find($id);
           if($tipos){
            array_push($nombres, $tipos->descripcion);
           }
        }

        if(!empty($nombres)){
            $query->whereIn('tipoServicio', $nombres);
        }       
    }

    public function scopeTipoServicio($query,$search): void{   
        if($search){
            $query->where('tipoServicio', $search);
        }       
    } 
    

    public function scopeTaller($query,$search): void{
        if($search){           
            $query->where('taller', $search);              
        }
        
    }
}
