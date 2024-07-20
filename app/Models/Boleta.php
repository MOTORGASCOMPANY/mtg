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
        'observacion',
        'anual',
        'duplicado',
        'inicial',
        'desmonte',
        'identificador',
        'auditoria'
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

    public function scopeTalleres(Builder $query, $search): void
    {   
        $nombres = [];

        if (is_string($search)) {
            $search = explode(',', $search); // Convertir la cadena en un array
        }

        if (is_array($search)) {
            foreach ($search as $id) {
                $taller = Taller::find($id);
                if ($taller) {
                    $nombres[] = $taller->nombre;
                }
            }

            if (!empty($nombres)) {
                $query->whereIn('taller', $nombres);
            }
        }
    }

    public function scopeInspectores(Builder $query, $search): void
    {   
        $nombres = [];

        if (is_string($search)) {
            $search = explode(',', $search); // Convertir la cadena en un array
        }

        if (is_array($search)) {
            foreach ($search as $id) {
                $inspector = User::find($id);
                if ($inspector) {
                    $nombres[] = $inspector->name;
                }
            }

            if (!empty($nombres)) {
                $query->whereIn('certificador', $nombres);
            }
        }
    }

    
}
