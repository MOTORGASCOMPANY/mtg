<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use App\Models\Eliminacion;
use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\CertifiacionExpediente;
use App\Models\Expediente;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class VistaEliminacion extends Component
{
    public $inspector,$eliminacion,$eliId, $userId, $cerId;
    public  $user, $certi;

    protected $listeners = ['render', 'delete'];


    public function mount(){
        
        $this->eliminacion=Eliminacion::find($this->eliId);
        $this->user = User::find($this->userId);
        $this->certi= Certificacion::find($this->cerId);
    }


    public function render()
    {
        return view('livewire.vista-eliminacion');
    }

    public function cambiaEstadoDeMateriales(Collection $materiales, User $inspector)
    {
        $materiales->each(function ($item, $key) use ($inspector) {
            $item->update(['estado' => 3, "ubicacion" => "En poder de " . $inspector->name]);
        });
    }

    public function delete(Certificacion $certificacion)
    {

        if ($certificacion->Hoja) {
            $certExp = CertifiacionExpediente::where('idCertificacion', $certificacion->id)->first();
            if ($certExp) {
                $expe = Expediente::find($certExp->idExpediente);
                if ($expe) {

                    $imgs = Imagen::where('Expediente_idExpediente', '=', $expe->id)->get();
                    foreach ($imgs as $img) {
                        Storage::delete($img->ruta);
                    }
                    $expe->delete();
                }
            }

            $this->cambiaEstadoDeMateriales($certificacion->Materiales, $certificacion->Inspector);
            $certificacion->delete();

            return redirect(route('dashboard'));
        } else {
            if ($certificacion->delete()) {
                $this->emitTo('administracion-certificaciones', 'render');
                $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Se elimino tu servicio pero no se cambio el estado de su formato", "icono" => "warning"]);
                
                return redirect(route('dashboard'));
            }
        }
    }
}
