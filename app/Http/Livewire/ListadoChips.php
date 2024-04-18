<?php

namespace App\Http\Livewire;

use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ListadoChips extends Component
{
    use WithPagination;
    //public $chipsConsumidos;
    public $search, $sort, $direction, $cant, $user;

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'material.id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];

    public function mount()
    {

        $this->user = Auth::id();
        $this->cant = "10";
        $this->sort = 'material.id';
        $this->direction = "desc";
        //$this->obtenerChipsConsumidos();
    }

    public function render()
    {
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
                ['material.idUsuario', '=', auth()->id()], // Filtra por el usuario actualmente autenticado
            ])
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant == 'all' ? Material::count() : $this->cant);

            //dd($chipsConsumidos);
        return view('livewire.listado-chips', compact('chipsConsumidos'));
    }

    /*public function obtenerChipsConsumidos()
    {
        $this->chipsConsumidos = DB::table('material')
            ->select(
                'material.id',
                'material.idUsuario',
                'material.estado',
                'material.ubicacion',
                'material.grupo',
                'material.updated_at',
                'users.name as nombreInspector',
                //'tiposervicio.descripcion'
            )
            ->join('users', 'material.idUsuario', '=', 'users.id')
            ->where([
                ['material.estado', '=', 4], // Chips consumidos
                ['material.idTipoMaterial', '=', 2], // Tipo de material CHIP
                //['tiposervicio.id', '=', 11], // Id del servicio "Chip por deterioro"
                ['material.idUsuario', '=', auth()->id()], // Filtra por el usuario actualmente autenticado
            ])
            ->orderBy($this->sort, $this->direction)
            ->get();
           // dd($this->chipsConsumidos);
    } */

    public function sortBy($field)
    {
        if ($field === $this->sort) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->direction = 'asc';
        }

        $this->sort = $field;
    }
}
