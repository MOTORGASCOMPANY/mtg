<?php

namespace App\Http\Livewire;

use App\Models\Salida;
use Livewire\Component;
use Livewire\WithPagination;

class Salidas extends Component
{

    use WithPagination;

    public $sort, $direction, $cant, $search, $rol, $permisos, $cargando;

    protected $rules = ["cargando" => "nullable"];

    protected $listeners = ["eliminaSalidaAsignacion", "eliminaSalidaPrestamo"];

    /*public function render()
    {
        $salidas=Salida::where([["numero","like","%".$this->search."%"]])
        ->orderBy($this->sort,$this->direction)
        ->paginate($this->cant);
        return view('livewire.salidas',compact("salidas"));
    }*/
    
    public function render()
    {
        $salidas = Salida::where(function ($query) {
            $query->where('numero', 'like', '%' . $this->search . '%')
                ->orWhereHas('usuarioAsignado', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('motivo', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);

        return view('livewire.salidas', compact("salidas"));
    }


    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
    }

    public function order($sort)
    {
        if ($this->sort = $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function eliminaSalidaAsignacion(Salida $sal)
    {

        if ($sal->estado == 1) {
            foreach ($sal->materiales as $item) {
                $item->update(["ubicacion" => "MOTORGAS COMPANY S.A", "estado" => 1]);
            }
        }
        $sal->delete();
        $this->emitTo("salidas", "render");
        $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "La salida fue eliminada correctamente", "icono" => "success"]);
    }
    public function eliminaSalidaPrestamo(Salida $sal)
    {
        if ($sal->estado == 1) {
            foreach ($sal->materiales as $item) {
                $item->update(["ubicacion" => "En poder de" . $sal->usuarioCreador->name, "estado" => 3, "idUsuario" => $sal->usuarioCreador->id]);
            }
        }
        $sal->delete();
        $this->emitTo("salidas", "render");
        $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "La salida fue eliminada correctamente", "icono" => "success"]);
    }
}
