<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';

    protected $fillable=
    ['id',
    'precio',
    'estado',
    'taller_idtaller',
    'tipoServicio_idtipoServicio'
    ];

    public function tipoServicio(){
        return $this->belongsTo(TipoServicio::class,'tipoServicio_idtipoServicio');
    }

    public function scopeIdTipoServicio(Builder $query, string $search): void
    {   
        if($search){
            $query->where('tipoServicio_idtipoServicio', $search);
        }
       
    }
    
}
