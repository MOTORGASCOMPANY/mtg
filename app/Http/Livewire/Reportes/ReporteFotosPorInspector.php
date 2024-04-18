<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Exports\ReporteFotosPorInspectorExport;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ReporteFotosPorInspector extends Component
{
    public $fechaInicio, $fechaFin, $inspectoresConFotos;

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];


    public function render()
    {
        return view('livewire.reportes.reporte-fotos-por-inspector');
    }

    /*public function generarReporte()
    {
        $this->validate();

        $inspectoresConFotos = DB::table('expedientes')
            ->select(
                'users.name as nombreInspector',
                'expedientes.placa',
                DB::raw('(@row_number := @row_number + 1) AS `index`'),
                DB::raw('COUNT(DISTINCT imagenes.id) as fotosSubidas')
            )
            ->leftJoin('users', 'expedientes.usuario_idusuario', '=', 'users.id')
            ->leftJoin('imagenes', 'expedientes.id', '=', 'imagenes.Expediente_idExpediente')
            ->crossJoin(DB::raw('(SELECT @row_number := 0) AS init'))
            ->groupBy('nombreInspector', 'expedientes.placa')
            ->whereBetween('expedientes.created_at', [$this->fechaInicio . ' 00:00:00', $this->fechaFin . ' 23:59:59'])
            ->get();

        $this->inspectoresConFotos = $inspectoresConFotos;
        Cache::put('inspectoresConFotos_copy', $this->inspectoresConFotos, now()->addMinutes(10));
    }*/

    public function generarReporte2()
    {
        $this->validate();

        $inspectoresConFotos = DB::table('expedientes')
            ->select(
                'users.name as nombreInspector',
                DB::raw('(@row_number := @row_number + 1) AS `index`'),
                DB::raw('COUNT(DISTINCT expedientes.id) as totalExpedientes'),
                DB::raw('COUNT(DISTINCT CASE WHEN imagenes.id IS NOT NULL AND imagenes.extension = "jpg" THEN expedientes.id END) as expedientesConFotos'),
                DB::raw('CONCAT(ROUND((COUNT(DISTINCT CASE WHEN imagenes.id IS NOT NULL AND imagenes.extension = "jpg" THEN expedientes.id END) / COUNT(DISTINCT expedientes.id)) * 100, 0), "%") as porcentaje')
            )
            ->leftJoin('users', 'expedientes.usuario_idusuario', '=', 'users.id')
            ->leftJoin('imagenes', 'expedientes.id', '=', 'imagenes.Expediente_idExpediente')
            ->crossJoin(DB::raw('(SELECT @row_number := 0) AS init'))
            ->groupBy('nombreInspector')
            ->whereBetween('expedientes.created_at', [$this->fechaInicio . ' 00:00:00', $this->fechaFin . ' 23:59:59'])
            ->get();

        $this->inspectoresConFotos = $inspectoresConFotos;
        Cache::put('inspectoresConFotos_copy', $this->inspectoresConFotos, now()->addMinutes(10));
    }




    public function exportarExcel()
    {
        $data = Cache::get('inspectoresConFotos_copy');

        if ($data) {
            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteFotosPorInspectorExport($data), 'Reporte_fotos_por_inspector_' . $fecha . '.xlsx');
        }
    }
}
