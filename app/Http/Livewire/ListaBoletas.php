<?php

namespace App\Http\Livewire;

use App\Models\Boleta;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;

class ListaBoletas extends Component
{
    use WithPagination;
    public $sort, $direction, $cant, $search;    
    protected $listeners = ['render', 'eliminarBoleta'];

    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
    }

    public function order($sort)
    {
        if ($this->sort = $sort) {
            $this->direction = ($this->direction === 'desc') ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    /*public function render()
    {
        return view('livewire.lista-boletas');
    }*/

    public function render()
    {
        $query = Boleta::query();

        if (!empty($this->search)) {
            $query->whereHas('taller', function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            });
        }

        $boletas = $query->orderBy($this->sort, $this->direction)->paginate($this->cant);

        return view('livewire.lista-boletas', compact('boletas'));
    }

    public function redirectBoletas($idBoleta)
    {
        return Redirect::to("Boletas/{$idBoleta}");
    }

    public function eliminarBoleta($idBoleta)
    {
        $boleta = Boleta::findOrFail($idBoleta);
        // Eliminar archivos relacionados
        $boleta->boletaarchivo()->delete();
        // Eliminar la boleta
        $boleta->delete();
        $this->emit('render');
    }
    
    public function agregar()
    {
        return redirect()->route('Boletas');
    }
}
