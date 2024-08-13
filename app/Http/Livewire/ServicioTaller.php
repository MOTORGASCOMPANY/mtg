<?php

namespace App\Http\Livewire;

use App\Models\CertificacionTaller;
use App\Models\Material;
use App\Models\Taller;
use App\Models\TipoMaterial;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\pdfTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ServicioTaller extends Component
{
    use pdfTrait;
    use WithFileUploads;

    //VARIABLES DEL SERVICIO DE INSPECCION DE TALLER
    public $talleres, $materiales, $taller, $material, $numSugerido, $pertenece;
    public $estado = null;
    public $certificacion = null;
    public $serviexterno = false;


    public function mount()
    {
        $this->talleres = Taller::all()->sortBy('nombre');
        //$this->materiales = TipoMaterial::all();
        $this->materiales = TipoMaterial::whereIn('id', [1, 3])->get();

    }

    public function updatedTaller($value)
    {
        if ($this->taller && $this->material) {
            $this->estado = 'esperando';
        } else {
            $this->estado = null;
        }
    }

    public function updatedMaterial($value)
    {
        if ($this->taller && $this->material) {
            $this->estado = 'esperando';
        } else {
            $this->estado = null;
        }
    }

    public function updatednumSugerido($val)
    {
        $this->pertenece = $this->obtienePertenece($val);
    }

    public function obtienePertenece($val)
    {
        if ($val && $this->material) {
            $material = Material::where("numSerie", $val)
                ->where("idTipoMaterial", $this->material)
                ->where("estado", 3) //Agrege esto por el error de que primero busca la hoja del año anterior y esa ya esta consumida
                ->first();
            if (!$material) {
                return "No existe";
            } elseif (is_null($material->idUsuario)) {
                return "No está asignado";
            } elseif ($material->estado == 4) {
                return "Formato Consumido";
            } else {
                return User::find($material->idUsuario)->name;
            }
        }
        return null;
    }

    public function render()
    {
        return view('livewire.servicio-taller');
    }


    public function certificartaller()
    {
        $material = Material::where("numSerie", $this->numSugerido)
            ->where("idTipoMaterial", $this->material)
            ->where("estado", 3) //Agrege esto por el error de que primero busca la hoja del año anterior y esa ya esta consumida
            ->first();
        if (!$material) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Material no encontrado", "icono" => "warning"]);
            return;
        }

        $taller = Taller::find($this->taller);
        if (!$taller) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Taller no encontrado", "icono" => "warning"]);
            return;
        }

        $usuario = User::find($material->idUsuario);
        if (!$usuario) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "El material no esta asignado a ningun Inspector", "icono" => "warning"]);
            return;
        }

        $certi = CertificacionTaller::certificarTaller($taller, $material, $usuario,  $this->serviexterno);
        if ($certi) {
            //$this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Tu certificado está listo.", "icono" => "success"]);
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Tu certificado N°: " . $certi->material->numSerie . " está listo.", "icono" => "success"]);
            $this->certificacion = $certi;
            $this->estado = 'certificado';
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No fue posible certificar", "icono" => "warning"]);
        }
    }
}
