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
                    "pagado"                 
                    ];


    public function TipoServicio(){
        return $this->belongsTo(TipoServicio::class,'tipoServicio');
    }

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
    

    public function scopeTaller($query,$search): void{
        if($search){           
            $query->where('taller', $search);              
        }
        
    }
}
