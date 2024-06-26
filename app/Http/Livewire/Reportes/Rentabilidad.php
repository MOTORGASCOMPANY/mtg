<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteRentabilidadExport;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\TipoServicio;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rentabilidad extends Component
{
    public $talleres, $inspectores, $tipos;
    public $taller = [], $ins = [], $servicio, $fechaInicio, $fechaFin;
    public $tabla, $diferencias, $importados, $tabla2;
    public $grupotalleres;
    public $ingresosPorTaller = [];
    public $certificacionesPorTaller = [];
    public $ingresosPorServicio = [];
    public $ingresosMensuales = [];
    public $rentabilidadPorTaller, $totalRentabilidad, $costosPorTaller;
    public $ajustarIngresos = false, $ajustarCostos = false, $gastosAdministrativos = 0;

    protected $listeners = ['exportarExcel'];

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
        "taller" => 'required'
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])
            ->where('id', '!=', 201)
            ->orderBy('name')
            ->get();
        $this->talleres = Taller::orderBy('nombre')->get();
        $this->tipos = TipoServicio::all();
        //$this->tabla2 = collect(); // Inicializar tabla2 como una colección vacía
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
        //$this->tabla2 = $this->importados->merge($servisrestantes);    

        $this->generarReporte();
    }

    public function generarReporte()
    {
        $this->ingresosPorTaller = $this->calcularIngresosPorTaller();
        $this->certificacionesPorTaller = $this->calcularCertificacionesPorTaller();
        $this->ingresosPorServicio = $this->calcularIngresosPorServicio();
        $this->costosPorTaller = $this->calcularCostosPorTaller();
        //$this->rentabilidadPorTaller = $this->calcularRentabilidadPorTaller();
        $this->rentabilidadPorTaller = $this->calcularRentabilidadPorTaller($this->ajustarIngresos, $this->ajustarCostos);
        //$this->totalRentabilidad = $this->calcularTotalRentabilidad();
        $this->totalRentabilidad = $this->calcularTotalRentabilidad($this->ajustarIngresos, $this->ajustarCostos);
    }

    public function render()
    {
        return view('livewire.reportes.rentabilidad', [
            'ingresosPorTaller' => $this->ingresosPorTaller,
            'certificacionesPorTaller' => $this->certificacionesPorTaller,
            'ingresosPorServicio' => $this->ingresosPorServicio,
            'costosPorTaller' => $this->costosPorTaller,
            'rentabilidadPorTaller' => $this->rentabilidadPorTaller,
            'totalRentabilidad' => $this->totalRentabilidad,
        ]);
    }

    // INGRESOS TOTALES POR TALLER
    private function calcularIngresosPorTaller()
    {
        return $this->tabla2->groupBy('taller')->map(function ($items, $taller) {
            return [
                'taller' => $taller,
                'ingresos_totales' => $items->sum('precio')
            ];
        })->sortByDesc('ingresos_totales')->values()->toArray();
    }

    // NUMERO DE CERTIFICACIONES REALIZADAS POR TALLER
    private function calcularCertificacionesPorTaller()
    {
        return $this->tabla2->groupBy('taller')->map(function ($items, $taller) {
            return [
                'taller' => $taller,
                'total_certificaciones' => $items->count()
            ];
        })->sortByDesc('total_certificaciones')->values()->toArray();
    }

    // INGRESOS POR TIPO DE SERVICIO POR TALLER
    private function calcularIngresosPorServicio()
    {
        // Verificación inicial de los datos
        $tabla2 = $this->tabla2->map(function ($item) {
            return [
                'taller' => $item['taller'],
                'servicio' => $item['servicio'],
                'precio' => $item['precio'],
            ];
        });

        // Agrupamos por taller y luego por servicio
        $ingresosPorServicio = $tabla2->groupBy('taller')->map(function ($items, $taller) {
            return $items->groupBy('servicio')->map(function ($items, $servicio) use ($taller) {
                return [
                    'taller' => $taller,
                    'servicio' => $servicio,
                    'cantidad' => $items->count(),
                    'ingresos_totales' => $items->sum('precio')
                ];
            })->values()->toArray();
        })->flatten(1)->sortByDesc('ingresos_totales')->values()->toArray();
        //dd($ingresosPorServicio);

        return $ingresosPorServicio;
    }

    //COSTOS TOTALES POR TALLER
    private function calcularCostosPorTaller()
    {
        return $this->tabla2->groupBy('taller')->map(function ($items, $taller) {
            $sueldosInspector = 1500;
            $gratificacion = 125;

            /*$hojas = $items->filter(function ($item) {
                return $item['servicio'] !== 'Chip por deterioro';
            })->count() * 0.50;*/

            $hojas = $items->filter(function ($item) {
                return $item['servicio'] !== 'Chip por deterioro' && $item['servicio'] !== 'Desmonte de Cilindro';
            })->count() * 0.50;

            $chips = $items->filter(function ($item) {
                return in_array($item['servicio'], ['Conversión a GNV + Chip', 'Chip por deterioro']);
            })->count() * 20;

            $serviciosAnualCofide = $items->filter(function ($item) {
                return $item['servicio'] === 'Revisión anual GNV';
            })->count() * 2.34;

            $serviciosInicialCofide = $items->filter(function ($item) {
                return $item['servicio'] === 'Conversión a GNV';
            })->count() * 5.46;

            $costosTotales = $sueldosInspector + $gratificacion + $hojas + $chips + $serviciosAnualCofide + $serviciosInicialCofide;

            return [
                'taller' => $taller,
                'sueldos_inspector' => $sueldosInspector,
                'gratificacion' => $gratificacion,
                'hojas' => $hojas,
                'chips' => $chips,
                'servicios_anual_cofide' => $serviciosAnualCofide,
                'servicios_inicial_cofide' => $serviciosInicialCofide,
                'costos_totales' => $costosTotales
            ];
        })->sortByDesc('costos_totales')->values()->toArray();
    }

    // CALCULAR RENTABILIDAD POR TALLER
    private function calcularRentabilidadPorTaller($ajustarIngresos = false, $ajustarCostos = false)
    {
        $ingresostotales = $this->calcularIngresosPorTaller();
        $costostotales = $this->calcularCostosPorTaller();

        $rentabilidad = collect($ingresostotales)->map(function ($ingreso) use ($costostotales, $ajustarIngresos, $ajustarCostos) {
            $taller = $ingreso['taller'];
            $costos = collect($costostotales)->firstWhere('taller', $taller);
            $costosTotales = $costos['costos_totales'] ?? 0;

            if ($ajustarIngresos) {
                $ingreso['ingresos_totales'] *= 0.82; // Reducir en 18% (IGV)
            }

            if ($ajustarCostos) {
                $costosTotales += 135 + 125; // Sumar Essalud y CTS
            }

            $gastosAdministrativos = floatval($this->gastosAdministrativos);
            $costosTotales += $gastosAdministrativos; // Sumar Gastos Administrativos

            $rentabilidad = $ingreso['ingresos_totales'] - $costosTotales;

            return [
                'taller' => $taller,
                'ingresos_totales' => $ingreso['ingresos_totales'],
                'costos_totales' => $costosTotales,
                'rentabilidad' => $rentabilidad
            ];
        })->sortByDesc('rentabilidad')->values()->toArray();

        return $rentabilidad;
    }

    /*private function calcularRentabilidadPorTaller()
     {
        $ingresostotales = $this->calcularIngresosPorTaller();
        $costostotales = $this->calcularCostosPorTaller();
        // Combinar datos de ingresos y costos
        $rentabilidad = collect($ingresostotales)->map(function ($ingreso) use ($costostotales) {
            $taller = $ingreso['taller'];
            $costos = collect($costostotales)->firstWhere('taller', $taller);
            $costosTotales = $costos['costos_totales'] ?? 0;

            $rentabilidad = $ingreso['ingresos_totales'] - $costosTotales;

            return [
                'taller' => $taller,
                'ingresos_totales' => $ingreso['ingresos_totales'],
                'costos_totales' => $costosTotales,
                'rentabilidad' => $rentabilidad
            ];
        })->sortByDesc('rentabilidad')->values()->toArray();

        return $rentabilidad;
     }
    */

    //ACTUALIZAR CHECKBOX
    public function updatedAjustarIngresos()
    {
        $this->generarReporte();
    }

    public function updatedAjustarCostos()
    {
        $this->generarReporte();
    }

    public function updatedGastosAdministrativos($value)
    {
        $this->gastosAdministrativos = floatval($value);
        $this->generarReporte();
    }

    //TOTAL RENTABILIDAD TALLER
    private function calcularTotalRentabilidad($ajustarIngresos = false, $ajustarCostos = false, $gastosAdministrativos = 0)
    {
        $rentabilidadPorTaller = $this->calcularRentabilidadPorTaller($ajustarIngresos, $ajustarCostos, $gastosAdministrativos);
        $totalRentabilidad = collect($rentabilidadPorTaller)->sum('rentabilidad');

        return $totalRentabilidad;
    }

    //EXPORTAR A EXCELL
    public function exportarExcel($data)
    {
        //dd($data);
        $fecha = $this->fechaInicio . 'al' . $this->fechaFin;
        return Excel::download(new ReporteRentabilidadExport($data), 'Rentabilidad del '. $fecha . '.xlsx');
    }

    // CARGAMOS DATA DE CERTIFICACION Y CERTIFICADOS_PENDIENTES
    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            ->IdTipoServicio($this->servicio)
            // Excluir al inspector con id = 201 
            /*->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [37, 117, 201]);
                })*/
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('pagado', 0)
            ->whereIn('estado', [3, 1])
            ->get();

        //TODO CER-PENDIENTES:
        $cerPendiente = CertificacionPendiente::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            /*->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [37, 117, 201]);
                })*/
            ->IdTipoServicios($this->servicio)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
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
                "inspector" => $cert_pend->Inspector->name,
                "servicio" => 'Activación de chip (Anual)', // es ese tipo de servicio por defecto
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
        return $tabla;
    }

    // DIFERENCIAS ENTRE LISTA 1 (generaData) Y LISTA 2 (cargaServiciosGasolution)
    public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
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

    // CARGAMOS DATA DE SERVICIOS_IMPORTADOS
    public function cargaServiciosGasolution()
    {
        $disc = new Collection();
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
                "externo" => Null,
                "tipo_modelo" => $registro::class,
                "fecha" => $registro->fecha,
            ];
            $disc->push($data);
        }
        return $disc;
    }
}
