<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteMarterialesExport;
use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReporteMateriales extends Component
{
    use WithPagination;

    public function render()
    {
        $materiales=Material::where([["idTipoMaterial",1]])->paginate(20);
        //dd($materiales);
        return view('livewire.reportes.reporte-materiales',compact("materiales"));
    }

    /*public function exportarExcel(){
        
        return Excel::download(new ReporteMarterialesExport, 'Reporte_material.xlsx');
    }*/
}
