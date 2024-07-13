<?php

namespace App\Http\Livewire;

use App\Models\CartaAclaratoria;
use App\Models\CertificacionPendiente;
use App\Models\CertificacionTaller;
use App\Models\Desmontes;
use App\Models\Material;
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
        $chipsConsumidos = null;

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
        } elseif ($this->modelo === 'chipsConsumidos') {
            $chipsConsumidos = Material::query()
                ->select(
                    'material.id',
                    'material.idUsuario',
                    'material.estado',
                    'material.ubicacion',
                    'material.grupo',
                    'material.updated_at',
                    'users.name as nombreInspector',
                )
                ->join('users', 'material.idUsuario', '=', 'users.id')
                ->where([
                    ['material.estado', '=', 4], // Chips consumidos
                    ['material.idTipoMaterial', '=', 2], // Tipo de material CHIP
                    ['material.idUsuario', '=', Auth::id()], // Filtra por el usuario actualmente autenticado
                ])
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        }
        return view('livewire.lista-desmontes', compact("certificaciones", "desmontes", "taller", "carta", "chipsConsumidos"));
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
