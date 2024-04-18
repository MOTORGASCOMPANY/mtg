<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Logona extends Component
{

    public $logoPath, $availableLogos;
    public $showModal = false;
    public $selectedLogo, $currentLogo;

    public function mount()
    {
        // Lógica para cargar la ruta inicial del logo
        $this->logoPath = 'images/images/logona.png';
        // Obtener todas las imágenes en el directorio de logos
        $this->availableLogos = collect(File::files(public_path('images/images')))
            ->map(function ($file) {
                return $file->getFilename();
            })
            ->toArray();
        $this->currentLogo = 'logona.png';
    }

    public function render()
    {
        return view('livewire.logona');
    }

    public function abrir()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateLogo()
    {
        if ($this->selectedLogo) {
            $this->logoPath = 'images/images/' . $this->selectedLogo;
            $this->closeModal();
        }
    }

    public function selectLogo($filename)
    {
        $this->selectedLogo = $filename;
    }

    public function actualizar(){

    }
}
