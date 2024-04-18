<?php

namespace App\Http\Livewire;

use App\Models\TipoMaterial;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ConsultarHoja extends Component
{
    public $numSerie, $resultados;
    public $desde, $hasta, $tipoMaterial;

    public function mount()
    {
    }

    protected $rules = [
        'desde' => 'required',
        'hasta' => 'required',
        'tipoMaterial' => 'required',
    ];

   
    public function render()
    {
        return view('livewire.consultar-hoja', [
            'tiposMaterial' => TipoMaterial::all(),
        ]);
    }

    public function buscar()
    {
        $this->validate();
        if (!empty($this->desde) && !empty($this->hasta)) {
            $query = DB::table('material')
                ->whereBetween('numSerie', [$this->desde, $this->hasta])
                ->leftJoin('users', 'material.idUsuario', '=', 'users.id')
                ->leftJoin('tipomaterial', 'material.idTipoMaterial', '=', 'tipomaterial.id')
                ->select(
                    'material.*',
                    'users.name as nombreUsuario',
                    'tipomaterial.descripcion as descripcionTipoMaterial'
                );

            //filtro de tipo de material
            if ($this->tipoMaterial) {
                $query->where('material.idTipoMaterial', $this->tipoMaterial);
            }

            $this->resultados = $query->get();
        } else {
        }
    }
}
