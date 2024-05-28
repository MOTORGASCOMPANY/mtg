<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\TipoServicio;
use App\Exports\ReporteDetalladoGasolExport;
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

class ReportesGasolution extends Component
{
    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores, $certis, $tipos;
    public $ins = [], $taller = [];
    public $servicio;
    public $grupoinspectores;
    public $tabla, $diferencias, $importados, $chartData;
    public $tabla2;
    public $user;

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
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
        return view('livewire.reportes.reportes-gasolution');
    }

    public function procesar()
    {
        $this->validate();
        $this->tabla = $this->generaData();
        $this->importados = $this->cargaServiciosGasolution();
        $this->diferencias = $this->encontrarDiferenciaPorPlaca($this->tabla, $this->importados);
        $serviciosPermitidos = ['Conversión a GLP', 'Revisión anual GLP', 'Modificación', 'Duplicado GNV', 'Conversión a GNV + Chip', 'Chip por deterioro', 'Pre-inicial GNV', 'Pre-inicial GLP'];
        $servisrestantes = $this->diferencias->filter(function ($item) use ($serviciosPermitidos) {
            return in_array($item['servicio'], $serviciosPermitidos);
        });
        $this->tabla2 = $this->importados->merge($servisrestantes, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });

        $this->grupoinspectores = $this->tabla2->groupBy('inspector');

    }

    public function exportarExcel()
    {
        //$datosCombinados = $this->tabla->concat($this->diferencias);
        $data = $this->tabla2;
        if ($data) {
            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteDetalladoGasolExport($data), 'ReporteCalcular' . $fecha . '.xlsx');
        }
    }

    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES PARA OFICINA:
        $certificaciones = Certificacion::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            ->IdTipoServicio($this->servicio)
            ->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [37, 117, 201]);
            })
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('pagado', 0)
            ->whereIn('estado', [3, 1])
            ->get();

        //TODO CER-PENDIENTES PARA OFICINA:
        $cerPendiente = CertificacionPendiente::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            ->IdTipoServicios($this->servicio)
            ->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [37, 117, 201]);
            })
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('estado', 1)
            ->whereNull('idCertificacion')
            ->get();


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

        //$this->grupoinspectores = $tabla->groupBy('inspector');
        return $tabla;
    }

    public function cargaServiciosGasolution()
    {
        $disc = new Collection();
        //TODO SER-IMPORTADOS PARA OFICINA:
        $dis = ServiciosImportados::Talleres($this->taller)
            ->Inspectores($this->ins)
            ->TipoServicio($this->servicio)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->get();


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

        //$this->grupoinspectores = $disc->groupBy('inspector');
        return $disc;
    }

    public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        //$diferencias = [];
        $diferencias = collect();

        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $inspector1 = $elemento1['inspector'];
            $servicio1 = $elemento1['servicio'];  
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
    }
}
