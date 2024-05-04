<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteTallerExport;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Material;
use App\Models\ServiciosImportados;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Taller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;

class ReporteCalcularChip extends Component
{
    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores, $certis;
    public $ins = [], $taller = [];
    public $grupotalleres;
    public $tabla, $diferencias, $importados, $aux;
    public $tabla2;
    public $inspectoresPorTaller = [];

    protected $listeners = ['exportarExcel'];

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
        return view('livewire.reportes.reporte-calcular-chip');
    }

    public function procesar()
    {
        $this->validate();
        $this->tabla = $this->generaData();
        $this->importados = $this->cargaServiciosGasolution();
        $this->importados = $this->importados->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        $this->diferencias = $this->encontrarDiferenciaPorPlaca($this->importados, $this->tabla);        
        //$this->tabla2 = $this->tabla->merge($this->diferencias);
        //Merge para combinar tabla y diferencias -  strtolower para ignorar Mayusculas y Minusculas 
        $this->tabla2 = $this->tabla->merge($this->diferencias, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });

        //$this->aux = $this->tabla2->groupBy('taller');
        $this->aux = $this->tabla2->groupBy('taller')->sortBy(function ($item, $key) { //para ordenar 
            return $key;
        });
        $this->generarInspectoresPorTaller();
    }

    public function generarInspectoresPorTaller()
    {
        $inspectoresPorTaller = [];

        foreach ($this->aux as $nombreTaller => $certificaciones) {
            $inspectoresPorTaller[$nombreTaller] = $certificaciones->pluck('inspector')->unique()->toArray();
        }

        $this->inspectoresPorTaller = $inspectoresPorTaller;
    }

    public function exportarExcel($data)
    {
        //dd($data);
        return Excel::download(new ReporteTallerExport($data), 'reporte_calculoTaller.xlsx');
    }

    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('pagado', 0)
            ->whereIn('estado', [3, 1])
            ->get();

        //TODO CER-PENDIENTES:
        $cerPendiente = CertificacionPendiente::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('estado', 1)
            ->whereNull('idCertificacion')
            ->get();

        //unificando certificaciones     
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

        //$this->grupotalleres = $tabla->groupBy('taller');
        return $tabla;
    }

    public function encontrarDiferenciaPorPlaca($lista1, $lista2)
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
    }

    public function cargaServiciosGasolution()
    {
        $disc = new Collection();
        $dis = ServiciosImportados::Talleres($this->taller)
            ->Inspectores($this->ins)
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
        return $disc;
    }
}
