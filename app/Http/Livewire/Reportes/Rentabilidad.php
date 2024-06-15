<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Taller;
use App\Models\TipoServicio;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rentabilidad extends Component
{
    public $talleres, $inspectores, $certis, $tipos;
    public $taller = [];
    public $ins = [];
    public $servicio;
    public $fechaInicio;
    public $fechaFin;
    public $mostrarResultados = false;

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
    }

    public function generarReporte()
    {
        $this->validate();
        $this->mostrarResultados = true; 
    }

    public function render()
    {
        $ingresosPorTaller = [];
        $certificacionesPorTaller = [];
        $ingresosPorServicio = [];
        $ingresosMensuales = [];

        if ($this->mostrarResultados) {
            $ingresosPorTallerQuery = DB::table('certificacion as c')
                ->join('taller as t', 'c.idTaller', '=', 't.id')
                ->select('t.id as taller_id', DB::raw('MAX(t.nombre) as nombre_taller'), DB::raw('SUM(c.precio) as ingresos_totales'))
                ->where('c.pagado', 0);

            $certificacionesPorTallerQuery = DB::table('certificacion as c')
                ->join('taller as t', 'c.idTaller', '=', 't.id')
                ->select('t.id as taller_id', DB::raw('MAX(t.nombre) as nombre_taller'), DB::raw('COUNT(c.id) as total_certificaciones'))
                ->groupBy('t.id')
                ->orderBy('total_certificaciones', 'DESC');

            $ingresosPorServicioQuery = DB::table('certificacion as c')
                ->join('taller as t', 'c.idTaller', '=', 't.id')
                ->join('servicio as s', 'c.idServicio', '=', 's.id')
                ->join('tiposervicio as ts', 's.tipoServicio_idtipoServicio', '=', 'ts.id')
                ->select('t.id as taller_id', DB::raw('MAX(t.nombre) as nombre_taller'), 'ts.descripcion as tipo_servicio', DB::raw('SUM(c.precio) as ingresos_totales'))
                ->where('c.pagado', 0)
                ->groupBy('t.id', 'ts.descripcion')
                ->orderBy('ingresos_totales', 'DESC');

            $ingresosMensualesQuery = DB::table('certificacion as c')
                ->join('taller as t', 'c.idTaller', '=', 't.id')
                ->select('t.id as taller_id', DB::raw('MAX(t.nombre) as nombre_taller'), DB::raw("DATE_FORMAT(c.created_at, '%Y-%m') as mes"), DB::raw('SUM(c.precio) as ingresos_mensuales'))
                ->where('c.pagado', 0)
                ->groupBy('t.id', DB::raw("DATE_FORMAT(c.created_at, '%Y-%m')"))
                ->orderBy('t.id')
                ->orderBy('mes');

            // Aplicar filtros
            if (!empty($this->taller)) {
                $ingresosPorTallerQuery->whereIn('t.id', $this->taller);
                $certificacionesPorTallerQuery->whereIn('t.id', $this->taller);
                $ingresosPorServicioQuery->whereIn('t.id', $this->taller);
                $ingresosMensualesQuery->whereIn('t.id', $this->taller);
            }

            if (!empty($this->ins)) {
                $ingresosPorTallerQuery->whereIn('c.idInspector', $this->ins);
                $certificacionesPorTallerQuery->whereIn('c.idInspector', $this->ins);
                $ingresosPorServicioQuery->whereIn('c.idInspector', $this->ins);
                $ingresosMensualesQuery->whereIn('c.idInspector', $this->ins);
            }

            if ($this->servicio) {
                $ingresosPorServicioQuery->where('s.id', $this->servicio);
            }

            if ($this->fechaInicio) {
                $ingresosPorTallerQuery->where('c.created_at', '>=', $this->fechaInicio);
                $certificacionesPorTallerQuery->where('c.created_at', '>=', $this->fechaInicio);
                $ingresosPorServicioQuery->where('c.created_at', '>=', $this->fechaInicio);
                $ingresosMensualesQuery->where('c.created_at', '>=', $this->fechaInicio);
            }

            if ($this->fechaFin) {
                $ingresosPorTallerQuery->where('c.created_at', '<=', $this->fechaFin);
                $certificacionesPorTallerQuery->where('c.created_at', '<=', $this->fechaFin);
                $ingresosPorServicioQuery->where('c.created_at', '<=', $this->fechaFin);
                $ingresosMensualesQuery->where('c.created_at', '<=', $this->fechaFin);
            }

            // Obtener resultados
            $ingresosPorTaller = $ingresosPorTallerQuery->groupBy('t.id')->orderBy('ingresos_totales', 'DESC')->get();
            $certificacionesPorTaller = $certificacionesPorTallerQuery->get();
            $ingresosPorServicio = $ingresosPorServicioQuery->get();
            $ingresosMensuales = $ingresosMensualesQuery->get();
        }

        return view('livewire.reportes.rentabilidad', compact('ingresosPorTaller', 'certificacionesPorTaller', 'ingresosPorServicio', 'ingresosMensuales'));
    }
}
