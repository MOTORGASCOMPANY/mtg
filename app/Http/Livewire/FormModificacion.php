<?php

namespace App\Http\Livewire;

use App\Models\vehiculo;
use App\Models\Modificacion;
use App\Models\VehiculoModificacion;
use Livewire\Component;

class FormModificacion extends Component
{
    public function render()
    {
        return view('livewire.form-modificacion');
    }

    public $nombreDelInvocador;

    //VARIABLES DEL VEHICULO
    public $propietario, $placa, $categoria, $marca, $modelo, $version, $anioFab, $numSerie, $numMotor,
        $cilindros, $cilindrada, $combustible, $ejes, $ruedas, $asientos, $pasajeros,
        $largo, $ancho, $altura, $color, $pesoNeto, $pesoBruto, $cargaUtil;

    //VARIABLES DEL COMPONENTE
    public vehiculo $vehiculo;
    public $estado, $vehiculos, $busqueda, $tipoServicio;

    //VARIABLES FALTANTES (TABLA MODIFICACION)
    //aqui estas inicializando la variable modificacion como una variable de tipo MODIFICACION osea el modelo
    public modificacion $modificacion;
    public $direccion, $chasis, $carroceria, $potencia, $rodante, $rectificacion, $carga;

    public function mount()
    {
        $this->estado = "nuevo";
        //$this->vehiculo=vehiculo::make();
        $this->modificacion = new Modificacion(); // Agregar esta línea para inicializar $modificacion        
    }

    protected $rules = [
        "propietario" => "nullable|min:6",
        "placa" => "nullable|min:6|max:10",
        "categoria" => "nullable",
        "marca" => "required|min:2",
        "modelo" => "required|min:2",
        "version" => "nullable",
        "anioFab" => "nullable|numeric|min:0",
        "numSerie" => "nullable|min:2",
        "numMotor" => "nullable|min:2",
        "cilindros" => "nullable|numeric|min:1",
        "cilindrada" => "nullable", //|numeric|min:1
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
        //variables restantes
        "direccion" => "nullable",
        "chasis" => "nullable",
        "carroceria" => "nullable",
        "potencia" => "nullable",
        "rodante" => "nullable",
        "rectificacion" => "nullable",
        "carga" => "nullable",

        "vehiculo.propietario" => "required|min:6",
        "vehiculo.placa" => "required|min:6",
        "vehiculo.categoria" => "nullable",
        "vehiculo.marca" => "required|min:2",
        "vehiculo.modelo" => "required|min:2",
        "vehiculo.version" => "nullable",
        "vehiculo.anioFab" => "nullable|numeric|min:1900",
        "vehiculo.numSerie" => "nullable|min:2",
        "vehiculo.numMotor" => "nullable|min:2",
        "vehiculo.cilindros" => "nullable|numeric|min:1",
        "vehiculo.cilindrada" => "nullable",//|numeric|min:1
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
        //variables restantes

        "modificacion.direccion" => "nullable",
        "modificacion.chasis" => "nullable",
        "modificacion.carroceria" => "nullable",
        "modificacion.potencia" => "nullable",
        "modificacion.rodante" => "nullable",
        "modificacion.rectificacion" => "nullable",
        "modificacion.carga" => "nullable",

    ];

    public function guardaVehiculo()
    {
        $rules = [
            "propietario" => "required|min:6",
            "placa" => "required|min:6|max:7",
            "categoria" => "nullable",
            "marca" => "required|min:2",
            "modelo" => "required|min:2",
            "version" => "nullable",
            "anioFab" => "nullable|numeric|min:0",
            "numSerie" => "nullable|min:2",
            "numMotor" => "nullable|min:2",
            "cilindros" => "nullable|numeric|min:1",
            "cilindrada" => "nullable",//|numeric|min:1
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
            //variables restantes
            "direccion" => "nullable",
            "chasis" => "nullable",
            "carroceria" => "nullable",
            "potencia" => "nullable",
            "rodante" => "nullable",
            "rectificacion" => "nullable",
            "carga" => "nullable",
        ];

        $this->validate($rules);

        $vehiculo = vehiculo::create([
            "propietario" => $this->retornaNE($this->propietario),
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
        //dd( $this->retornaNE($this->carga));
        // Crea una nueva modificación
        $modificacion = Modificacion::create([
            "direccion" => $this->retornaNE($this->direccion),
            "chasis" => $this->retornaNE($this->chasis),
            "carroceria" => $this->retornaNE($this->carroceria),
            "potencia" => $this->retornaNE($this->potencia),
            "rodante" => $this->retornaNE($this->rodante),
            "rectificacion" => $this->retornaNE($this->rectificacion),
            "carga" => $this->retornaNE($this->carga),
        ]);

        VehiculoModificacion::create([
            'idVehiculo' => $vehiculo->id,
            'idModificacion' => $modificacion->id,
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
                "vehiculo.propietario" => "required|min:6",
                "vehiculo.placa" => "required|min:6|max:7",
                "vehiculo.categoria" => "nullable",
                "vehiculo.marca" => "required|min:2",
                "vehiculo.modelo" => "required|min:2",
                "vehiculo.version" => "nullable",
                "vehiculo.anioFab" => "nullable|numeric|min:1900",
                "vehiculo.numSerie" => "nullable|min:2",
                "vehiculo.numMotor" => "nullable|min:2",
                "vehiculo.cilindros" => "nullable|numeric|min:1",
                "vehiculo.cilindrada" => "nullable",//|numeric|min:1
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
                //variables restantes
                "modificacion.direccion" => "nullable",
                "modificacion.chasis" => "nullable",
                "modificacion.carroceria" => "nullable",
                "modificacion.potencia" => "nullable",
                "modificacion.rodante" => "nullable",
                "modificacion.rectificacion" => "nullable",
                "modificacion.carga" => "nullable",
            ];

        $this->validate($rules);

        if (
            $this->vehiculo
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

                //restantes (crear para modi)

                "direccion" => $this->retornaNE($this->vehiculo->direccion),
                "chasis" => $this->retornaNE($this->vehiculo->chasis),
                "carroceria" => $this->retornaNE($this->vehiculo->carroceria),
                "potencia" => $this->retornaNE($this->vehiculo->potencia),
                "rodante" => $this->retornaNE($this->vehiculo->rodante),
                "rectificacion" => $this->retornaNE($this->vehiculo->rectificacion),
                "carga" => $this->retornaNE($this->vehiculo->carga),
            ])


        ) {
            if (
                $this->modificacion
                ->update([
                    "direccion" => $this->retornaNE($this->modificacion->direccion),
                    "chasis" => $this->retornaNE($this->modificacion->chasis),
                    "carroceria" => $this->retornaNE($this->modificacion->carroceria),
                    "potencia" => $this->retornaNE($this->modificacion->potencia),
                    "rodante" => $this->retornaNE($this->modificacion->rodante),
                    "rectificacion" => $this->retornaNE($this->modificacion->rectificacion),
                    "carga" => $this->retornaNE($this->modificacion->carga),
                ])
            )

                $this->estado = 'cargado';
            $this->emit("minAlert", ["titulo" => "¡BUEN TRABAJO!", "mensaje" => "Datos del vehículo actualizados correctamente", "icono" => "success"]);
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "Ocurrio un error al actualizar los datos del vehículo", "icono" => "warning"]);
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
        $this->validate(['placa' => 'min:3|max:7']);

        $vehiculos = vehiculo::where('placa', 'like', '%' . $this->placa . '%')->get();
        if ($vehiculos->count() > 0) {
            $this->busqueda = true;
            $this->vehiculos = $vehiculos;
        } else {
            $this->emit("minAlert", ["titulo" => "AVISO DEL SISTEMA", "mensaje" => "No se encontro ningún vehículo con la placa ingresada", "icono" => "warning"]);
        }
    }


    public function seleccionaVehiculo(Vehiculo $vehiculo)
    {
        $vehiculo->load('modificaciones'); // Cargar las modificaciones junto con el vehículo        
        $this->vehiculo = $vehiculo;  // Asignar el vehículo con sus modificaciones a la propiedad del componente        

        //este if es solo para que en caso el metodo last() no encuentre ninguna modificacion no lo mande nulo y no salga error las validaciones van en el certificar no aqui
        if (!empty($vehiculo->modificaciones->last())) {
            $this->modificacion = $vehiculo->modificaciones->last(); // Asignar la modificación actual (la última) a la propiedad del componente
        }
        $this->estado = 'cargado';
        if ($this->nombreDelInvocador != null) {
            $this->emitTo($this->nombreDelInvocador, 'cargaVehiculo', $vehiculo->id);
        } else {
            $this->emitTo('prueba', 'cargaVehiculo', $vehiculo->id);
        }
        // Limpiar los resultados de búsqueda
        $this->vehiculos = null;
        $this->busqueda = false;
    }
}
