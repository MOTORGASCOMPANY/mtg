<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteCumplimentoExport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;


class ReporteServiciosPorInspector extends Component
{
    public $fechaInicio, $fechaFin, $services,$exportar;

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];


    public function mount(){
        //$this->services= new Collection();
    }
    public function render()
    {
        return view('livewire.reportes.reporte-servicios-por-inspector');
    }

    public function generarReporte()
    {
        $this->validate();
        /*
        $services = DB::table('servicios_importados')
        ->select(

            'servicios_importados.certificador',
            'ROW_NUMBER() OVER (ORDER BY servicios_importados.certificador) AS index',
            DB::raw('count(placa) as serviciosGasolution'),
            DB::raw('SUM(if(estado = 2, 1, 0)) AS serviciosMtg'),
            DB::raw('ROUND((SUM(if(estado = 2, 1, 0)) / count(placa) * 100), 1) AS porcentaje')
        )
        ->groupBy('certificador')
        ->whereBetween('fecha', [$this->fechaInicio . ' 00:00', $this->fechaFin . ' 23:59'])
        ->get();*/
        $services=DB::table('servicios_importados')
        ->select(
            'servicios_importados.certificador',
            DB::raw('(@row_number := @row_number + 1) AS `index`'),
            DB::raw('count(placa) as serviciosGasolution'),
            DB::raw('SUM(if(estado = 2, 1, 0)) AS serviciosMtg'),
            DB::raw('ROUND((SUM(if(estado = 2, 1, 0)) / count(placa) * 100), 1) AS porcentaje')
        )
        ->crossJoin(DB::raw('(SELECT @row_number := 0) AS init'))
        ->groupBy('certificador')
        ->whereBetween('fecha', [$this->fechaInicio . ' 00:00', $this->fechaFin . ' 23:59'])
        ->where ('tipoServicio', '!=' ,6)
        ->get();



        $this->services = $services;
        Cache::put('services_copy', $this->services, now()->addMinutes(10)); // Almacena $services en caché durante 10 minutos
    }

    public function calculaPorcentaje($total, $tiene)
    {
        $resultado = 0;
        if ($tiene != 0) {
            $resultado = ($tiene * 100) / $total;
        }
        return round($resultado, 1);
    }

   public function updated($nameProperty)
    {
        $this->validateOnly($nameProperty);

        if ($nameProperty) {

            $this->reset(["services"]);
        }
    }

    public function exportaExcel()
    {
        $data = Cache::get('services_copy');

        if ($data) {
            $fecha = now()->format('d-m-Y');
            return Excel::download(new ReporteCumplimentoExport($data), 'Reporte_servicios_por_inspector_' . $fecha . '.xlsx');
        }
    }


}
