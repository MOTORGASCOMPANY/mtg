<?php

namespace App\Models;

use App\Http\Livewire\PreciospoInspector;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Certificacion extends Model
{
    use HasFactory;

    protected $table = "certificacion";

    public $fillable = [
        "id",
        "idVehiculo",
        "idTaller",
        "idInspector",
        "idServicio",
        "idServicioMaterial",
        "estado",
        "precio",
        "pagado",
        "idDuplicado",
        "idTallerAuto",
        "externo",
        "created_at",
        "updated_at",
    ];

    protected $appends = [
        'serie_formato',
        'placa',
        'tipo_servicio',
        'ruta_vista_certificado',
        'ruta_descarga_certificado',
        'ruta_vista_ft',
        'ruta_descarga_ft',
    ];



    public function Vehiculo()
    {
        return $this->belongsTo(vehiculo::class, 'idVehiculo');
    }

    public function Taller()
    {
        return $this->belongsTo(Taller::class, 'idTaller');
    }

    public function TallerAuto()
    {
        return $this->belongsTo(Taller::class, 'idTallerAuto');
    }

    public function Duplicado()
    {
        return $this->belongsTo(Duplicado::class, 'idDuplicado');
    }

    public function Inspector()
    {
        return $this->belongsTo(User::class, 'idInspector');
    }

    public function Servicio()
    {
        return $this->belongsTo(Servicio::class, 'idServicio');
    }

    public function Materiales()
    {
        return $this->belongsToMany(Material::class, 'serviciomaterial', 'idCertificacion', 'idMaterial');
    }

    //scopes para busquedas






    public function scopeNumFormato($query, $search): void
    {
        if ($search) {
            $query->whereHas('Materiales', function (Builder $query) use ($search) {
                $query->where('numSerie', 'like', '%' . $search . '%');
            });
        }
    }

    public function scopePlacaVehiculo($query, $search): void
    {
        if ($search) {
            $query->orWhereHas('Vehiculo', function (Builder $query) use ($search) {
                $query->where('placa', 'like', '%' . $search . '%');
            });
        }
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
            $query->whereBetween('created_at', [$desde . ' 00:00', $hasta . ' 23:59']);
        }
    }


    public function scopeTipoServicio($query, $search): void
    {
        if ($search) {
            $query->whereHas('Servicio', function (Builder $query) use ($search) {
                $query->where('tipoServicio_idtipoServicio', $search);
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

    //Scope para reporte 
    public function scopePagado($query)
    {
        return $query->where('pagado', 0);
    }

    public function scopeEstado($query)
    {
        return $query->whereIn('estado', [3, 1]);
    }

    public function scopeFiltrarPorFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }






    //Atributos Especiales del Certificado


    public function getplacaAttribute()
    {
        return $this->Vehiculo->placa;
    }

    public function gettipoServicioAttribute()
    {
        return $this->Servicio->tipoServicio->id;
    }

    //cambie esto por lo de abajo
    /*
    public function getserieFormatoAttribute(){
        //$hoja=Certificacion::find($this->attributes['id'])->Materiales->where('idTipoMaterial',1)->first();
        //return $hoja;
        $serie=null;

            $numero=$this->Materiales->where('idTipoMaterial',1)->first()->numSerie;


        if($numero){
            $serie=$numero;
        }
        return $serie;

    }*/

    public function getserieFormatoAttribute()
    {
        $serie = null;

        $material = $this->Materiales->where('idTipoMaterial', 1)->first();

        if ($material) {
            $serie = $material->numSerie;
        }

        return $serie;
    }

    public function getHojaAttribute()
    {
        $idServicio = $this->Servicio->tipoServicio->id;
        $hoja = null;
        if (in_array($idServicio, [1, 2, 7, 8, 10, 12])) {
            $hoja = Certificacion::find($this->attributes['id'])->Materiales->where('idTipoMaterial', 1)->first();
            return $hoja;
        } elseif (in_array($idServicio, [3, 4, 9, 13])) {
            $hoja = Certificacion::find($this->attributes['id'])->Materiales->where('idTipoMaterial', 3)->first();
            return $hoja;
        } elseif (in_array($idServicio, [5])) {
            $hoja = Certificacion::find($this->attributes['id'])->Materiales->where('idTipoMaterial', 4)->first();
            return $hoja;
        } else {
            return $hoja;
        }
    }

    public function getChipMaterialAttribute()
    {
        $chip = Certificacion::find($this->attributes['id'])->Materiales->where('idTipoMaterial', 2)->first();
        return $chip;
    }
    public function getChipAttribute()
    {
        return $this->Vehiculo->Equipos->where('idTipoEquipo', 1)->first();
    }

    public function getReductorAttribute()
    {
        return $this->Vehiculo->Equipos->where('idTipoEquipo', 2)->first();
    }

    public function getReductorGlpAttribute()
    {
        return $this->Vehiculo->Equipos->where('idTipoEquipo', 4)->first();
    }

    public function getCilindrosAttribute()
    {
        return $this->Vehiculo->Equipos->where('idTipoEquipo', 3);
    }

    public function getCilindrosGlpAttribute()
    {
        return $this->Vehiculo->Equipos->where('idTipoEquipo', 5);
    }

    public function getRutaVistaCertificadoAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1: //tipo servicio = inicial gnv
                $ruta = route('certificadoInicialGnv', ['id' => $this->attributes['id']]);
                break;
            case 2: //tipo servicio = anual gnv
                $ruta = route('certificadoAnualGnv', ['id' => $this->attributes['id']]);
                break;
            case 3: //tipo servicio = inicial gnv
                $ruta = route('certificadoInicialGlp', ['id' => $this->attributes['id']]);
                break;
            case 4: //tipo servicio = anual gnv
                $ruta = route('certificadoAnualGlp', ['id' => $this->attributes['id']]);
                break;
            case 5: //tipo servicio = modificacion
                $ruta = route('certificadoModificacion', ['id' => $this->attributes['id']]);
                break;

            case 8: //tipo servicio = anual gnv
                $dupli = Duplicado::find($this->attributes["idDuplicado"]);
                if ($dupli) {
                    $ruta = $this->generaRutaDuplicado($dupli);
                } else {
                    $ruta = null;
                }
                break;
            case 10: //tipo servicio = inicial gnv + chip
                $ruta = route('certificadoInicialGnv', ['id' => $this->attributes['id']]);
                break;

            case 12: //tipo servicio = Preconver
                $ruta = route('generaPreGnvPdf', ['id' => $this->attributes['id']]);
                break;
            case 13: //tipo servicio = Preconver
                $ruta = route('generaPreGlpPdf', ['id' => $this->attributes['id']]);
                break;

            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }

    public function getRutaDescargaCertificadoAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1: //tipo servicio = inicial gnv
                $ruta = route('descargarCertificadoInicialGnv', ['id' => $this->attributes['id']]);
                break;
            case 2: //tipo servicio = anual gnv
                $ruta = route('descargarCertificadoAnualGnv', ['id' => $this->attributes['id']]);
                break;
            case 3: //tipo servicio = anual glp
                $ruta = route('descargarCertificadoInicialGlp', ['id' => $this->attributes['id']]);
                break;
            case 4: //tipo servicio = anual glp
                $ruta = route('descargarCertificadoAnualGlp', ['id' => $this->attributes['id']]);
                break;
            case 5: //tipo servicio = modificacion
                $ruta = route('descargarCertificadoModificacion', ['id' => $this->attributes['id']]);
                break;

            case 8: //tipo servicio = anual gnv
                $dupli = Duplicado::find($this->attributes["idDuplicado"]);
                if ($dupli) {
                    $ruta = $this->generaRutaDescargaDuplicado($dupli);
                } else {
                    $ruta = null;
                }
                break;
            case 10: //tipo servicio = inicial gnv + chip
                $ruta = route('descargarCertificadoInicialGnv', ['id' => $this->attributes['id']]);
                break;

            case 12: //tipo servicio = preconversion
                $ruta = route('descargarPreGnvPdf', ['id' => $this->attributes['id']]);
                break;
            case 13: //tipo servicio = preconversion
                $ruta = route('descargarPreGlpPdf', ['id' => $this->attributes['id']]);
                break;


            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }
    public function getRutaVistaCheckListArribaAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1: //tipo servicio = inicial gnv
                $ruta = route('checkListArribaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 2: //tipo servicio = anual gnv
                $ruta = route('checkListArribaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 3: //tipo servicio = inicial glp
                $ruta = route('checkListArribaGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 4: //tipo servicio = anual glp
                $ruta = route('checkListArribaGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 10: //tipo servicio = inicial gnv + chip
                $ruta = route('checkListArribaGnv', ['idCert' => $this->attributes['id']]);
                break;

            case 12: //tipo servicio = preconversion
                $ruta = route('checkListArribaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 13: //tipo servicio = preconversion
                $ruta = route('checkListArribaGlp', ['idCert' => $this->attributes['id']]);
                break;
            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }

    public function getRutaVistaCheckListAbajoAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1: //tipo servicio = inicial gnv
                $ruta = route('checkListAbajoGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 2: //tipo servicio = anual gnv
                $ruta = route('checkListAbajoGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 3: //tipo servicio = inicial glp
                $ruta = route('checkListAbajoGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 4: //tipo servicio = anual glp
                $ruta = route('checkListAbajoGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 10: //tipo servicio = inicial gnv + chip
                $ruta = route('checkListAbajoGnv', ['idCert' => $this->attributes['id']]);
                break;

            case 12: //tipo servicio = preconversion
                $ruta = route('checkListAbajoGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 13: //tipo servicio = preconversion
                $ruta = route('checkListAbajoGlp', ['idCert' => $this->attributes['id']]);
                break;
            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }

    public function generaRutaDuplicado(Duplicado $duplicado)
    {
        $ruta = null;

        switch ($duplicado->externo) {
            case 0:
                switch ($duplicado->servicio) {

                    case 1:
                        $ruta = route('duplicadoInicialGnv', ['id' => $this->attributes['id']]);
                        break;
                    case 2:
                        $ruta = route('duplicadoAnualGnv', ['id' => $this->attributes['id']]);
                        break;
                }
                break;
            case 1:
                switch ($duplicado->servicio) {

                    case 1:
                        $ruta = route('duplicadoExternoInicialGnv', ['id' => $this->attributes['id']]);
                        break;
                    case 2:
                        $ruta = route('duplicadoExternoAnualGnv', ['id' => $this->attributes['id']]);
                        break;
                }

                break;

            default:
                # code...
                break;
        }

        return $ruta;
    }

    public function generaRutaDescargaDuplicado(Duplicado $duplicado)
    {
        $ruta = null;

        switch ($duplicado->externo) {
            case 0:
                switch ($duplicado->servicio) {

                    case 1:
                        $ruta = route('descargarDuplicadoInicialGnv', ['id' => $this->attributes['id']]);
                        break;
                    case 2:
                        $ruta = route('descargarDuplicadoAnualGnv', ['id' => $this->attributes['id']]);
                        break;
                }
                break;
            case 1:
                switch ($duplicado->servicio) {

                    case 1:
                        $ruta = route('descargarDuplicadoExternoInicialGnv', ['id' => $this->attributes['id']]);
                        break;
                    case 2:
                        $ruta = route('descargarDuplicadoExternoAnualGnv', ['id' => $this->attributes['id']]);
                        break;
                }

                break;

            default:
                # code...
                break;
        }

        return $ruta;
    }

    public function getRutaVistaFtAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1:
                $ruta = route('fichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 2:
                $ruta = route('fichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 3:
                $ruta = route('fichaTecnicaGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 4:
                $ruta = route('fichaTecnicaGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 10:
                $ruta = route('fichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 12:
                $ruta = route('fichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }

    public function getRutaDescargaFtAttribute()
    {
        $ruta = null;
        switch ($this->Servicio->tipoServicio->id) {
            case 1:
                $ruta = route('descargarFichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 2:
                $ruta = route('descargarFichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 3:
                $ruta = route('descargarFichaTecnicaGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 4:
                $ruta = route('descargarFichaTecnicaGlp', ['idCert' => $this->attributes['id']]);
                break;
            case 10:
                $ruta = route('descargarFichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            case 12:
                $ruta = route('descargarFichaTecnicaGnv', ['idCert' => $this->attributes['id']]);
                break;
            default:
                $ruta = null;
                break;
        }

        return $ruta;
    }

    public function getCalculaPesosAttribute()
    {
        $equipos = 0;
        if ($this->Servicio->tipoServicio->id == 3 && $this->Vehiculo->combustible == 'BI-COMBUSTIBLE GLP') {
            return 30;
        }

        $equipos = $this->Vehiculo->Equipos->where('idTipoEquipo', 3);

        return $equipos->sum('peso');
    }


    public static function certificarGlp(Taller $taller, Taller $tallerAuto, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $externoValue)
    {
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id],['idUsers',$inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                // Si el inspector no tiene asignado un precio para su tiposervicio retorna 0
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "idTallerAuto" => $tallerAuto->id, //Para taller autorizado
            "externo" => $externoValue,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function certificarGnv(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id],['idUsers',$inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue, //agregamos el nuevo campo externo
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }
    public static function certificarModi(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            $precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue, //agregamos el nuevo campo externo
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    //Cambiar la variable $servicio por una Clase Servicio para evitar posibles errores en la obtencion del precio.
    public static function certificarChipDeterioro($taller,  $servicio, Material $chip,  User $inspector, $nombre, $placa, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            //$precio = $servicio->precio;
            $precio = Servicio::find($servicio)->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', Servicio::find($servicio)->TipoServicio->id],['idUsers',$inspector->id]])->first()->precio;//te recomiendo que trates de cambiarla(idServicio) para que no haga hueviar
            $precio = PrecioInspector::where([
                ['idServicio', Servicio::find($servicio)->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => 1,
            "idTaller" => $taller,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            // $chip->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            $chip->update(["estado" => 4, "ubicacion" => "En poder del cliente " . $nombre . "/" . $placa, "descripcion" => "Chip consumido por deterioro"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $chip->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function certificarDesmonte($taller,  $servicio,  User $inspector, $placa, $externoValue)
    {
        if ($externoValue == 0) {
            $precio = Servicio::find($servicio)->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', Servicio::find($servicio)->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', Servicio::find($servicio)->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Desmontes::create([
            "placa" => $placa,
            "idTaller" => $taller,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue,
        ]);
        return $cert;
    }


    public static function certificarGnvPre(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 3,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function certificarGlpPre(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 3,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function certificarGnvPendiente(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $precio, $externoValue)
    {
        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function certificarGlpPendiente(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, $precio)
    {
        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function certificarGnvConChip(Taller $taller, Servicio $servicio, Material $hoja, vehiculo $vehiculo, User $inspector, Material $chip, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();

            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "externo" => $externoValue, //agregamos el nuevo campo externo
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);

            $chip->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);

            //dd($chip);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            $servM2 = ServicioMaterial::create([
                "idMaterial" => $chip->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function duplicarCertificadoExternoGnv(User $inspector, Vehiculo $vehiculo, Servicio $servicio, Taller $taller, Material $hoja, Duplicado $duplicado, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();
    
            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $cert = Certificacion::create([
            "idVehiculo" => $vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "idDuplicado" => $duplicado->id,
            "externo" => $externoValue, //agregamos el nuevo campo externo
        ]);
        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function duplicarCertificadoGnv(Duplicado $duplicado, Taller $taller, User $inspector, Servicio $servicio, Material $hoja, $externoValue)
    {
        //Condicion para jalar el precio de la tabla servicios o precios_inspector
        if ($externoValue == 0) {
            $precio = $servicio->precio;
        } elseif ($externoValue == 1) {
            //$precio = PrecioInspector::where([['idServicio', $servicio->TipoServicio->id], ['idUsers', $inspector->id]])->first()->precio;
            $precio = PrecioInspector::where([
                ['idServicio', $servicio->TipoServicio->id],
                ['idUsers', $inspector->id]
            ])->first();
    
            if ($precio) {
                $precio = $precio->precio;
            } else {
                $precio = 0;
            }
        }

        $anterior = Certificacion::find($duplicado->idAnterior);
        $cert = Certificacion::create([
            "idVehiculo" => $anterior->Vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $precio,
            "pagado" => 0,
            "idDuplicado" => $duplicado->id,
            "externo" => $externoValue, //agregamos el nuevo campo externo
        ]);

        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }

    public static function duplicarCertificadoGlp(Duplicado $duplicado, Taller $taller, User $inspector, Servicio $servicio, Material $hoja)
    {
        $anterior = Certificacion::find($duplicado->idAnterior);
        $cert = Certificacion::create([
            "idVehiculo" => $anterior->Vehiculo->id,
            "idTaller" => $taller->id,
            "idInspector" => $inspector->id,
            "idServicio" => $servicio->id,
            "estado" => 1,
            "precio" => $servicio->precio,
            "pagado" => 0,
            "idDuplicado" => $duplicado->id
        ]);

        if ($cert) {
            //cambia el estado de la hoja a consumido
            $hoja->update(["estado" => 4, "ubicacion" => "En poder del cliente"]);
            //crea y guarda el servicio y material usado en esta certificacion
            $servM = ServicioMaterial::create([
                "idMaterial" => $hoja->id,
                "idCertificacion" => $cert->id
            ]);
            //retorna el certificado
            return $cert;
        } else {
            return null;
        }
    }
}
