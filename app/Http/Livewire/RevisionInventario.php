<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RevisionInventario extends Component
{

    public $inspector, $inspectores, $tipoMaterial;
    public $resultado;
    //variable para resumen
    public $resumen;

    protected $rules = [
        "inspector" => "required|numeric|min:1"
    ];

    public function render()
    {
        return view('livewire.revision-inventario');
    }

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])
            ->where('id', '!=', Auth::id())
            ->orderBy('name')->get();
        //$this->resultado= new Collection();
    }

    public function consultar()
    {
        $this->validate();
        $this->resultado = Material::where("idUsuario", $this->inspector)
            ->TipoMaterialInvetariado($this->tipoMaterial)
            ->get();
    }

    public function updated($nameProperty)
    {
        $this->validateOnly($nameProperty);
        if ($nameProperty) {
            $this->reset(["resultado"]);
        }
    }

    public function resumen()
    {
        $materiales = Material::resumenInventario()->get()->groupBy('idUsuario');

        $usuarios = User::whereIn('id', $materiales->keys())
            ->orderBy('name')
            ->get()
            ->keyBy('id');

        // Obtener el conteo de materiales anulados agrupados por usuario
        $anulados = Material::where('estado', 5)
        ->whereNull('devuelto') 
        ->groupBy('idUsuario')
        ->select('idUsuario', DB::raw('count(*) as total_anulados'))
        ->pluck('total_anulados', 'idUsuario');

        //dd($anulados);

        // Combinar los datos de materiales en sctock y anulados
        $resumen = $materiales->map(function ($materiales, $idUsuario) use ($usuarios, $anulados) {
            return [
                'usuario' => $usuarios[$idUsuario]->name ?? 'Desconocido',
                'materiales' => $materiales,
                'anulados' => $anulados[$idUsuario] ?? 0,
            ];
        });

        $this->resumen = $resumen->sortBy('usuario')->values();
    }
}
