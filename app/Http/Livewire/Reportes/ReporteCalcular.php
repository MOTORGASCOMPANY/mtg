<?php

namespace App\Http\Livewire\Reportes;


use App\Models\Taller;
use App\Models\TipoServicio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\ReporteCalcularSimpleExport;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

use Livewire\Component;

class ReporteCalcular extends Component
{
    public $fechaInicio, $fechaFin, $talleres, $inspectores, $ins = [], $taller = [];
    public $resultados, $inspectorTotals;
    public $reporteTaller, $vertaller, $totalPrecio;
    public $tipoServicios;
    //public $certificaciones;


    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->talleres = Taller::all()->sortBy('nombre');
    }

    public function render()
    {
        return view('livewire.reportes.reporte-calcular', [
            'tiposServicio' => TipoServicio::all(),
        ]);
    }

    public function calcularReporteSimple()
    {
        $this->validate();
        $resultados = [];
        $tiposServiciosDeseados = ['Revisión anual GNV', 'Conversión a GNV', 'Desmonte de Cilindro', 'Duplicado GNV'];

        $certificaciones = DB::table('certificacion')
            ->select(
                'users.name as nombre',
                'tiposervicio.descripcion as tiposervicio',
                'tiposervicio.id as idTipoServicio',
                'certificacion.estado',
                'certificacion.pagado',
                DB::raw('COUNT(tiposervicio.descripcion) as cantidad_servicio'),
                DB::raw('SUM(certificacion.precio) as total_precio'),
                DB::raw('DAYOFWEEK(certificacion.created_at) as dia_semana')
            )
            ->join('users', 'certificacion.idInspector', '=', 'users.id')
            ->join('servicio', 'certificacion.idServicio', '=', 'servicio.id')
            ->join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
            ->where('certificacion.pagado', 0)
            ->whereIn('certificacion.estado', [3, 1])
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaCerti($query);
            })
            ->groupBy('nombre', 'tiposervicio.descripcion', 'tiposervicio.id', 'certificacion.pagado', 'certificacion.estado', 'dia_semana')
            ->get();

        $certificadosPendientes = DB::table('certificados_pendientes')
            ->select(
                'users.name as nombre',
                'tiposervicio.id as idTipoServicio',
                'certificados_pendientes.estado',
                'certificados_pendientes.pagado',
                DB::raw("'Activación de chip (Anual)' as tiposervicio"),
                DB::raw('COUNT("Activación de chip (Anual)") as cantidad_servicio'),
                DB::raw('SUM(certificados_pendientes.precio) as total_precio'),
                DB::raw('DAYOFWEEK(certificados_pendientes.created_at) as dia_semana')
            )
            ->Join('users', 'certificados_pendientes.idInspector', '=', 'users.id')
            ->Join('servicio', 'certificados_pendientes.idServicio', '=', 'servicio.id')
            ->Join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
            ->where('certificados_pendientes.estado', 1)
            ->whereNull('certificados_pendientes.idCertificacion')
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaCeriPendi($query);
            })

            ->groupBy('nombre', 'tiposervicio', 'tiposervicio.id', 'certificados_pendientes.pagado', 'certificados_pendientes.estado', 'dia_semana')
            ->get();

        $resultados = []; //collect()
        $tiposServiciosDeseados = ['Revisión anual GNV', 'Conversión a GNV', 'Desmonte de Cilindro', 'Duplicado GNV'];

        foreach ($certificaciones as $certificacion) {
            $key = $certificacion->nombre . '_' . $certificacion->tiposervicio . '_' . $certificacion->idTipoServicio;

            if (!isset($resultados[$key])) {
                $resultados[$key] = (object)[
                    'nombreInspector' => $certificacion->nombre,
                    'tiposervicio' => $certificacion->tiposervicio,
                    'dias' => [
                        1 => 0, // Domingo
                        2 => 0, // Lunes
                        3 => 0, // Martes
                        4 => 0, // Miércoles
                        5 => 0, // Jueves
                        6 => 0, // Viernes
                        7 => 0, // Sábado
                    ],
                    'total' => 0,
                    'total_certificacion' => 0,
                    'pagado' => 0,
                    'estado' => 0,
                ];
            }

            $resultados[$key]->dias[$certificacion->dia_semana] += $certificacion->cantidad_servicio;
            $resultados[$key]->total += $certificacion->cantidad_servicio;
            if (in_array($certificacion->tiposervicio, $tiposServiciosDeseados)) {
                $resultados[$key]->total_certificacion += $certificacion->total_precio;
            }
        }

        foreach ($certificadosPendientes as $certificado) {
            $key = $certificado->nombre . '_' . $certificado->tiposervicio . '_' . $certificado->idTipoServicio;

            if (!isset($resultados[$key])) {
                $resultados[$key] = (object)[
                    'nombreInspector' => $certificado->nombre,
                    'tiposervicio' => $certificado->tiposervicio,
                    'dias' => [
                        1 => 0, // Domingo
                        2 => 0, // Lunes
                        3 => 0, // Martes
                        4 => 0, // Miércoles
                        5 => 0, // Jueves
                        6 => 0, // Viernes
                        7 => 0, // Sábado
                    ],
                    'total' => 0,
                    'total_certificacion' => 0,
                    'pagado' => 0,
                    'estado' => 0,
                ];
            }

            $resultados[$key]->dias[$certificado->dia_semana] += $certificado->cantidad_servicio;
            $resultados[$key]->total += $certificado->cantidad_servicio;
            //$resultados[$key]->total_certificacion += $certificado->total_precio;
            if (in_array($certificado->tiposervicio, $tiposServiciosDeseados)) {
                $resultados[$key]->total_certificacion += $certificado->total_precio;
            }
        }


        $inspectorTotals = $this->acumularTotales($resultados);
        $this->inspectorTotals = $inspectorTotals;
        $this->resultados = array_values($resultados); //->toArray()
        $this->tipoServicios = $this->agruparTipoServicio($this->resultados);
        Cache::put('reporteCalcularSimple', $this->inspectorTotals, now()->addMinutes(10));
    }

    public function agruparTipoServicio($resultados)
    {
        $tipoServicios = [];

        foreach ($resultados as $detalle) {
            if (!isset($tipoServicios[$detalle->tiposervicio])) {
                $tipoServicios[$detalle->tiposervicio] = (object) [
                    'total_dias' => array_sum($detalle->dias),
                    'dias' => $detalle->dias,
                    'total' => $detalle->total,
                ];
            } else {
                $tipoServicios[$detalle->tiposervicio]->total_dias += array_sum(
                    $detalle->dias,
                );
                $tipoServicios[$detalle->tiposervicio]->total +=
                    $detalle->total;
                foreach ($detalle->dias as $dia => $cantidad) {
                    $tipoServicios[$detalle->tiposervicio]->dias[$dia] += $cantidad;
                }
            }
        }

        return $tipoServicios;
    }

    private function acumularTotales($resultados)
    {
        $inspectorTotals = [];

        foreach ($resultados as $inspector) {

            // Verificamos si ya hemos procesado este inspector
            if (!isset($inspectorTotals[$inspector->nombreInspector])) {
                $inspectorTotals[$inspector->nombreInspector] = [
                    'AnualGnv' => 0,
                    'ConversionGnv' => 0,
                    'Desmonte' => 0,
                    'Duplicado' => 0,
                    'Total' => 0,
                ];
            }

            // Acumulamos los resultados según el tipo de servicio
            switch ($inspector->tiposervicio) {
                case 'Revisión anual GNV':
                    $inspectorTotals[$inspector->nombreInspector]['AnualGnv'] += $inspector->total;
                    break;
                case 'Conversión a GNV':
                    $inspectorTotals[$inspector->nombreInspector]['ConversionGnv'] += $inspector->total;
                    break;
                case 'Desmonte de Cilindro':
                    $inspectorTotals[$inspector->nombreInspector]['Desmonte'] += $inspector->total;
                    break;
                case 'Duplicado GNV':
                    $inspectorTotals[$inspector->nombreInspector]['Duplicado'] += $inspector->total;
                    break;
            }

            // Acumulamos el total general
            $inspectorTotals[$inspector->nombreInspector]['Total'] += $inspector->total_certificacion;
        }
        return $inspectorTotals;
    }

    /*public function exportarExcelSimple2()
    {
        $data = Cache::get('reporteCalcularSimple');

        if ($data) {
            $exportData = [];

            foreach ($data as $inspectorName => $totals) {
                $exportData[] = [
                    'Inspector' => $inspectorName,
                    'Anual Gnv' => $totals['AnualGnv'],
                    'Conversion Gnv' => $totals['ConversionGnv'],
                    'Desmonte' => $totals['Desmonte'],
                    'Duplicado' => $totals['Duplicado'],
                    'Total' =>  'S/' . number_format($totals['Total'], 2, '.', ''),
                ];
            }

            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteCalcularSimpleExport($exportData), 'ReporteCalcular' . $fecha . '.xlsx');
        }
    }*/

    public function exportarExcelSimple()
    {
        $inspectorTotals = $this->inspectorTotals;

        if (!empty($inspectorTotals)) {
            $exportData = [];

            foreach ($inspectorTotals as $inspectorName => $totals) {
                $exportData[] = [
                    'Inspector' => $inspectorName,
                    'Anual Gnv' => $totals['AnualGnv'],
                    'Conversion Gnv' => $totals['ConversionGnv'],
                    'Desmonte' => $totals['Desmonte'],
                    'Duplicado' => $totals['Duplicado'],
                    'Total' =>  'S/' . number_format($totals['Total'], 2, '.', ''),
                ];
            }

            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteCalcularSimpleExport($exportData), 'ReporteCalcular' . $fecha . '.xlsx');
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

    private function agregarFiltros($query)
    {
        if (!empty($this->ins)) {
            $query->whereIn('idInspector', $this->ins);
        }

        if (!empty($this->taller)) {
            $query->whereIn('idTaller', $this->taller);
        }
    }


    public function taller()
    {
        $certificaciones = DB::table('certificacion')
            ->select(
                'certificacion.id',
                'certificacion.idTaller',
                'certificacion.idInspector',
                'certificacion.idServicio',
                'certificacion.estado',
                'certificacion.created_at',
                'certificacion.precio',
                'certificacion.pagado',
                'users.name as nombre',
                'taller.nombre as taller',
                'vehiculo.placa as placa',
                'tiposervicio.descripcion as tiposervicio',


            )
            ->join('users', 'certificacion.idInspector', '=', 'users.id')
            ->join('taller', 'certificacion.idTaller', '=', 'taller.id')
            ->join('vehiculo', 'certificacion.idVehiculo', '=', 'vehiculo.id')
            ->join('servicio', 'certificacion.idServicio', '=', 'servicio.id')
            ->join('tiposervicio', 'servicio.tipoServicio_idtipoServicio', '=', 'tiposervicio.id')
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

        $vertaller = $certificaciones->concat($certificadosPendientes);
        $totalPrecio = $vertaller->sum('precio');
        $this->vertaller = $vertaller;
        $this->totalPrecio = $totalPrecio;
        // Agrupar por inspector
        $this->reporteTaller = $vertaller->groupBy('idTaller');
    }
}
