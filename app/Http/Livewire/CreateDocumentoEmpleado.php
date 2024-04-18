<?php

namespace App\Http\Livewire;

use App\Models\ContratoTrabajo;
use App\Models\DocumentoEmpleado;
use App\Models\DocumentoEmpleadoUser;
use App\Models\TipoDocumentoEmpleado;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateDocumentoEmpleado extends Component
{
    use WithFileUploads;
    public $idEmpleado, $empleado;
    public $addDocument = false;
    public $tipoSel, $fechaInicial, $fechaCaducidad, $documento;
    public $tiposDisponibles;

    protected $rules = [
        "tipoSel" => "required|numeric|min:1",
        "documento" => "required|mimes:pdf",
        "fechaInicial" => "required|date",
        "fechaCaducidad" => "required|date",
    ];


    public function mount()
    {
        $this->empleado = ContratoTrabajo::find($this->idEmpleado);
        $this->listaDisponibles();
    }

    public function updatedAddDocument()
    {
        $this->listaDisponibles();
        $this->reset(["tipoSel", "fechaInicial", "fechaCaducidad", "documento"]);
        $this->tipoSel = "";
    }

    public function render()
    {
        return view('livewire.create-documento-empleado');
    }


    public function agregarDocumento()
    {
        $this->validate();
        $nombre = $this->idEmpleado . '-doc-' . rand();
        $documento_guardado = DocumentoEmpleado::create([
            'tipoDocumento' => $this->tipoSel,
            'fechaInicio' => $this->fechaInicial,
            'fechaExpiracion' => $this->fechaCaducidad,
            'ruta' => $this->documento->storeAs('public/docsEmpleados', $nombre . '.' . $this->documento->extension()),
            'extension' => $this->documento->extension(),
        ]);

        $docTaller = DocumentoEmpleadoUser::create([
            'idDocumentoEmpleado' => $documento_guardado->id,
            'idUser' => $this->idEmpleado,
            'estado' => 1,
        ]);
        $this->emitTo('editar-empleado', 'refrescaEmpleado');
        $this->emitTo('documentos-empleados', 'resetEmpleado');
        $this->reset(["tipoSel", "fechaInicial", "fechaCaducidad", "documento", "addDocument"]);
        $this->tipoSel = "";
        $this->emit("CustomAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "Se ingreso correctamente un nuevo documento del empleado " . $this->empleado->idUser, "icono" => "success"]);
    }

    public function listaDisponibles()
    {
        $this->tiposDisponibles = TipoDocumentoEmpleado::all();
    }
}
