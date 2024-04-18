<?php

namespace App\Http\Livewire\Vehiculo;

use App\Models\vehiculo;
use Livewire\Component;

class CreateVehiculo extends Component
{
    public $nombreDelInvocador, $noPlaca;

    //VARIABLES DEL VEHICULO
    public $propietario, $placa, $categoria, $marca, $modelo, $version, $anioFab, $numSerie, $numMotor,
        $cilindros, $cilindrada, $combustible, $ejes, $ruedas, $asientos, $pasajeros,
        $largo, $ancho, $altura, $color, $pesoNeto, $pesoBruto, $cargaUtil;

    //VARIABLES DEL COMPONENTE
    public vehiculo $vehiculo;
    public $estado, $vehiculos, $busqueda, $tipoServicio;

    public function mount()
    {
        $this->estado = "nuevo";
        $this->noPlaca = 1;
        //$this->vehiculo=vehiculo::make();
    }

    public function updatedNoPlaca()
    {
        $this->placa = null;
    }

    protected $rules = [
        "propietario" => "nullable",
        "placa" => "nullable|min:6|max:10",
        "categoria" => "nullable",
        "marca" => "required|min:2",
        "modelo" => "required|min:2",
        "version" => "nullable",
        "anioFab" => "nullable|numeric|min:0",
        "numSerie" => "nullable|min:2",
        "numMotor" => "nullable|min:2",
        "cilindros" => "nullable|numeric|min:1",
        "cilindrada" => "nullable|numeric|min:1",
        "combustible" => "nullable|min:2",
        "ejes" => "nullable|numeric|min:1",
        "ruedas" => "nullable|numeric|min:1",
        "asientos" => "nullable|numeric|min:1",
        "pasajeros" => "nullable|numeric|min:1",
        "largo" => "nullable|numeric",
        "ancho" => "nullable|numeric",
        "altura" => "nullable|numeric",
        "color" => "nullable|min:2",
        "pesoNeto" => "nullable|numeric",
        "pesoBruto" => "nullable|numeric",
        "cargaUtil" => "nullable|numeric",

        "vehiculo.propietario" => "nullable",
        "vehiculo.placa" => "required|min:6",
        "vehiculo.categoria" => "nullable",
        "vehiculo.marca" => "required|min:2",
        "vehiculo.modelo" => "required|min:2",
        "vehiculo.version" => "nullable",
        "vehiculo.anioFab" => "nullable|numeric|min:1900",
        "vehiculo.numSerie" => "nullable|min:2",
        "vehiculo.numMotor" => "nullable|min:2",
        "vehiculo.cilindros" => "nullable|numeric|min:1",
        "vehiculo.cilindrada" => "nullable|numeric|min:1",
        "vehiculo.combustible" => "nullable|min:2",
        "vehiculo.ejes" => "nullable|numeric|min:1",
        "vehiculo.ruedas" => "nullable|numeric|min:1",
        "vehiculo.asientos" => "nullable|numeric|min:1",
        "vehiculo.pasajeros" => "nullable|numeric|min:1",
        "vehiculo.largo" => "nullable|numeric",
        "vehiculo.ancho" => "nullable|numeric",
        "vehiculo.altura" => "nullable|numeric",
        "vehiculo.color" => "nullable|min:2",
        "vehiculo.pesoNeto" => "nullable|numeric",
        "vehiculo.pesoBruto" => "nullable|numeric",
        "vehiculo.cargaUtil" => "nullable|numeric",
    ];

    public function render()
    {
        return view('livewire.vehiculo.create-vehiculo');
    }

    public function guardaVehiculo()
    {

        $rules = [
            "propietario" => "nullable",
            "placa" => "required|min:6|max:7",
            "categoria" => "nullable",
            "marca" => "required|min:2",
            "modelo" => "required|min:2",
            "version" => "nullable",
            "anioFab" => "nullable|numeric|min:0",
            "numSerie" => "nullable|min:2",
            "numMotor" => "nullable|min:2",
            "cilindros" => "nullable|numeric|min:1",
            "cilindrada" => "nullable|numeric|min:1",
            "combustible" => "nullable|min:2",
            "ejes" => "nullable|numeric|min:1",
            "ruedas" => "nullable|numeric|min:1",
            "asientos" => "nullable|numeric|min:1",
            "pasajeros" => "nullable|numeric|min:1",
            "largo" => "nullable|numeric",
            "ancho" => "nullable|numeric",
            "altura" => "nullable|numeric",
            "color" => "nullable|min:2",
            "pesoNeto" => "nullable|numeric",
            "pesoBruto" => "nullable|numeric",
            "cargaUtil" => "nullable|numeric"
        ];

        if ($this->noPlaca != 1) {
            $this->validate($rules);
        } else {
            if (array_key_exists("placa", $rules)) {
                $rules["placa"] = "nullable";
            }
            $this->validate($rules);
        }
        $vehiculo = vehiculo::create([
            "propietario" => $this->propietario,
            "placa" => $this->placa == "" ? null : strtoupper($this->placa),
            "categoria" => strtoupper($this->categoria),
            "marca" => $this->retornaNE($this->marca),
            "modelo" => $this->retornaNE($this->modelo),
            "version" => $this->retornaSV($this->version),

            //considerar en el PDF
            "anioFab" => $this->retornaNulo($this->anioFab),
            //considerar en el PDF

            "numSerie" => $this->retornaNE($this->numSerie),
            "numMotor" => $this->retornaNE($this->numMotor),


            //considerar en el PDF
            "cilindros" => $this->retornaNulo($this->cilindros),
            "cilindrada" => $this->retornaNulo($this->cilindrada),
            //considerar en el PDF


            "combustible" => $this->retornaNE($this->combustible),

            //considerar en el PDF
            "ejes" => $this->retornaNulo($this->ejes),
            "ruedas" => $this->retornaNulo($this->ruedas),
            "asientos" => $this->retornaNulo($this->asientos),
            "pasajeros" => $this->retornaNulo($this->pasajeros),
            //considerar en el PDF


            //considerar en el PDF
            "largo" => $this->retornaNulo($this->largo),
            "ancho" => $this->retornaNulo($this->ancho),
            "altura" => $this->retornaNulo($this->altura),
            //considerar en el PDF

            "color" => $this->retornaNE($this->color),

            //considerar en el PDF
            "pesoNeto" => $this->retornaNulo($this->pesoNeto),
            "pesoBruto" => $this->retornaNulo($this->pesoBruto),
            "cargaUtil" => $this->retornaNulo($this->cargaUtil),
            //considerar en el PDF

        ]);
        //dd($vehiculo);
        if ($vehiculo) {
            $this->vehiculo = $vehiculo;
            $this->estado = 'cargado';
            $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => 'El vehículo con placa ' . $vehiculo->placa . ' se registro correctamente.', "icono" => "success"]);
            if ($this->nombreDelInvocador != null) {
                $this->emitTo($this->nombreDelInvocador, 'cargaVehiculo', $vehiculo->id);
            } else {
                $this->emitTo('prueba', 'cargaVehiculo', $vehiculo->id);
            }
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un error al guardar los datos del vehículo", "icono" => "warning"]);
        }
    }

    public function actualizarVehiculo()
    {
        $rules =
            [
                "vehiculo.propietario" => "nullable",
                "vehiculo.placa" => "required|min:6|max:7",
                "vehiculo.categoria" => "nullable",
                "vehiculo.marca" => "required|min:2",
                "vehiculo.modelo" => "required|min:2",
                "vehiculo.version" => "nullable",
                "vehiculo.anioFab" => "nullable|numeric|min:1900",
                "vehiculo.numSerie" => "nullable|min:2",
                "vehiculo.numMotor" => "nullable|min:2",
                "vehiculo.cilindros" => "nullable|numeric|min:1",
                "vehiculo.cilindrada" => "nullable|numeric|min:1",
                "vehiculo.combustible" => "nullable|min:2",
                "vehiculo.ejes" => "nullable|numeric|min:1",
                "vehiculo.ruedas" => "nullable|numeric|min:1",
                "vehiculo.asientos" => "nullable|numeric|min:1",
                "vehiculo.pasajeros" => "nullable|numeric|min:1",
                "vehiculo.largo" => "nullable|numeric",
                "vehiculo.ancho" => "nullable|numeric",
                "vehiculo.altura" => "nullable|numeric",
                "vehiculo.color" => "nullable|min:2",
                "vehiculo.pesoNeto" => "nullable|numeric",
                "vehiculo.pesoBruto" => "nullable|numeric",
                "vehiculo.cargaUtil" => "nullable|numeric",
            ];

        //$this->validate();
        if ($this->noPlaca != 1) {
            $this->validate($rules);
        } else {
            if (array_key_exists("vehiculo.placa", $rules)) {
                $rules["vehiculo.placa"] = "nullable";
            }
            $this->validate($rules);
        }

        $xxx = $this->actualizarDatosVeh();

        if ($xxx != null) {
            $this->estado = 'cargado';
            $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Datos del vehículo actualizados correctamente", "icono" => "success"]);
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un error al actualizar los datos del vehículo", "icono" => "warning"]);
        }
    }
    public function actualizarDatosVeh(){
        
      if($this->noPlaca != 1){
        $cambio = $this->vehiculo
        ->update([
            "propietario" => $this->vehiculo->propietario,
            "placa" => strtoupper($this->vehiculo->placa),
            "categoria" => strtoupper($this->vehiculo->categoria),
            "marca" => $this->retornaNE($this->vehiculo->marca),
            "modelo" => $this->retornaNE($this->vehiculo->modelo),
            "version" => $this->retornaSV($this->vehiculo->version),

            //considerar en el PDF
            "anioFab" => $this->retornaNulo($this->vehiculo->anioFab),
            //considerar en el PDF

            "numSerie" => $this->retornaNE($this->vehiculo->numSerie),
            "numMotor" => $this->retornaNE($this->vehiculo->numMotor),


            //considerar en el PDF
            "cilindros" => $this->retornaNulo($this->vehiculo->cilindros),
            "cilindrada" => $this->retornaNulo($this->vehiculo->cilindrada),
            //considerar en el PDF


            "combustible" => $this->retornaNE($this->vehiculo->combustible),

            //considerar en el PDF
            "ejes" => $this->retornaNulo($this->vehiculo->ejes),
            "ruedas" => $this->retornaNulo($this->vehiculo->ruedas),
            "asientos" => $this->retornaNulo($this->vehiculo->asientos),
            "pasajeros" => $this->retornaNulo($this->vehiculo->pasajeros),
            //considerar en el PDF


            //considerar en el PDF
            "largo" => $this->retornaNulo($this->vehiculo->largo),
            "ancho" => $this->retornaNulo($this->vehiculo->ancho),
            "altura" => $this->retornaNulo($this->vehiculo->altura),
            //considerar en el PDF

            "color" => $this->retornaNE($this->vehiculo->color),

            //considerar en el PDF
            "pesoNeto" => $this->retornaNulo($this->vehiculo->pesoNeto),
            "pesoBruto" => $this->retornaNulo($this->vehiculo->pesoBruto),
            "cargaUtil" => $this->retornaNulo($this->vehiculo->cargaUtil),
        ]);
        
        return $cambio;
      } else {
        $cambio = $this->vehiculo
        ->update([
            "propietario" => $this->vehiculo->propietario,
            "placa" => null,
            "categoria" => strtoupper($this->vehiculo->categoria),
            "marca" => $this->retornaNE($this->vehiculo->marca),
            "modelo" => $this->retornaNE($this->vehiculo->modelo),
            "version" => $this->retornaSV($this->vehiculo->version),

            //considerar en el PDF
            "anioFab" => $this->retornaNulo($this->vehiculo->anioFab),
            //considerar en el PDF

            "numSerie" => $this->retornaNE($this->vehiculo->numSerie),
            "numMotor" => $this->retornaNE($this->vehiculo->numMotor),


            //considerar en el PDF
            "cilindros" => $this->retornaNulo($this->vehiculo->cilindros),
            "cilindrada" => $this->retornaNulo($this->vehiculo->cilindrada),
            //considerar en el PDF


            "combustible" => $this->retornaNE($this->vehiculo->combustible),

            //considerar en el PDF
            "ejes" => $this->retornaNulo($this->vehiculo->ejes),
            "ruedas" => $this->retornaNulo($this->vehiculo->ruedas),
            "asientos" => $this->retornaNulo($this->vehiculo->asientos),
            "pasajeros" => $this->retornaNulo($this->vehiculo->pasajeros),
            //considerar en el PDF


            //considerar en el PDF
            "largo" => $this->retornaNulo($this->vehiculo->largo),
            "ancho" => $this->retornaNulo($this->vehiculo->ancho),
            "altura" => $this->retornaNulo($this->vehiculo->altura),
            //considerar en el PDF

            "color" => $this->retornaNE($this->vehiculo->color),

            //considerar en el PDF
            "pesoNeto" => $this->retornaNulo($this->vehiculo->pesoNeto),
            "pesoBruto" => $this->retornaNulo($this->vehiculo->pesoBruto),
            "cargaUtil" => $this->retornaNulo($this->vehiculo->cargaUtil),
        ]);
        
        return $cambio;
      }
    }

    public function retornaNE($value)
    {
        if ($value) {
            return strtoupper($value);
        } else {
            return $value = 'NE';
        }
    }

    public function retornaSV($value)
    {
        if ($value) {
            return strtoupper($value);
        } else {
            return $value = 'S/V';
        }
    }

    public function retornaNulo($value)
    {
        if ($value) {
            return $value;
        } else {
            return Null;
        }
    }

    //revisa la existencia del vehiculo en nuestra base de datos y los devuelve en caso de encontrarlo
    public function buscarVehiculo()
    {
       // $this->validate(['numMotor' => 'min:6|max:11']); //['placa' => 'min:3|max:7'],

        $vehiculos = vehiculo::where('numSerie', 'like', '%' . $this->numSerie . '%') //->orWhere('numMotor', 'like', '%' . $this->numMotor . '%')   ('placa', 'like', '%' . $this->placa . '%')  
            ->get();

        if ($vehiculos->count() > 0) {
            $this->busqueda = true;
            $this->vehiculos = $vehiculos;
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No se encontro ningún vehículo con la placa ingresada", "icono" => "warning"]);
        }
    }

    public function seleccionaVehiculo(vehiculo $veh)
    {
        $this->vehiculo = $veh;
        $this->estado = 'cargado';
        if ($this->nombreDelInvocador != null) {
            $this->emitTo($this->nombreDelInvocador, 'cargaVehiculo', $veh->id);
        } else {
            $this->emitTo('prueba', 'cargaVehiculo', $veh->id);
        }
        $this->vehiculos = null;
        $this->busqueda = false;
    }
}
