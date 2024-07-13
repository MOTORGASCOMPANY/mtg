<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificacionTaller extends Model
{
    use HasFactory;

    protected $table = "certificados_taller";

    protected $fillable = [
        'idTaller',
        'idInspector',
        'idMaterial',
        'estado',
        'inicial',
        'created_at',
        'updated_at',
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'idTaller');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'idInspector');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'idMaterial');
    }


    public function scopeIdInspector(Builder $query, string $search): void
    {
        if ($search) {
            $query->where('idInspector', $search);
        }
    }

    public function scopeIdTalleres(Builder $query, array $search): void
    {
        if (!empty($search)) {
            $query->whereHas('taller', function (Builder $query) use ($search) {
                $query->whereIn('id', $search);
            });
        }
    }

    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {
        if ($desde && $hasta) {
            $query->whereBetween('created_at', ["$desde 00:00:00", "$hasta 23:59:59"]);
        }
    }

    public static function certificarTaller(Taller $taller, Material $hoja, User $inspector, $externoValue)
    {      
        $cert = CertificacionTaller::create([
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idMaterial" => $hoja->id,
            "estado" => 1,
            "inicial" => $externoValue,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "Inspeccion de Taller"]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public function getRutaVistaCertificadoAttribute()
    {
        $ruta = null;
        $ruta = route('certificadoCerTaller', ['id' => $this->attributes['id']]);
        return $ruta;
    }

    public function scopeNumFormato2($query, $search): void
    {
        if ($search) {
            $query->whereHas('material', function (Builder $query) use ($search) {
                $query->where('numSerie', 'like', '%' . $search . '%');
            });
        }
    }

    public function scopeIdTaller($query, $search): void
    {
        if ($search) {
            $query->whereHas('Taller', function (Builder $query) use ($search) {
                $query->where('id', $search);
            });
        }
    }

    public function scopeIdMaterial($query, $search): void
    {
        if ($search) {
            $query->where('idMaterial', $search);
        }
    }
}
