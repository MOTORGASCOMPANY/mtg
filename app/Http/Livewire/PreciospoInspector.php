<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Tablas\Tiposservicios;
use App\Models\PrecioInspector;
use App\Models\TipoServicio;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class PreciospoInspector extends Component
{
    use WithPagination;
    public $direction, $sort, $cant;
    public $search, $editar = false, $serviciosNuevos, $tiposServicio;
    public $userIdSeleccionado;
    protected $users;

    public function mount()
    {
        $this->tiposServicio = TipoServicio::all();
        $this->direction = 'desc';
        $this->sort = 'id';
        $this->cant = 10;
    }

    public function render()
    {
        $query = User::role('inspector');

        if (!empty($this->search)) {
            $query = $query->where('name', 'like', '%' . $this->search . '%');
        }

        $users = $query->paginate($this->cant);

        return view('livewire.preciospo-inspector', ['users' => $users]);
    }


    public function agregarServicios($userId)
    {
        $this->userIdSeleccionado = $userId;
        $this->cargarPrecios($userId);
        $this->editar = true;
    }

    protected function cargarPrecios($userId)
    {
        $precios = PrecioInspector::where('idUsers', $userId)->get();
        $this->serviciosNuevos = $precios->pluck('precio', 'idServicio')->toArray();
    }

    /*public function guardarServicios()
    {
        $userId = $this->userIdSeleccionado;
        if (!empty($this->serviciosNuevos)) {  // Validar que $serviciosNuevos no esté vacío y contenga datos válidos
            foreach ($this->serviciosNuevos as $tipoServicioId => $precio) {
                if (!empty($precio) && is_numeric($precio)) {
                    PrecioInspector::updateOrCreate( //crear o actualizar precio
                        [
                            'idUsers' => $userId,
                            'idServicio' => $tipoServicioId,
                        ],
                        [
                            'precio' => $precio,
                            'estado' => 0,
                        ]
                    );
                }
            }
            $this->serviciosNuevos = [];
        }
        $this->editar = false;
    }*/

    public function guardarServicios()
    {
        $userId = $this->userIdSeleccionado;
        foreach ($this->serviciosNuevos as $tipoServicioId => $precio) {
            if ($precio !== null && $precio !== '' && is_numeric($precio)) {
                PrecioInspector::updateOrCreate(//crear o actualizar precio
                    [
                        'idUsers' => $userId,
                        'idServicio' => $tipoServicioId,
                    ],
                    [
                        'precio' => $precio,
                        'estado' => 0,
                    ]
                );
            } else {
                // Si el precio es nulo o esta vacio elimina el registro
                PrecioInspector::where('idUsers', $userId)
                    ->where('idServicio', $tipoServicioId)
                    ->delete();
            }
        }
        $this->serviciosNuevos = [];
        $this->editar = false;
    }
}
