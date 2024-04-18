<?php

namespace App\Http\Livewire;

use App\Models\Desmontes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListaDesmontes extends Component
{
    use WithPagination;

    public $sort, $direction, $cant, $search;

    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
    }

    public function render()
    {
        $certis = Desmontes::placa($this->search)
            ->idInspector(Auth::id())
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);;
        return view('livewire.lista-desmontes', compact("certis"));
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
}
