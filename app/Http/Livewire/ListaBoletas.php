<?php

namespace App\Http\Livewire;

use App\Models\Boleta;
use App\Models\Taller;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;

class ListaBoletas extends Component
{
    use WithPagination;
    public $sort, $direction, $cant, $search;
    public $fechaInicio, $fechaFin;
    public $openEdit = false, $boleta;
    //para filtros
    public $inspectores, $talleres, $ins, $ta;
    protected $listeners = ['render', 'eliminarBoleta'];

    protected $rules = [
        "boleta.taller" => "nullable",
        "boleta.certificador" => "nullable",
        "boleta.fechaInicio" => "required",
        "boleta.fechaFin" => "required",
        "boleta.monto" => "required",
        "boleta.anual" => "nullable",
        "boleta.duplicado" => "nullable",
        "boleta.inicial" => "nullable",
        "boleta.desmonte" => "nullable",
        "boleta.observacion" => "nullable",
    ];

    public function mount()
    {
        $this->direction = 'asc';
        $this->sort = 'id';
        $this->cant = 50;
        //Para filtros
        $this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->talleres = Taller::all()->sortBy('nombre');
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

    public function render()
    {
        $query = Boleta::query();

        // Aplicar los scopes para filtros taller e inspector
        if (!empty($this->ta)) {
            $query->Talleres($this->ta);
        }
        if (!empty($this->ins)) {
            $query->Inspectores($this->ins);
        }

        // Verificar si las fechas no son nulas
        if ($this->fechaInicio && $this->fechaFin) {
            $query->RangoFecha($this->fechaInicio, $this->fechaFin);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('taller', 'like', '%' . $this->search . '%')
                    ->orWhere('certificador', 'like', '%' . $this->search . '%');
            });
        }

        $boletas = $query->orderBy($this->sort, $this->direction)->paginate($this->cant);

        return view('livewire.lista-boletas', compact('boletas'));
    }


    public function abrirModal($id)
    {
        $this->boleta = Boleta::findOrFail($id);

        // Establece desmonte, anual, duplicado e inicial a 0 si son null
        if (is_null($this->boleta->desmonte)) {
            $this->boleta->desmonte = 0;
        }
        if (is_null($this->boleta->anual)) {
            $this->boleta->anual = 0;
        }
        if (is_null($this->boleta->duplicado)) {
            $this->boleta->duplicado = 0;
        }
        if (is_null($this->boleta->inicial)) {
            $this->boleta->inicial = 0;
        }

        $this->openEdit = true;
    }

    public function editarBoleta()
    {
        $this->validate();
        $this->boleta->save();
        $this->emit("CustomAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Boleata actualizada correctamente", "icono" => "success"]);
        $this->reset(['openEdit', 'boleta']);
        //$this->refrescaBoleta();
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
        return redirect()->route('ImportarBoletas');
    }
}
