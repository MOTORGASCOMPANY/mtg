<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Desmontes;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActualizarPrecios extends Component
{
    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores;
    public $ins = [], $taller = [];
    public $totalPrecio, $reportePorInspector, $detallesPlacasFaltantes, $certificacionIds = [];
    public $editando, $tiposServicios = [], $serviciosImportados, $updatedPrices = [];
    
    protected $listeners = ['preciosActualizados' => 'recargarDatos'];

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->talleres = Taller::orderBy('nombre')->get(); //all()->sortBy('nombre')
    }

    public function render()
    {
        return view('livewire.actualizar-precios');
    }

    public function calcularReporte()
    {
        $this->validate();
        $resultadosdetalle = $this->datosMostrar();
        $totalPrecio = $resultadosdetalle->sum('precio');
        $this->totalPrecio = $totalPrecio;
        //$this->reportePorInspector = $resultadosdetalle->groupBy('idInspector');
        $this->reportePorInspector = $resultadosdetalle;
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

            ->Join('users', 'certificados_pendientes.idInspector', '=', 'users.id') //leftJoin
            ->Join('taller', 'certificados_pendientes.idTaller', '=', 'taller.id')
            ->Join('vehiculo', 'certificados_pendientes.idVehiculo', '=', 'vehiculo.id')
            ->Join('servicio', 'certificados_pendientes.idServicio', '=', 'servicio.id')
            ->where('certificados_pendientes.estado', 1)
            ->whereNull('certificados_pendientes.idCertificacion')
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaCeriPendi($query);
            })
            ->get();

        $desmonte = DB::table('desmontes')
            ->select(
                'desmontes.id',
                'desmontes.placa',
                'desmontes.idTaller',
                'desmontes.idInspector',
                'desmontes.idServicio',
                'desmontes.estado',
                'desmontes.created_at',
                'desmontes.pagado',
                'desmontes.precio',
                'users.name as nombre',
                'taller.nombre as taller',
                DB::raw("'Desmonte de Cilindro' as tiposervicio")
            )
            ->Join('users', 'desmontes.idInspector', '=', 'users.id')
            ->Join('taller', 'desmontes.idTaller', '=', 'taller.id')
            ->Join('servicio', 'desmontes.idServicio', '=', 'servicio.id')
            ->where('desmontes.estado', 1)
            ->where(function ($query) {
                $this->agregarFiltros($query);
            })
            ->where(function ($query) {
                $this->fechaDesmonte($query);
            })
            ->get();


        $resultadosdetalle = $certificaciones->concat($certificadosPendientes)->concat($desmonte);

        return $resultadosdetalle;
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

    private function fechaDesmonte($query)
    {
        return $query->whereBetween('desmontes.created_at', [
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

    public function ver($certificacionIds, $tiposServicios)
    {
        $this->certificacionIds = $certificacionIds;
        $this->tiposServicios = $tiposServicios;
        $this->editando = true;
    }

    /*public function updatePrecios()
    {
        if (count($this->updatedPrices) > 0) {
            foreach ($this->updatedPrices as $key => $nuevoPrecio) {
                $certificacionIds = $this->certificacionIds;

                // Actualizar precios en Certificacion
                Certificacion::whereIn('id', $certificacionIds)
                    ->whereHas('servicio', function ($query) use ($key) {
                        $query->whereHas('tipoServicio', function ($query) use ($key) {
                            $query->where('descripcion', $key);
                        });
                    })
                    ->update(['precio' => $nuevoPrecio]);

                // Actualizar precios en CertificacionPendiente
                CertificacionPendiente::whereIn('id', $certificacionIds)
                    ->update(['precio' => $nuevoPrecio]);
                //Actualizar precios en desmonte
                Desmontes::whereIn('id', $certificacionIds)
                    ->update(['precio' => $nuevoPrecio]);
            }

            // Emitir evento para indicar que los precios han sido actualizados
            $this->emit('preciosActualizados');

            // Refrescar solo la sección de la tabla
            $this->dispatchBrowserEvent('refresh-table');

            $this->reset(['resultados', 'updatedPrices', 'certificacionIds']);
            $this->calcularReporte();
            $this->editando = false;
        }
    }*/

    public function updatePrecios()
    {
        if (count($this->updatedPrices) > 0) {
            foreach ($this->updatedPrices as $tipoServicio => $nuevoPrecio) {
                $certificacionIds = $this->certificacionIds;
                switch ($tipoServicio) {
                    case 'Conversión a GNV':
                    case 'Revisión anual GNV':
                    case 'Conversión a GLP':
                    case 'Revisión anual GLP':
                    case 'Modificación':
                    case 'Duplicado GNV':
                    case 'Duplicado GLP':
                    case 'Conversión a GNV + Chip':
                    case 'Chip por deterioro': //revisar chip por deterioro
                    case 'Pre-conversión GNV':
                    case 'Pre-conversión GLP':
                        Certificacion::whereIn('id', $certificacionIds)
                            ->whereHas('servicio', function ($query) use ($tipoServicio) {
                                $query->whereHas('tipoServicio', function ($query) use ($tipoServicio) {
                                    $query->where('descripcion', $tipoServicio);
                                });
                            })
                            ->update(['precio' => $nuevoPrecio]);
                        break;

                    case 'Activación de chip (Anual)':
                        CertificacionPendiente::whereIn('id', $certificacionIds)
                            ->update(['precio' => $nuevoPrecio]);
                        break;

                    case 'Desmonte de Cilindro':
                        Desmontes::whereIn('id', $certificacionIds)
                            ->update(['precio' => $nuevoPrecio]);
                        break;

                    default:
                        // Manejo de error 
                        break;
                }
            }

            // Emitir evento para indicar que los precios han sido actualizados
            $this->emit('preciosActualizados');

            // Refrescar solo la sección de la tabla
            $this->dispatchBrowserEvent('refresh-table');

            $this->reset(['resultados', 'updatedPrices', 'certificacionIds']);
            $this->calcularReporte();
            $this->editando = false;
        }
    }


    public function recargarDatos()
    {
        $this->calcularReporte();
    }



}
