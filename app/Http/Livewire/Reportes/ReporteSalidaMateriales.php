<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteMarterialesExport;
use App\Models\Material;
use App\Models\Salida;
use App\Models\Taller;
use App\Models\TipoMaterial;
use App\Models\TipoServicio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReporteSalidaMateriales extends Component
{
    public $fechaInicio, $fechaFin, $resultados, $inspectores, $inspectores2, $certis, $tipos;
    public $ins, $ins2;
    public $user;
    public $mat;
    use WithPagination;

    public function mount()
    {
        $this->inspectores2 = User::orderBy('name')->get();
        $this->inspectores = User::role(['inspector', 'supervisor'])
            ->where('id', '!=', 201)
            ->orderBy('name')
            ->get();
        $this->user = Auth::user();
        $this->tipos = TipoMaterial::all();
    }

    public function render(){
        return view('livewire.reportes.reporte-salida-materiales');
    }

    /*public function render()
    {
        $materiales=Material::where([["idTipoMaterial",1]])->paginate(20);
        return view('livewire.reportes.reporte-salida-materiales',compact("materiales"));
    }*/   

    public function procesar()
    {
        $query = Salida::query()
        ->when($this->mat, function ($query) {
            $query->whereHas('materiales2.tipo', function ($query) {
                $query->where('id', $this->mat);
            });
        });

        if ($this->fechaInicio) {
            $query->where('created_at', '>=', $this->fechaInicio);
        }

        if ($this->fechaFin) {
            $query->where('created_at', '<=', $this->fechaFin);
        }

        if ($this->ins) {
            $query->where('idUsuarioAsignado', $this->ins);
        }
        if ($this->ins2) {
            $query->where('idUsuarioSalida', $this->ins2);
        }

        
        $this->resultados = $query->get();
    }

    public function exportarExcel(){
        
        return Excel::download(new ReporteMarterialesExport, 'Reporte_material.xlsx');
    }
}
