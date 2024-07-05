<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boleta extends Model
{
    use HasFactory;
    protected $table = 'boleta';

    protected $fillable =
    [
        'taller',
        'certificador',
        'fechaInicio',
        'fechaFin',
        'monto',
        'observacion'
    ];

    
    /*public function taller(): BelongsTo
    {
        return $this->belongsTo(Taller::class, 'idTaller');
    }*/

    public function boletaarchivo()
    {
        return $this->hasMany(BoletaArchivo::class, 'boleta_id', 'id');
    }

    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {   
        if ($desde && $hasta) {            
            $query->where('fechaInicio', '>=', $desde.' 00:00:00')
                  ->where('fechaFin', '<=', $hasta.' 23:59:59');
        }       
    }

    /*public function scopeTalleres(Builder $query, $search): void
    {   
        if(!empty($search)){
            $query->whereIn('idTaller', $search);
        }
    }*/

    /*public function scopeTalleres(Builder $query,  $search): void{   
        $nombres=[];
        foreach($search as $id){
           $taller=Taller::find($id);
           //dd($taller);
           if($taller){
            array_push($nombres, $taller->nombre);
           }
        }

        if(!empty($nombres)){
            $query->whereIn('idTaller', $nombres);
        }       
    }*/

    /*public function scopeInspectores(Builder $query,  $search): void{   
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
    }*/

    
}
