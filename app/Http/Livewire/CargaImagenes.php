<?php

namespace App\Http\Livewire;

use App\Models\Imagen;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CargaImagenes extends Component
{
    use WithFileUploads;
    use ImageTrait;

    public $archivo=[];
    public $urls;

    protected $rules = [
        "archivo" => "nullable|array",
    ];


    public function mount(){
        $this->listarArchivos();
    }

    public function render()
    {
        return view('livewire.carga-imagenes');
    }

    public function procesar2(){

        foreach ($this->archivo as $file) {
           $file->store('pruebas','do');
        }

    }

    public function procesar()
    {

        $this->validate();

        $archivos = Imagen::where([['migrado', '0',]])->get();

        try {
            foreach ($archivos as $file) {
                $this->migrarArchivoDeExpedienteLocal($file);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function listarArchivos(){

        $archivos=Storage::disk('do')->allFiles('expedientes');
        $urls=[];

        foreach ($archivos as $archivo) {
            $urls[] = Storage::disk('do')->url($archivo);
        }

        $this->urls = $urls;

    }
}
