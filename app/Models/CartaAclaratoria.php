<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaAclaratoria extends Model
{
    use HasFactory;

    protected $table = "carta_aclaratoria";

    protected $fillable = [
        'idInspector',
        'idMaterial',
        'tipo',
        'titulo',
        'partida',
        'placa',
        'estado',
        'dice_data',
        'debe_decir_data',
        'dice_modificacion',
        'debe_decir_modificacion'
    ];

    protected $casts = [
        'dice_data' => 'array',
        'debe_decir_data' => 'array'
    ];


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

    public function scopeRangoFecha(Builder $query, string $desde, string $hasta): void
    {
        if ($desde && $hasta) {
            $query->whereBetween('created_at', ["$desde 00:00:00", "$hasta 23:59:59"]);
        }
    }

    public static function certificarCartAclaratoria(Material $hoja, User $inspector, $titulo, $partida, $placa, $diceData, $debeDecirData, $diceModificacion, $debeDecirModificacion)
    {
        //Condicion para tipo 
        $tipo = 'NE';
        $idTipoMaterial = $hoja->tipo->id;

        if ($idTipoMaterial == 1) {
            $tipo = 'FORMATO GNV';
        } elseif ($idTipoMaterial == 3) {
            $tipo = 'FORMATO GLP';
        } elseif ($idTipoMaterial == 4) {
            $tipo = 'MODIFICACION';
        } 

        $cert = CartaAclaratoria::create([
            "idInspector" => $inspector->id,
            "idMaterial" => $hoja->id,
            "tipo" => $tipo,
            "titulo" => $titulo,
            "partida" => $partida,
            "placa" => $placa,
            "estado" => 1,
            'dice_data' => $diceData,
            'debe_decir_data' => $debeDecirData,
            'dice_modificacion' => $diceModificacion,
            'debe_decir_modificacion' => $debeDecirModificacion
        ]);

        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "Carta Aclaratoria"]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public function getRutaVistaCertificadoAttribute()
    {
        $ruta = null;
        $ruta = route('CartaAclaratoria', ['id' => $this->attributes['id']]);
        return $ruta;
    }
}
