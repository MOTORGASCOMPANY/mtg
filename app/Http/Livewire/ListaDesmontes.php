<?php

namespace App\Http\Livewire;

use App\Models\CartaAclaratoria;
use App\Models\CertificacionPendiente;
use App\Models\CertificacionTaller;
use App\Models\Desmontes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListaDesmontes extends Component
{
    use WithPagination;

    public $sort, $direction, $cant, $search, $modelo;

    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
        $this->modelo = '';
    }

    public function render()
    {
        $desmontes = null;
        $certificaciones = null;
        $taller = null;
        $carta = null;

        if ($this->modelo === 'desmontes') {
            $desmontes = Desmontes::placa($this->search)
                ->idInspector(Auth::id())
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'certificaciones') {
            $certificaciones = CertificacionPendiente::IdInspector(Auth::id())
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'taller') {
            $taller = CertificacionTaller::idInspector(Auth::id())
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($this->modelo === 'carta') {
            $carta = CartaAclaratoria::idInspector(Auth::id())
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        }

        return view('livewire.lista-desmontes', compact("certificaciones", "desmontes","taller", "carta"));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            $this->direction = $this->direction == 'desc' ? 'asc' : 'desc';
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}
