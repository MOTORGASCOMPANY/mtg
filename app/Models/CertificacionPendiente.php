<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificacionPendiente extends Model
{
    use HasFactory;

    protected $table="certificados_pendientes";

    protected $fillable=
    ['id',
    'idVehiculo',
    'idTaller',
    'idServicio',
    'idInspector',
    'estado',
    'idCertificacion',
    "idExpediente",
    'precio',
    'pagado',    
    'externo',
    'created_at',
    'updated_at',        
    ]; 

    public function Vehiculo(){
        return $this->belongsTo(vehiculo::class,'idVehiculo');
    }

    public function Taller(){
        return $this->belongsTo(Taller::class,'idTaller');
    }

    public function Inspector(){
        return $this->belongsTo(User::class,'idInspector');
    }

    public function Servicio(){
        return $this->belongsTo(Servicio::class,'idServicio');
    }

    public function scopePlacaVehiculo($query,$search): void{
        if($search){
        $query->orWhereHas('Vehiculo', function (Builder $query) use ($search) {
            $query->where('placa', 'like', '%'.$search.'%');
        });
        }
    }
    public function scopeIdInspector(Builder $query, string $search): void{   
        if($search){
            $query->where('idInspector', $search);
        }
       
    }

    //Scope para reporte 
    public function scopeIdTalleres($query, $search): void
    {
        if ($search) {
            $query->whereHas('Taller', function (Builder $query) use ($search) {
                $query->whereIn('id', $search);
            });
        }
    }
    public function scopeIdTipoServicios($query, $search): void
    {
        if ($search) {
            $query->whereHas('Servicio', function (Builder $query) use ($search) {
                $query->where('tipoServicio_idtipoServicio', $search);
            });
        }
    }

    public function scopeIdInspectores(Builder $query, $search): void
    {
        if ($search) {
            $query->whereIn('idInspector', $search);
        }
    }   
    

    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {
        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde . ' 00:00', $hasta . ' 23:59']);
        }
    }

    public function getplacaAttribute()
    {
        return $this->Vehiculo->placa;
    }
}
