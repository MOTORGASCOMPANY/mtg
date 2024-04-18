<?php

namespace App\Http\Livewire;

use App\Models\Memorando;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListaMemorandos extends Component
{
    use WithPagination;

    public $sort, $direction, $cant, $search;
    public $user;
    protected $listeners = ['memoEliminada' => 'eliminarMemorando'];


    public function mount()
    {
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;        
        $this->user = Auth::user();
    }

    public function render()
    {
        $query = Memorando::query();
        
        if ($this->user->hasRole('inspector')) {
            $query->where('idUser', $this->user->id);
        }

        if (!empty($this->search)) {
            $query->whereHas('destinatario', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $memorandos = $query->orderBy($this->sort, $this->direction)->paginate($this->cant);

        return view('livewire.lista-memorandos', ['memorandos' => $memorandos]);
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

    public function verMemorando($id)
    {
        return redirect()->route('certificadoMemo', ['id' => $id]);
    }

    public function eliminarMemorando($memorandoId)
    {
        Memorando::destroy($memorandoId);
        $this->emit('memoEliminado');
    }

    public function agregar()
    {
        return redirect()->route('Memorando');
    }
}
