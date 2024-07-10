<?php

namespace App\Http\Livewire;

use App\Models\CartaAclaratoria;
use App\Models\Material;
use App\Models\TipoMaterial;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\pdfTrait;

class ServicioCartaAclaratoria extends Component
{

    use pdfTrait;
    use WithFileUploads;

    //VARIABLES DEL SERVICIO DE CARTA ACLARATORIA
    public $materiales, $material, $numSugerido, $pertenece;
    public $estado = null;
    public $certificacion = null;
    public $titulo, $partida, $placa;
    public $diceData = [];
    public $debeDecirData = [];
    public $diceModificacion;
    public $debeDecirModificacion;


    public function mount()
    {
        $this->materiales = TipoMaterial::whereIn('id', [1, 3, 4])->get();
        $this->diceData = [['numero' => '', 'titulo' => '', 'descripcion' => '']];
        $this->debeDecirData = [['numero' => '', 'titulo' => '', 'descripcion' => '']];
    }

    public function updatedMaterial($value)
    {
        /*if ($this->material) {
            $this->estado = 'esperando';
        } else {
            $this->estado = null;
        }*/
        $this->estado = $this->material ? 'esperando' : null;
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
        return view('livewire.servicio-carta-aclaratoria');
    }

    public function certificarta()
    {

        $material = Material::where("numSerie", $this->numSugerido)
            ->where("idTipoMaterial", $this->material)
            ->first();
        if (!$material) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Material no encontrado", "icono" => "warning"]);
            return;
        }

        $usuario = User::find($material->idUsuario);
        if (!$usuario) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "El material no esta asignado a ningun Inspector", "icono" => "warning"]);
            return;
        }

        // Verificar si el material es de tipo Modificación
        /*if ($this->material == 4) {
            $this->diceData = null;
            $this->debeDecirData = null;
        } elseif (empty($this->diceData)) {
            $this->diceData = null;
        } elseif (empty($this->debeDecirData)) {
            $this->debeDecirData = null;
        }*/

        if ($this->material == 4) {
            $this->diceData = null;
            $this->debeDecirData = null;
        } elseif (empty($this->diceData) || empty($this->debeDecirData)) {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Por favor complete los datos de DICE y DEBE DECIR.", "icono" => "warning"]);
            return;
        }

        $certi = CartaAclaratoria::certificarCartAclaratoria(
            $material,
            $usuario,
            $this->titulo,
            $this->partida,
            $this->placa,
            $this->diceData,
            $this->debeDecirData,
            $this->diceModificacion,
            $this->debeDecirModificacion
        );

        if ($certi) {
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Tu certificado N°: " . $certi->material->numSerie . " está listo.", "icono" => "success"]);
            $this->certificacion = $certi;
            $this->estado = 'certificado';
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No fue posible certificar", "icono" => "warning"]);
        }
    }

    //NUEVOS PARA DICE Y DEBE DECIR

    public function addData()
    {
        $this->diceData[] = ['numero' => '', 'titulo' => '', 'descripcion' => ''];
        $this->debeDecirData[] = ['numero' => '', 'titulo' => '', 'descripcion' => ''];
    }

    public function removeDiceData($index)
    {
        unset($this->diceData[$index]);
        $this->diceData = array_values($this->diceData);
    }

    public function removeDebeDecirData($index)
    {
        unset($this->debeDecirData[$index]);
        $this->debeDecirData = array_values($this->debeDecirData);
    }
}
