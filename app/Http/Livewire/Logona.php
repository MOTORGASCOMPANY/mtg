<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Desmontes;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class Logona extends Component
{
    public $fechaInicio, $fechaFin, $talleres, $inspectores, $servicio;
    public $ins = [], $taller = [];
    public $tabla, $diferencias, $importados, $aux;
    public $tabla2;

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->talleres = Taller::orderBy('nombre')->get();
    }

    public function render()
    {
        return view('livewire.logona');
    }

    public function procesar()
    {
        $this->validate();
        $this->tabla = $this->generaData();
        $this->importados = $this->cargaServiciosGasolution();
        $this->diferencias = $this->encontrarDiferenciaPorPlaca($this->importados, $this->tabla);
        //Merge para combinar tabla y diferencias -  strtolower para ignorar Mayusculas y Minusculas 
        $this->tabla2 = $this->tabla->merge($this->diferencias, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });
        // Agrupamos por taller y sumamos los precios
        $this->aux = $this->tabla2->groupBy('taller')->map(function ($items) {
            return [
                'taller' => $items->first()['taller'],
                'encargado' => $items->first()['representante'],
                'total' => $items->sum('precio'), 
            ];
        })->sortBy('taller');
        ($this->aux);
    }

    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::idTalleres($this->taller)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('pagado', 0)
            ->whereIn('estado', [3, 1])
            ->get();

        //TODO CER-PENDIENTES:
        $cerPendiente = CertificacionPendiente::idTalleres($this->taller)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('estado', 1)
            ->whereNull('idCertificacion')            
            ->get();

        //TODO DESMONTES:
        $desmontes = Desmontes::idTalleres($this->taller)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->get();

        //unificando certificaciones     
        foreach ($certificaciones as $certi) {
            $data = [
                "id" => $certi->id,
                "placa" => $certi->Vehiculo->placa,
                "taller" => $certi->Taller->nombre,
                "representante" => $certi->Taller->representante,
                "inspector" => $certi->Inspector->name,
                "servicio" => $certi->Servicio->tipoServicio->descripcion,
                "num_hoja" => $certi->NumHoja,
                "ubi_hoja" => $certi->UbicacionHoja,
                "precio" => $certi->precio,
                "pagado" => $certi->pagado,
                "estado" => $certi->estado,
                "externo" => $certi->externo,
                "tipo_modelo" => $certi::class,
                "fecha" => $certi->created_at,

            ];
            $tabla->push($data);
        }

        foreach ($cerPendiente as $cert_pend) {
            //modelo preliminar
            $data = [
                "id" => $cert_pend->id,
                "placa" => $cert_pend->Vehiculo->placa,
                "taller" => $cert_pend->Taller->nombre,
                "representante" => $cert_pend->Taller->representante,
                "inspector" => $cert_pend->Inspector->name,
                "servicio" => 'Activación de chip (Anual)',
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $cert_pend->precio,
                "pagado" => $cert_pend->pagado,
                "estado" => $cert_pend->estado,
                "externo" => $cert_pend->externo,
                "tipo_modelo" => $cert_pend::class,
                "fecha" => $cert_pend->created_at,
            ];
            $tabla->push($data);
        }

        foreach ($desmontes as $des) {
            $data = [
                "id" => $des->id,
                "placa" => $des->placa,
                "taller" => $des->Taller->nombre,
                "representante" => $des->Taller->representante,
                "inspector" => $des->Inspector->name,
                "servicio" => $des->Servicio->tipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $des->precio,
                "pagado" => $des->pagado,
                "estado" => $des->estado,
                "externo" => $des->externo,
                "tipo_modelo" => $des::class,
                "fecha" => $des->created_at,
            ];
            $tabla->push($data);
        }
        return $tabla;
    }

    public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        $diferencias = [];

        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $inspector1 = $elemento1['inspector'];
            $servicio1 = $elemento1['servicio'];
            $encontrado = false;
            // Excluir el servicio 'Revisión anual GNV' para que no muestre como discrepancia 'Activación de chip (Anual)'
            foreach ($lista2 as $elemento2) {
                $placa2 = $elemento2['placa'];
                $inspector2 = $elemento2['inspector'];
                $servicio2 = $elemento2['servicio'];
                if ($placa1 === $placa2 && $inspector1 === $inspector2) {
                    if (
                        ($elemento2['tipo_modelo'] == 'App\Models\CertificacionPendiente' && $servicio1 == 'Revisión anual GNV') ||
                        ($servicio2 == 'Conversión a GNV + Chip' && $servicio1 == 'Conversión a GNV')
                    ) {
                        $encontrado = true;
                        break;
                    } else if ($servicio1 === $servicio2) {
                        $encontrado = true;
                        break;
                    }
                }
            }
            if (!$encontrado) {
                $diferencias[] = $elemento1;
            }
        }
        return $diferencias;
    }


    public function cargaServiciosGasolution()
    {
        $disc = new Collection();
        $dis = ServiciosImportados::Talleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->get();

        foreach ($dis as $registro) {
            $data = [
                "id" => $registro->id,
                "placa" => $registro->placa,
                "taller" => $registro->taller,
                "representante" => $registro->representante,
                "inspector" => $registro->certificador,
                "servicio" => $registro->TipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $registro->precio,
                "pagado" => $registro->pagado,
                "estado" => $registro->estado,
                "externo" => Null,
                "tipo_modelo" => $registro::class,
                "fecha" => $registro->fecha,
            ];
            $disc->push($data);
        }
        return $disc;
    }
}
