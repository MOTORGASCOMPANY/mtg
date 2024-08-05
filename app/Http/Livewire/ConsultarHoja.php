<?php

namespace App\Http\Livewire;

use App\Models\TipoMaterial;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ConsultarHoja extends Component
{
    public $numSerie, $resultados;
    public $desde, $hasta, $tipoMaterial, $anioActivo;
    public $openEdit = false;
    public $estado, $ubicacion;
    public $consultaRealizada = false; 


    protected $rules = [
        'desde' => 'required',
        'hasta' => 'required',
        'tipoMaterial' => 'required',
        'estado' => 'required',
        'ubicacion' => 'required',
    ];



    public function render()
    {
        return view('livewire.consultar-hoja');
    }

    /*public function buscar()
    {
        $this->validate();
        if (!empty($this->desde) && !empty($this->hasta)) {
            $query = DB::table('material')
                ->leftJoin('users', 'material.idUsuario', '=', 'users.id')
                ->leftJoin('tipomaterial', 'material.idTipoMaterial', '=', 'tipomaterial.id')
                ->leftJoin('serviciomaterial', 'material.id', '=', 'serviciomaterial.idMaterial')
                ->leftJoin('certificacion', 'serviciomaterial.idCertificacion', '=', 'certificacion.id')
                ->leftJoin('vehiculo', 'certificacion.idVehiculo', '=', 'vehiculo.id')
                ->select(
                    'material.*',
                    'users.name as nombreUsuario',
                    'tipomaterial.descripcion as descripcionTipoMaterial',
                    'vehiculo.placa as placa'
                )
                ->whereBetween('material.numSerie', [$this->desde, $this->hasta]); // Calificación completa de numSerie

            // Filtro de tipo de material
            if ($this->tipoMaterial) {
                $query->where('material.idTipoMaterial', $this->tipoMaterial);
            }

            // Filtro para año activo
            if ($this->anioActivo) {
                $query->where('material.añoActivo', $this->anioActivo);
            }


            $this->resultados = $query->get();
        }
    }*/

    public function buscar()
    {
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required',
            'tipoMaterial' => 'required',
        ]);

        $query = DB::table('material')
            ->leftJoin('users', 'material.idUsuario', '=', 'users.id')
            ->leftJoin('tipomaterial', 'material.idTipoMaterial', '=', 'tipomaterial.id')
            ->leftJoin('serviciomaterial', 'material.id', '=', 'serviciomaterial.idMaterial')
            ->leftJoin('certificacion', 'serviciomaterial.idCertificacion', '=', 'certificacion.id')
            ->leftJoin('vehiculo', 'certificacion.idVehiculo', '=', 'vehiculo.id')
            ->leftJoin('detallesalida', 'material.id', '=', 'detallesalida.idMaterial')
            ->leftJoin('salidas', 'detallesalida.idSalida', '=', 'salidas.id')
            ->select(
                'material.*',
                'users.name as nombreUsuario',
                'tipomaterial.descripcion as descripcionTipoMaterial',
                'vehiculo.placa as placa',
                'salidas.created_at as fechaAsignacion'
            )
            ->whereBetween('material.numSerie', [$this->desde, $this->hasta]);

        if ($this->tipoMaterial) {
            $query->where('material.idTipoMaterial', $this->tipoMaterial);
        }

        if ($this->anioActivo) {
            $query->where('material.añoActivo', $this->anioActivo);
        }

        $this->resultados = $query->get();
        $this->consultaRealizada = true;
    }



    public function abrirModal()
    {
        if (isset($this->resultados) && $this->resultados->count()) {
            $this->openEdit = true;
        }
    }

    public function actualizar()
    {
        $this->validate([
            'estado' => 'required',
            'ubicacion' => 'required',
        ]);

        $query = DB::table('material')
            ->whereBetween('numSerie', [$this->desde, $this->hasta])
            ->where('idTipoMaterial', $this->tipoMaterial);

        if ($this->anioActivo) {
            $query->where('añoActivo', $this->anioActivo);
        }

        $query->update([
            'estado' => $this->estado,
            'ubicacion' => $this->ubicacion,
        ]);

        $this->emit("CustomAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Se cambió el estado correctamente", "icono" => "success"]);
        $this->reset(['openEdit', 'estado', 'ubicacion']);
    }
}
