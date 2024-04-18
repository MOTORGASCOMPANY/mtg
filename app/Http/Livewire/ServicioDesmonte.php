<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Auth;

class ServicioDesmonte extends Component
{
    public $desmonte,$placa,$estado="esperando", $taller , $servicio;
    public $cantidadCertificaciones = 1;
    public $serviexterno = false;

    protected $rules=[
        "placa"=>"required|min:6|max:7",
        "cantidadCertificaciones" => "required|integer|min:1",
    ];

    public function mount()
    {
        $this->cantidadCertificaciones = 1;
    }

    public function render()
    {
        return view('livewire.servicio-desmonte');
    }

    /*public function desmonte(){
        $this->validate();

        //dd($this->servicio);
        $certificar = Certificacion::certificarDesmonte($this->taller,  $this->servicio,  Auth::user(), $this->placa);
        
        if($certificar){
            $this->estado="ChipConsumido";                   
            $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se realizo correctamente", "icono" => "success"]);
        }else{
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un error", "icono" => "warning"]);
        }
            
    }*/    

    public function desmonte()
    {
        $this->validate();

        for ($i = 0; $i < $this->cantidadCertificaciones; $i++) {
            $certificar = Certificacion::certificarDesmonte($this->taller, $this->servicio, Auth::user(), $this->placa, $this->serviexterno);

            if (!$certificar) {
                $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrió un error al certificar", "icono" => "warning"]);
                return;
            }
        }

        $this->estado = "ChipConsumido";
        $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se realizó correctamente", "icono" => "success"]);
    }
}
