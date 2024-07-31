<?php

namespace App\Http\Livewire;

use App\Models\Anulacion;
use App\Models\Archivo;
use App\Models\Certificacion;
use Livewire\Component;
use App\Models\User;

class VistaSolicitudAnul extends Component
{
    public $inspector, $anulacion, $anuId, $userId, $cerId;
    public $images, $user, $certi;

    protected $listeners = ['render', 'anular', 'anularchip'];


    public function mount()
    {

        $this->anulacion = Anulacion::find($this->anuId);
        $this->images = Archivo::where("idDocReferenciado", $this->anulacion->id)->first();
        $this->user = User::find($this->userId);
        $this->certi = Certificacion::find($this->cerId);
    }

    public function render()
    {

        return view('livewire.vista-solicitud-anul');
    }

    public function anular(Certificacion $certificacion)
    {
        $certificacion->Hoja->update(['estado' => 5]); // estado anulado en MATERIAL
        $certificacion->update(['estado' => 2]); //estado anulado en CERTIFICACION
        $this->emitTo('administracion-certificaciones', 'render');
        return redirect(route('dashboard'));
        
    }

    public function anularchip(Certificacion $certificacion)
    {
        // Anular Hoja si existe
        if ($certificacion->Hoja) {
            $certificacion->Hoja->update(['estado' => 5]); // estado anulado en MATERIAL
        }
        
        // Anular chipMaterial si existe
        if ($certificacion->chipMaterial) {
            $certificacion->chipMaterial->update(['estado' => 3]); // estado posecion inspector
        }
        
        // Anular certificacion
        $certificacion->update(['estado' => 2]); // estado anulado en CERTIFICACION
        
        // Emitir evento para renderizar nuevamente el componente
        $this->emitTo('administracion-certificaciones', 'render');
        return redirect(route('dashboard'));
    }
}
