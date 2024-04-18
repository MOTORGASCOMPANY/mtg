<?php

namespace App\Http\Livewire\Reportes;


use Livewire\Component;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\TipoServicio;
use App\Exports\ReporteCalcularExport;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteCalcularGasol extends Component
{

    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores;
    public $ins = [], $taller = [];
    public $totalPrecio, $reportePorInspector, $detallesPlacasFaltantes, $certificacionIds = [];
    public $editando, $tiposServicios = [], $serviciosImportados, $updatedPrices = [];

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->talleres = Taller::orderBy('nombre')->get(); //all()->sortBy('nombre')
        $this->serviciosImportados = ServiciosImportados::all();
    }
    public function render()
    {
        return view('livewire.reportes.reporte-calcular-gasol', [
            'tiposServicio' => TipoServicio::all(),
        ]);
    }

    public function calcularReporte()
    {
        $this->validate();
        $resultadosdetalle = $this->datosMostrar();
        $totalPrecio = $resultadosdetalle->sum('precio');
        //Cache::put('reporteCalcular', $this->datosMostrar(), now()->addMinutes(10));
        //$datosCombinados = $this->datosMostrar();
        $this->totalPrecio = $totalPrecio;
        $this->reportePorInspector = $resultadosdetalle->groupBy('idInspector');  //collect($this->resultadosdetalle)->groupBy('idInspector')->toArray(); 
        $this->detallesPlacasFaltantes   = $this->compararDiscrepancias();
    }

    private function compararDiscrepancias()
    {
        $certificaciones = DB::table('certificacion')
            ->select(
                'certificacion.idVehiculo',
                'certificacion.estado',
                'certificacion.created_at',
                'certificacion.pagado',
                'certificacion.idInspector',
                'certificacion.idTaller',
                'certificacion.idServicio',
                'vehiculo.placa as placa',
            )
            ->join('vehiculo', 'certificacion.idVehiculo', '=', 'vehiculo.id')
            ->join('servicio', 'certificacion.idServicio', '=', 'servicio.id')
            ->join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
            ->whereIn('tiposervicio.descripcion', ['Conversión a GNV', 'Revisión anual GNV', 'Desmonte de Cilindro'])
            ->where('certificacion.pagado', 0)
            ->whereIn('certificacion.estado', [3, 1])
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaCerti($query);
            })
            ->get();

        $serviciosImportados = DB::table('servicios_importados')
            ->select(
                'servicios_importados.fecha',
                'servicios_importados.placa',
                'servicios_importados.taller',
                'servicios_importados.precio',
                'servicios_importados.certificador',
                'servicios_importados.tipoServicio',
            )
            ->where(function ($query) {
                if (!empty($this->ins)) {
                    $query->whereIn('servicios_importados.certificador', $this->ins);
                }

                if (!empty($this->taller)) {
                    $query->whereIn('servicios_importados.taller', $this->taller);
                }
            })
            ->where(function ($query) {
                $this->fechaServImpor($query);
            })
            ->get();


        $serviciosImportadosUnicos = $serviciosImportados->unique(function ($item) {
            return $item->placa . $item->taller . $item->certificador . $item->tipoServicio . $item->fecha . $item->precio;
        });
        //detalles de servicios_importados únicos
        $detallesServiciosImportados = $serviciosImportadosUnicos->map(function ($item) {
            return [
                'placa' => $item->placa,
                'taller' => $item->taller,
                'certificador' => $item->certificador,
                'tipoServicio' => $item->tipoServicio,
                'fecha' => $item->fecha,
                'precio' => $item->precio,
            ];
        });
        //placas de servicios_importados
        $placasServiciosImportados = $serviciosImportadosUnicos->pluck('placa')->unique();
        // Filtrar las placas que están en servicios_importados pero no en certificacion para los tipos de servicio requeridos
        $placasFaltantes = $placasServiciosImportados->reject(function ($placa) use ($certificaciones) {
            return $certificaciones->where('placa', $placa)
                ->whereNotIn('tipoServicio', ['Conversión a GNV', 'Revisión anual GNV','Desmonte de Cilindro', 'Desmonte de Cilindro' ]) // Revisar esto porque desmonte corresponde a la tabla desmonte y no certificacion  (, 'Desmonte de Cilindro')
                ->isNotEmpty();
        });
        // Detalles de las placas faltantes
        $detallesPlacasFaltantes = $detallesServiciosImportados->filter(function ($item) use ($placasFaltantes) {
            return $placasFaltantes->contains($item['placa']);
        });
        //dd($detallesPlacasFaltantes);
        return $detallesPlacasFaltantes;
    }

    private function datosMostrar()
    {

        $certificaciones = DB::table('certificacion')
            ->select(
                'certificacion.id',
                'certificacion.idTaller',
                'certificacion.idInspector',
                'certificacion.idVehiculo',
                'certificacion.idServicio',
                'certificacion.estado',
                'certificacion.created_at',
                'certificacion.precio',
                'certificacion.pagado',
                'users.name as nombre',
                'taller.nombre as taller',
                'vehiculo.placa as placa',
                'tiposervicio.descripcion as tiposervicio',
                DB::raw('(SELECT material.numSerie FROM serviciomaterial 
                LEFT JOIN material ON serviciomaterial.idMaterial = material.id 
                WHERE serviciomaterial.idCertificacion = certificacion.id LIMIT 1) as matenumSerie'),
                DB::raw('(SELECT material.ubicacion FROM serviciomaterial 
                LEFT JOIN material ON serviciomaterial.idMaterial = material.id 
                WHERE serviciomaterial.idCertificacion = certificacion.id LIMIT 1) as mateubicacion')


            )
            ->join('users', 'certificacion.idInspector', '=', 'users.id')
            ->join('taller', 'certificacion.idTaller', '=', 'taller.id')
            ->join('vehiculo', 'certificacion.idVehiculo', '=', 'vehiculo.id')
            ->join('servicio', 'certificacion.idServicio', '=', 'servicio.id')
            ->join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
            //->leftJoin('serviciomaterial', 'certificacion.id', '=', 'serviciomaterial.idCertificacion')
            //->leftJoin('material', 'serviciomaterial.idMaterial', '=', 'material.id')
            ->where('certificacion.pagado', 0)
            ->whereIn('certificacion.estado', [3, 1])
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaCerti($query);
            })

            ->get();

        $certificadosPendientes = DB::table('certificados_pendientes')
            ->select(
                'certificados_pendientes.id',
                'certificados_pendientes.idTaller',
                'certificados_pendientes.idInspector',
                'certificados_pendientes.idVehiculo',
                'certificados_pendientes.idServicio',
                'certificados_pendientes.estado',
                'certificados_pendientes.created_at',
                'certificados_pendientes.pagado',
                'certificados_pendientes.precio',
                'users.name as nombre',
                'taller.nombre as taller',
                'vehiculo.placa as placa',
                DB::raw("'Activación de chip (Anual)' as tiposervicio")
            )

            ->leftJoin('users', 'certificados_pendientes.idInspector', '=', 'users.id')
            ->leftJoin('taller', 'certificados_pendientes.idTaller', '=', 'taller.id')
            ->leftJoin('vehiculo', 'certificados_pendientes.idVehiculo', '=', 'vehiculo.id')
            ->leftJoin('servicio', 'certificados_pendientes.idServicio', '=', 'servicio.id')
            ->where('certificados_pendientes.estado', 1)
            ->whereNull('certificados_pendientes.idCertificacion')
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaCeriPendi($query);
            })
            ->get();



        $resultadosdetalle = $certificaciones->concat($certificadosPendientes);

        return $resultadosdetalle;
    }

    public function exportarExcel()
    {

        $datosCertificaciones = $this->datosMostrar();
        $datosDiscrepancias = $this->compararDiscrepancias();
        $datosCombinados = $datosCertificaciones->concat($datosDiscrepancias);
        $data = $datosCombinados;
        if ($data) {
            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteCalcularExport($data), 'ReporteCalcular' . $fecha . '.xlsx');
        }
    }

    private function fechaCerti($query)
    {
        return $query->whereBetween('certificacion.created_at', [
            $this->fechaInicio . ' 00:00:00',
            $this->fechaFin . ' 23:59:59'
        ]);
    }

    private function fechaCeriPendi($query)
    {
        return $query->whereBetween('certificados_pendientes.created_at', [
            $this->fechaInicio . ' 00:00:00',
            $this->fechaFin . ' 23:59:59'
        ]);
    }
    private function fechaServImpor($query)
    {
        return $query->whereBetween('servicios_importados.fecha', [
            $this->fechaInicio . ' 00:00:00',
            $this->fechaFin . ' 23:59:59'
        ]);
    }

    private function agregarFiltros($query)
    {
        if (!empty($this->ins)) {
            $query->whereIn('idInspector', $this->ins);
        }

        if (!empty($this->taller)) {
            $query->whereIn('idTaller', $this->taller);
        }
    }
}
