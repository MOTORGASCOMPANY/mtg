<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CargaFirmaInspector extends Component
{

    use WithFileUploads;   

    public $firma;

    protected $rules=["firma"=>'image|mimes:jpg,jpeg,png,tif,bmp'];

    public function mount(){
        $user=User::find(Auth::id());
        //$this->firmaBd=$user->rutFirma;
    }

    public function render()
    {
        return view('livewire.carga-firma-inspector');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function guardarFirma(){
        $this->validate();
        $user=User::find(Auth::id());
        $rutaFirma=$this->firma->storeAs('public/FirmasDeInspectores','firma-'.rand().'-'.$user->id.'.'.$this->firma->extension());
        $user->update(['rutaFirma'=>$rutaFirma]);
        $this->reset();
        $this->emit("minAlert",["titulo"=>"BUEN TRABAJO!","mensaje"=>"Firma guardada correctamente","icono"=>"success"]);      
        $this->emit("render");  
    }
}
