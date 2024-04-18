<?php

namespace App\Http\Livewire;

use App\Models\Equipo;
use App\Models\EquiposVehiculo;
use App\Models\TipoEquipo;
use App\Models\TipoServicio;
use App\Models\vehiculo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CrearEquipo extends Component
{

    public $vehiculo, $tipoServicio;

    public $open = false;

    public $tiposDisponibles;

    public $tipoEquipo, $equipoSerie, $equipoMarca, $equipoModelo, $equipoCapacidad, $equipoPeso, $equipoFechaFab, $cantEquipos;
    public $equipos = [];


    public function mount(vehiculo $vehiculo, TipoServicio $tipoServicio)
    {
        $this->vehiculo = $vehiculo;
        $this->tipoServicio = $tipoServicio;
        $this->listaTiposDisponibles();
    }

    public function render()
    {
        return view('livewire.crear-equipo');
    }


    public function guardaEquipo()
    {
        $this->validate([
            "tipoEquipo" => "required|numeric|min:1"
        ]);
        switch ($this->tipoEquipo) {
            case 1:
                $chip = $this->salvaChip();
                $equipoVehiculo = EquiposVehiculo::create(["idEquipo" => $chip->id, "idVehiculo" => $this->vehiculo->id]);
                // $this->emit('form-equipos','mount');
                $this->emitTo('form-equipos', 'render');
                //$this->actualizaListaEquipos();
                //$this->cantEquipos=$this->cuentaEquipos();
                break;
            case 2:
                $reductor = $this->salvaReductor();
                $equipoVehiculo = EquiposVehiculo::create(["idEquipo" => $reductor->id, "idVehiculo" => $this->vehiculo->id]);
                $this->emitTo('form-equipos', 'render');
                break;
            case 3:
                if ($tanque = $this->salvaTanque()) {
                    $equipoVehiculo = EquiposVehiculo::create(["idEquipo" => $tanque->id, "idVehiculo" => $this->vehiculo->id]);
                    $this->emitTo('form-equipos', 'render');
                }
                break;
            case 4:
                $reductor = $this->salvaRegulador();
                $equipoVehiculo = EquiposVehiculo::create(["idEquipo" => $reductor->id, "idVehiculo" => $this->vehiculo->id]);
                $this->emitTo('form-equipos', 'render');
                break;
            case 5:
                if ($tanque = $this->salvaCilindroGlp()) {
                    $equipoVehiculo = EquiposVehiculo::create(["idEquipo" => $tanque->id, "idVehiculo" => $this->vehiculo->id]);
                    $this->emitTo('form-equipos', 'render');
                }
                break;

            default:
                $this->emit("alert", "ocurrio un error al guardar los datos");
                break;
        }

        $this->emitTo('prueba', 'refrescaVehiculo');
    }

    public function updatedOpen()
    {

        $this->listaTiposDisponibles();
        $this->tipoEquipo = "";
    }

    public function updatedEquipoCapacidad($var)
    {
        if ($var != null && $var != 'e') {
            $this->equipoPeso = $var + (mt_rand(1, 5));
        } else {
            $this->equipoPeso = null;
        }
    }

    public function salvaTanque()
    {
        $hoy = Carbon::now()->format('Y-m-d');
        $rules = [
            "equipoSerie" => "required|min:1",
            "equipoMarca" => "required|min:1",
            "equipoCapacidad" => "required|numeric|min:1",
            "equipoPeso" => "required|numeric|min:1",
            "equipoFechaFab" => "required|date_format:Y-m-d|before:" . $hoy,
        ];
        $this->validate($rules);

        $equipo = new Equipo();
        $equipo->idTipoEquipo = $this->tipoEquipo;
        $equipo->numSerie = strtoupper($this->equipoSerie);
        $equipo->marca = strtoupper($this->equipoMarca);
        $equipo->capacidad = $this->equipoCapacidad;
        $equipo->fechaFab = $this->equipoFechaFab;
        $equipo->peso = $this->equipoPeso;
        $equipo->combustible = 'GNV';
        $equipo->save();

        $this->reset(["equipoSerie", "equipoMarca", "equipoModelo", "equipoCapacidad", "tipoEquipo", "equipoFechaFab", "equipoPeso"]);
        $this->open = false;
        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El " . $equipo->tipo->nombre . " con serie " . $equipo->numSerie . " se añadio Correctamente", "icono" => "success"]);

        return $equipo;
    }

    public function salvaCilindroGlp()
    {
        $rules = [
            "equipoSerie" => "required|min:1",
            "equipoMarca" => "required|min:1",
            "equipoModelo" => "required|min:1",
        ];
        $this->validate($rules);

        $equipo = new Equipo();
        $equipo->idTipoEquipo = $this->tipoEquipo;
        $equipo->numSerie = strtoupper($this->equipoSerie);
        $equipo->marca = strtoupper($this->equipoMarca);
        $equipo->modelo = $this->equipoModelo;
        $equipo->combustible = 'GLP';
        $equipo->save();

        $this->reset(["equipoSerie", "equipoMarca", "equipoModelo", "tipoEquipo"]);
        $this->open = false;
        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El " . $equipo->tipo->nombre . " con serie " . $equipo->numSerie . " se añadio Correctamente", "icono" => "success"]);

        return $equipo;
    }

    public function salvaReductor()
    {
        $this->validate([
            "equipoSerie" => "required|min:1",
            "equipoMarca" => "required|min:1",
            "equipoModelo" => "required|min:1"
        ]);

        $equipo = new Equipo();
        $equipo->idTipoEquipo = $this->tipoEquipo;
        $equipo->numSerie = strtoupper($this->equipoSerie);
        $equipo->marca = strtoupper($this->equipoMarca);
        $equipo->modelo = strtoupper($this->equipoModelo);
        $equipo->combustible = 'GNV';
        //array_push($this->equipos,$equipo);
        $equipo->save();
        $this->reset(["equipoSerie", "equipoMarca", "equipoModelo", "equipoCapacidad", "tipoEquipo", "equipoFechaFab", "equipoPeso"]);
        $this->open = false;
        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El " . $equipo->tipo->nombre . " con serie " . $equipo->numSerie . " se añadio Correctamente", "icono" => "success"]);



        return $equipo;
    }

    public function salvaRegulador()
    {
        $this->validate([
            "equipoSerie" => "required|min:1",
            "equipoMarca" => "required|min:1",
            "equipoModelo" => "required|min:1"
        ]);

        $equipo = new Equipo();
        $equipo->idTipoEquipo = $this->tipoEquipo;
        $equipo->numSerie = strtoupper($this->equipoSerie);
        $equipo->marca = strtoupper($this->equipoMarca);
        $equipo->modelo = strtoupper($this->equipoModelo);
        $equipo->combustible = 'GLP';
        //array_push($this->equipos,$equipo);
        $equipo->save();
        $this->reset(["equipoSerie", "equipoMarca", "equipoModelo", "tipoEquipo"]);
        $this->open = false;
        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El " . $equipo->tipo->nombre . " con serie " . $equipo->numSerie . " se añadio Correctamente", "icono" => "success"]);



        return $equipo;
    }

    public function salvaChip()
    {
        $this->validate([
            "equipoSerie" => "required|min:1",
        ]);

        $equipo = new Equipo();
        $equipo->idTipoEquipo = $this->tipoEquipo;
        $equipo->numSerie = strtoupper($this->equipoSerie);
        $equipo->combustible = 'GNV';
        $equipo->save();

        $this->reset(["equipoSerie", "equipoMarca", "equipoModelo", "equipoCapacidad", "tipoEquipo", "equipoFechaFab", "equipoPeso", "equipos"]);
        $this->equipos = Equipo::make();
        $this->open = false;
        //$this->emit("alert","El ".$equipo->tipo->nombre." con serie ".$equipo->numSerie." se añadio Correctamente");
        $this->emit("minAlert", ["titulo" => "BUEN TRABAJO!", "mensaje" => "El " . $equipo->tipo->nombre . " con serie " . $equipo->numSerie . " se añadio Correctamente", "icono" => "success"]);



        return $equipo;
    }

    public function cuentaDis($tipo)
    {
        $cuenta = 0;
        if (isset($this->vehiculo->Equipos)) {
            if ($this->vehiculo->Equipos->count() > 0) {
                foreach ($this->vehiculo->Equipos as $eq) {
                    if ($eq->idTipoEquipo == $tipo) {
                        $cuenta++;
                    }
                }
            } else {
                $cuenta = 0;
            }
        }
        return $cuenta;
    }

    //Esta funcion puede causar problemas posteriormente
    public function listaTiposDisponibles()
    {
        $serviciosGnv = [1, 2, 7, 8, 10, 12];
        $serviciosGlp = [3, 4, 9, 13];
        if (in_array($this->tipoServicio->id, $serviciosGnv)) {
            $this->listaEquiposTipoGnv();
        }

        if (in_array($this->tipoServicio->id, $serviciosGlp)) {
            $this->listaEquiposTipoGlp();
        }
    }

    public function listaEquiposTipoGnv()
    {
        $tiposDisponibles = TipoEquipo::all()->filter(function ($value) {
            return $value->id < 4;
        })->map(function ($tip) {
            $estado = ($tip->id == 3) ? 1 : ($this->cuentaDis($tip->id) >= 1 ? 0 : 1);
            return ["id" => $tip->id, "nombre" => $tip->nombre, "estado" => $estado];
        });

        $this->tiposDisponibles = $tiposDisponibles->values(); // Reindexa los elementos del arreglo
    }


    public function listaEquiposTipoGlp()
    {
        $tiposDisponibles = TipoEquipo::all()->filter(function ($value) {
            return $value->id > 3;
        })->map(function ($tip) {
            //dd($tip);
            //$estado = ($tip->id == 3) ? 1 : ($this->cuentaDis($tip->id) >= 1 ? 0 : 1);
            $estado = 1 ;
            return ["id" => $tip->id, "nombre" => $tip->nombre, "estado" => $estado];
        });

        $this->tiposDisponibles = $tiposDisponibles->values(); // Reindexa los elementos del arreglo
    }

    protected $messages = ["date_format" => "Por favor ingrese una fecha con el formato: DD/MM/AAAA"];
}
