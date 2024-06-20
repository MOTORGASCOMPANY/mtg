<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Material extends Model
{
    use HasFactory;

    protected $table="material";

    protected $fillable=
    ['id',
    'descripcion',
    'numSerie',
    'idUsuario',
    'stock',
    'estado',
    'ubicacion',
    'grupo',
    'idTipoMaterial',
    'añoActivo',
    'anio',
    'created_at',
    'updated_at',
    ];

    public function tipo(){
        return $this->belongsTo(TipoMaterial::class,'idTipoMaterial');
    }



    public function Inspector(){
        return $this->belongsTo(User::class,'idUsuario');
    }

    //agregue esto para filtro ingreso material
    public function detalleIngresos()
    {
        return $this->hasMany(IngresoDetalle::class, 'idMaterial');
    }

    public function detalleSalidas()
    {
        return $this->hasMany(SalidaDetalle::class, 'idMaterial');
    }

    /*public function Certificacion()
    {
        return $this->belongsToMany(Certificacion::class, 'serviciomaterial', 'idCertificacion', 'idMaterial');
    }  

    public function getPlacaAttribute()
    {
        $certificacion = $this->certificaciones()->first();
        return $certificacion ? $certificacion->idVehiculo : null;
    }*/



    public static function formatosGnvEnStock($tipo){
        $res=new Collection();
        $aux=DB::table('material')
            ->select('material.idTipoMaterial','tipomaterial.descripcion')
            ->join('tipomaterial','material.idTipoMaterial',"=",'tipomaterial.id')
            ->where([
                ['material.idTipoMaterial',$tipo],
                ['material.estado',1],
            ])
            ->get();
        $res=$aux;
        return $res->count();
    }

    public static function stockPorGruposGnv(){
        $grupos=DB::table('material')
                ->select(DB::raw('grupo as guia,count(*) as stock,min(numSerie) as minimo,Max(numSerie) as maximo'))
                ->where([
                    ['estado',1],
                    ['idTipoMaterial',1]//TIPO DE MATERIAL: FORMATO GNV
                    ])
                ->groupBy('grupo')
                ->get();
        return json_encode($grupos);
    }

    public static function stockPorGruposGlp(){
        $grupos=DB::table('material')
                ->select(DB::raw('grupo as guia,count(*) as stock,min(numSerie) as minimo,Max(numSerie) as maximo'))
                ->where([
                    ['estado',1],
                    ['idTipoMaterial',3]//TIPO DE MATERIAL: FORMATO GLP
                    ])
                ->groupBy('grupo')
                ->get();
        return json_encode($grupos);
    }

    public static function stockPorGruposModi(){
        $grupos=DB::table('material')
                ->select(DB::raw('grupo as guia,count(*) as stock,min(numSerie) as minimo,Max(numSerie) as maximo'))
                ->where([
                    ['estado',1],
                    ['idTipoMaterial',4]//TIPO DE MATERIAL: FORMATO MODIFICACION
                    ])
                ->groupBy('grupo')
                ->get();
        return json_encode($grupos);
    }

    public static function materialPorGrupo($grupo){
        $grupo=DB::table('material')
                ->select("material.*")
                ->where([
                    ['estado',1],
                    ['idTipoMaterial',1],
                    ['grupo',$grupo],
                    ])
                ->get();

        return $grupo;
    }

    public function scopeSearchSerieFormmato($query,$search){
        if($search){
           return $query->where([['idTipoMaterial', 1],['numSerie','like','%'.$search.'%']]);
        }

    }

    public function scopeInspector($query,$search){
        if($search){
           return $query->where([['idUsuario', $search]]);
        }

    }

    public function scopeTipoMaterialInvetariado($query,$search){
        if($search){
           return $query->where([['idTipoMaterial', $search]]);
        }
    }

    public function scopeEstadoInvetariado($query,$search){
        if($search){
           return $query->where([['estado', $search]]);
        }
    }

    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {
        if ($desde && $hasta) {
            $query->whereBetween('updated_at', [$desde . ' 00:00', $hasta . ' 23:59']);
        }
    }

    
}
