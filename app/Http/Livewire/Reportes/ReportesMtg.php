<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\TipoServicio;
use App\Exports\ReporteCalcularExport;
use App\Http\Livewire\Talleres;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Desmontes;
use App\Models\User;
use Illuminate\Cache\NullStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportesMtg extends Component
{
    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores, $certis, $tipos;
    public $ins = [], $taller = [];
    public $servicio;
    public $grupoinspectores;
    public $tabla, $diferencias, $importados;
    public $user;



    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        //$this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->inspectores = User::role(['inspector', 'supervisor'])
            ->where('id', '!=', 201)
            ->orderBy('name')
            ->get();
        $this->talleres = Taller::orderBy('nombre')->get();
        $this->tipos = TipoServicio::all();
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.reportes.reportes-mtg');
    }

    public function procesar()
    {
        $this->validate();
        $this->tabla = $this->generaData();
        $this->importados = $this->cargaServiciosGasolution();
        //TRIM PARA ELIMINAR ESPACIOS 
        $this->tabla = $this->tabla->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        $this->importados = $this->importados->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        $this->diferencias = $this->encontrarDiferenciaPorPlaca($this->importados, $this->tabla);
        //dd($this->diferencias);
    }

    public function exportarExcel()
    {
        $datosCombinados = $this->tabla->concat($this->diferencias);
        $data = $datosCombinados;
        if ($data) {
            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteCalcularExport($data), 'ReporteCalcular' . $fecha . '.xlsx');
        }
    }

    public function generaData()
    {
        $tabla = new Collection();

        if ($this->user->hasRole('inspector')) {
            //TODO CERTIFICACIONES PARA INSPECTOR:
            $certificaciones = Certificacion::idTalleres($this->taller)
                //->IdInspectores($this->ins)
                ->IdTipoServicio($this->servicio)
                ->whereHas('Inspector', function ($query) {
                    $query->where('id', $this->user->id);
                })
                ->rangoFecha($this->fechaInicio, $this->fechaFin)
                ->where('pagado', 0)
                ->whereIn('estado', [3, 1])
                ->get();

            //TODO CER-PENDIENTES PARA INSPECTOR:
            $cerPendiente = CertificacionPendiente::idTalleres($this->taller)
                ->whereHas('Inspector', function ($query) {
                    $query->where('id', $this->user->id);
                })
                ->IdTipoServicios($this->servicio)
                ->rangoFecha($this->fechaInicio, $this->fechaFin)
                ->where('estado', 1)
                ->whereNull('idCertificacion')
                ->get();
        } else {
            //TODO CERTIFICACIONES PARA OFICINA:
            $certificaciones = Certificacion::idTalleres($this->taller)
                ->IdInspectores($this->ins)
                ->IdTipoServicio($this->servicio)
                /*->whereHas('Inspector', function ($query) {
                    $query->whereNotIn('id', [37, 117, 201]);
                })*/
                ->rangoFecha($this->fechaInicio, $this->fechaFin)
                ->where('pagado', 0)
                ->whereIn('estado', [3, 1])
                ->get();

            //TODO CER-PENDIENTES PARA OFICINA:
            $cerPendiente = CertificacionPendiente::idTalleres($this->taller)
                ->IdInspectores($this->ins)
                /*->whereHas('Inspector', function ($query) {
                    $query->whereNotIn('id', [37, 117, 201]);
                })*/
                ->IdTipoServicios($this->servicio)
                ->rangoFecha($this->fechaInicio, $this->fechaFin)
                ->where('estado', 1)
                ->whereNull('idCertificacion')
                ->get();
        }

        //UNIFICANDO CERTIFICACIONES    
        foreach ($certificaciones as $certi) {
            //modelo preliminar
            $data = [
                "id" => $certi->id,
                "placa" => $certi->Vehiculo->placa,
                "taller" => $certi->Taller->nombre,
                "inspector" => $certi->Inspector->name,
                "servicio" => $certi->Servicio->tipoServicio->descripcion,
                "num_hoja" => $certi->NumHoja,
                "ubi_hoja" => $certi->UbicacionHoja,
                "precio" => $certi->precio,
                "pagado" => $certi->pagado,
                "estado" => $certi->estado,
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
                "inspector" => $cert_pend->Inspector->name,
                "servicio" => 'Activación de chip (Anual)', // es ese tipo de servicio por defecto
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $cert_pend->precio,
                "pagado" => $cert_pend->pagado,
                "estado" => $cert_pend->estado,
                "tipo_modelo" => $cert_pend::class,
                "fecha" => $cert_pend->created_at,
            ];
            $tabla->push($data);
        }

        $this->grupoinspectores = $tabla->groupBy('inspector');
        return $tabla;
    }


    /*public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        $diferencias = [];

        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $encontrado = false;

            foreach ($lista2 as $elemento2) {
                $placa2 = $elemento2['placa'];

                if ($placa1 === $placa2) {
                    $encontrado = true;
                    break;
                }
            }

            if (!$encontrado) {
                $diferencias[] = $elemento1;
            }
        }

        return $diferencias;
    }*/

    /*public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        $diferencias = [];
        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $inspector1 = $elemento1['inspector'];
            $servicio1 = $elemento1['servicio'];  //manejar esto , por el momento es para activacion pero tendria que estar para los demas servicios
            $encontrado = false;

            foreach ($lista2 as $elemento2) {
                $placa2 = $elemento2['placa'];
                $inspector2 = $elemento2['inspector'];
                $servicio2 = $elemento2['servicio'];

                // Verificar si la placa, el inspector y el servicio son iguales
                if ($placa1 === $placa2 && $inspector1 === $inspector2 && $servicio1 === $servicio2) {  
                    $encontrado = true;
                    break;
                }
            }

            if (!$encontrado) {
                $diferencias[] = $elemento1;
            }
        }

        return $diferencias;
    }*/

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

                if ($elemento2['tipo_modelo'] == 'App\Models\CertificacionPendiente') {
                    //dd($elemento1);
                    if ($placa1 === $placa2 && $inspector1 === $inspector2 && $servicio1 == 'Revisión anual GNV') {
                        
                        $encontrado = true;
                        break;
                    }
                }else{
                    if ($placa1 === $placa2 && $inspector1 === $inspector2 && $servicio1 === $servicio2) {
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

        if ($this->user->hasRole('inspector')) {
            //TODO SER-IMPORTADOS PARA INSPECTOR:
            $dis = ServiciosImportados::Talleres($this->taller)
                ->Certificador($this->user->name)
                ->TipoServicio($this->servicio)
                ->RangoFecha($this->fechaInicio, $this->fechaFin)
                ->get();
        } else {
            //TODO SER-IMPORTADOS PARA OFICINA:
            $dis = ServiciosImportados::Talleres($this->taller)
                ->Inspectores($this->ins)
                ->TipoServicio($this->servicio)
                ->RangoFecha($this->fechaInicio, $this->fechaFin)
                ->get();
        }

        foreach ($dis as $registro) {
            $data = [
                "id" => $registro->id,
                "placa" => $registro->placa,
                "taller" => $registro->taller,
                "inspector" => $registro->certificador,
                "servicio" => $registro->TipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $registro->precio,
                "pagado" => $registro->pagado,
                "estado" => $registro->estado,
                "tipo_modelo" => $registro::class,
                "fecha" => $registro->fecha,
            ];
            $disc->push($data);
        }
        return $disc;
    }
}
