<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Anulacion;
use App\Models\Material;

class VistaSolicitudDevolucion extends Component
{
    public $anulacion, $material, $user, $anuId, $userId, $matId;
    public $motivoGrupo, $fechaGrupo;
    public $materialDetails = [];

    protected $listeners = ['render', 'actualizar'];

    public function mount($anuId, $matId, $userId)
    {
        // Decodificar JSON en objetos
        $this->anulacion = collect(json_decode($anuId, true)); // true para obtener arrays asociativos
        $this->material = collect(json_decode($matId, true)); // true para obtener arrays asociativos
        $this->user = User::find($userId);

        // Agrupar anulaciones por cart_id
        $groupedAnulaciones = $this->anulacion->groupBy('cart_id');

        //dd($groupedAnulaciones);

        // Si hay al menos un grupo
        if ($groupedAnulaciones->isNotEmpty()) {
            $firstGroup = $groupedAnulaciones->first();
            // Obtener detalles de las anulaciones para el primer grupo
            $firstGroupAnulaciones = Anulacion::whereIn('id', $firstGroup->toArray())->get();

            // Verificar si hay elementos en el grupo y obtener la información del primer elemento
            if ($firstGroupAnulaciones->isNotEmpty()) {
                $firstItem = $firstGroupAnulaciones->first();
                $this->motivoGrupo = $firstItem->motivo ?? 'No disponible'; // Motivo del primer ítem del grupo
                $this->fechaGrupo = $firstItem->created_at ?? 'No disponible'; // Fecha del primer ítem del grupo
            }
        }

        // Obtener detalles de los materiales
        $this->materialDetails = Material::whereIn('id', $this->material->toArray())->get();
    }


    public function render()
    {
        return view('livewire.vista-solicitud-devolucion');
    }

    public function tipoMaterial($idTipoMaterial)
    {
        switch ($idTipoMaterial) {
            case 1:
                return 'GNV';
            case 2:
                return 'CHIP';
            case 3:
                return 'GLP';
            case 4:
                return 'MODI';
            default:
                return 'Desconocido';
        }
    }


    public function actualizar()
    {
        // Actualizar el estado de todos los materiales a 5
        Material::whereIn('id', $this->material->toArray())->update(['devuelto' => 1]);

        // Opcional: refrescar la lista de materiales
        $this->materialDetails = Material::whereIn('id', $this->material->toArray())->get();

        $this->emitTo('administracion-certificaciones', 'render');
        //return redirect(route('dashboard'));
    }

    /*public function mount()
     {

        $this->anulacion = Anulacion::find($this->anuId);
        $this->user = User::find($this->userId);
        $this->material = Material::find($this->matId);
        //dd($this->anulacion);
     }
    */
}
