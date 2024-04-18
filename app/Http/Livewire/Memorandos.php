<?php

namespace App\Http\Livewire;

use App\Models\DocumentoMemorando;
use Livewire\Component;
use App\Models\Memorando;
use App\Models\User;
use App\Notifications\MemorandoSolicitud;
use Illuminate\Support\Facades\Notification;
use App\Traits\pdfTrait;

class Memorandos extends Component
{
    use pdfTrait;

    public $inspectores;
    public $inspector, $remitente, $destinatario, $cargo, $cargoremi, $motivo, $fecha;
    public $mostrarCampos = false;
    public $memorando;
    public $imagen;

    public function mount()
    {
        $this->inspectores = User::role(['inspector'])->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.memorandos');
    }


    public function certificar()
    {
        $this->validate([
            'inspector' => 'required',
            'remitente' => 'required',
            'cargo' => 'required',
            'cargoremi' => 'required',
            'motivo' => 'required',
            'fecha' => 'required',
        ]);
        
        $nuevoMemorando =  Memorando::create([
            'idUser' => $this->inspector,
            'remitente' => $this->remitente,
            'cargo' => $this->cargo,
            'cargoremi' => $this->cargoremi,
            'motivo' => $this->motivo,
            'fecha' => $this->fecha,
        ]);

        //$this->guardaMemorando($nuevoMemorando);
        //$users = User::role('inspector')->get();
        $users = User::findOrFail($this->inspector);
        Notification::send($users, new MemorandoSolicitud($nuevoMemorando));
        $this->memorando = $nuevoMemorando;       
        $this->reset(['inspector', 'remitente', 'destinatario', 'cargo', 'cargoremi','motivo', 'fecha']);
        $this->mostrarCampos = true;
        $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "El memorando se realizo correctamente", "icono" => "success"]);        
        //return redirect('Memorando');
    }

    public function seleccionarInspector()
    {
        $this->mostrarCampos = true;
    }
}
