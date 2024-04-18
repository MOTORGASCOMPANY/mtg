<?php

namespace App\Http\Livewire;

use App\Traits\docTallerTrait;
use DateTime;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

use function Symfony\Component\VarDumper\Dumper\esc;

class PruebaDocumentosTaller extends Component
{
    use docTallerTrait;

    public function render()
    {
        $docs=$this->listaDocumentos();
        return view('livewire.prueba-documentos-taller',compact('docs'));
    }

    public function cambiar(){
        /*
        if(count($docs)){
            try {
                $this->cambiaEstadoDocumentos($docs);
                $this->emit("CustomAlert", ["titulo" => "TODO OK P HIJO", "mensaje" => "Se cambiaron tus hvds", "icono" => "success"]);
                $this->emit("render");
            } catch (\Throwable $th) {
                throw $th;
            }
        }*/

        //$this->cambiaEstadoDocumentos();
        $this->cambiaDiasDeDocumentos();
        $this->emit("CustomAlert", ["titulo" => "TODO OK P HIJO", "mensaje" => "Se cambiaron tus hvds", "icono" => "success"]);
        $this->emit("render");
    }



}
