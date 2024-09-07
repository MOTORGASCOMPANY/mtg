<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desmontes extends Model
{
    protected $table = "desmontes";

    protected $fillable =
    [
        'id',
        'placa',
        'idTaller',
        'idServicio',
        'idInspector',
        'estado',
        'precio',
        'pagado',
        'created_at',
        'updated_at',
    ];


    public function Taller()
    {
        return $this->belongsTo(Taller::class, 'idTaller');
    }

    public function Inspector()
    {
        return $this->belongsTo(User::class, 'idInspector');
    }

    public function Servicio()
    {
        return $this->belongsTo(Servicio::class, 'idServicio');
    }

    public function scopeIdInspector(Builder $query, string $search): void
    {
        if ($search) {
            $query->where('idInspector', $search);
        }
    }
    public function scopeIdTaller(Builder $query, string $search): void
    {
        if ($search) {
            $query->where('idTaller', $search);
        }
    }

    public function scopePlaca(Builder $query, ?string $search): void
    {
        if (!is_null($search)) {
            $query->where('placa', 'like', '%' . $search . '%');
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

    public function scopeIdInspectores(Builder $query, $search): void
    {
        if ($search) {
            $query->whereIn('idInspector', $search);
        }
    }   
    

    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {
        if ($desde && $hasta) {
            $query->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59']);
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
}
