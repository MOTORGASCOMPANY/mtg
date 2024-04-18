<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PrecioInspector extends Model
{
    use HasFactory;

    protected $table="precios_inspector";

    protected $fillable=
    ['id',
    'precio',
    'estado',
    'idServicio',
    'idUsers',  
    'created_at',
    'updated_at',        
    ]; 


    public function Inspector(){
        return $this->belongsTo(User::class,'idUsers');
    }

    
    public function tipoServicio(){
        return $this->belongsTo(TipoServicio::class,'idServicio');
    }

    public function scopeIdTipoServicio(Builder $query, string $search): void
    {   
        if($search){
            $query->where('idServicio', $search);
        }
       
    }

}
