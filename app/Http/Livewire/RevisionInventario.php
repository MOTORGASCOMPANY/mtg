<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Auth;
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

        $usuarios = User::whereIn('id', $materiales->keys())->orderBy('name')->get()->keyBy('id');

        $resumen = $materiales->map(function ($materiales, $idUsuario) use ($usuarios) {
            return [
                'usuario' => $usuarios[$idUsuario]->name ?? 'Desconocido',
                'materiales' => $materiales
            ];
        });
    
        $this->resumen = $resumen->sortBy('usuario')->values();
    }
}
