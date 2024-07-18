<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteMarterialesExport;
use App\Models\Material;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;

class ReporteInventario extends Component
{
    public $fechaInicio, $fechaFin, $inspectores, $inspector;
    public $tipoMaterial, $resultado, $estado;

    protected $listeners = ['exportarExcel'];

    protected $rules = [
        //"inspector"=>"required|numeric|min:1",
        "tipoMaterial"=>"required",
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])
            //->where('id', '!=', 201)
            ->orderBy('name')
            ->get();
        $this->fechaInicio = '';
        $this->fechaFin = '';
    }

    public function render()
    {
        return view('livewire.reportes.reporte-inventario');
    }

    public function consultar()
    {
        $this->validate();
        $this->resultado=Material::where("idUsuario",$this->inspector)
        ->TipoMaterialInvetariado($this->tipoMaterial)
        ->EstadoInvetariado($this->estado)
        ->RangoFecha($this->fechaInicio, $this->fechaFin)
        ->get();
    }

    public function exportarExcel($data)
    {
        //dd($data);
        return Excel::download(new ReporteMarterialesExport($data), 'reporte_inventario.xlsx');
    }
}
