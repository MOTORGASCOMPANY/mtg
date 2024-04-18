<?php

namespace App\Http\Livewire;

use App\Models\Archivo;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class CargaFotos extends Component
{
    use WithFileUploads;

    public $imagenes = [];

    public function render()
    {
        return view('livewire.carga-fotos');
    }

    public function muestraData()
    {
        //dd($this->imagenes);
        $this->validate([
            'imagenes' => 'required|array|min:1',
            'imagenes.*' => 'image|max:2048', // Tamaño máximo de 2MB  
        ]);

        $imagenesGuardadas = [];

        foreach ($this->imagenes as $imagen) {

            $nombreImg = 'img_' . rand(1, 5484848465);
            $extension = $imagen->getClientOriginalExtension();
            // Reducir el tamaño y peso de la imagen con Intervention Image
            $imagenProcesada = Image::make($imagen->path())
                //->resize(200, 200)
                ->encode($extension, 75);
            // Guardar la imagen procesada en el storage
            $path = "public/prueba/{$nombreImg}.{$extension}";
            Storage::put($path, $imagenProcesada->__toString());
        }
        $this->imagenes = [];
        session()->flash('success', 'Imágenes cargadas y procesadas correctamente.');
        return $imagenesGuardadas;
    }

    /*public function muestraData()
    {
        $this->validate([
            'imagenes' => 'required|array|min:1',
            'imagenes.*' => 'image|max:2048', // Tamaño máximo de 2MB
        ]);

        $imagenesGuardadas = [];

        foreach ($this->imagenes as $imagen) {
            $nombreImg = 'img_' . rand(1, 5484848465);
            $extension = $imagen->getClientOriginalExtension();

            // Reducir el tamaño y peso de la imagen con Intervention Image
            $imagenProcesada = Image::make($imagen->path())
                ->resize(120, 120)
                ->encode($extension);

            // Guardar la imagen procesada en el storage
            $path = "public/prueba/{$nombreImg}.{$extension}";
            Storage::put($path, $imagenProcesada->__toString());

            // Crear un nuevo modelo de Archivo (ajusta según tus necesidades)
            $nuevaImagen = Archivo::create([
                'nombre' => $nombreImg,
                'ruta' => $path,
                'extension' => $extension,
                'idDocReferenciado' => null,
            ]);

            $imagenesGuardadas[] = $nuevaImagen;  // Agregar la imagen recién creada al array
        }

        $this->imagenes = [];
        session()->flash('success', 'Imágenes cargadas y procesadas correctamente.');
        return $imagenesGuardadas;
    }*/
}
