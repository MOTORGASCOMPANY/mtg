<?php

namespace App\Http\Livewire;

use App\Models\Anulacion;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SolicitudDevolucion as NotificationsSolicitudDevolucion;
use PharIo\Manifest\Author;

class Inventario extends Component
{

    public $todos;
    public $inspector, $inspectores, $tipoMaterial, $estado;
    public $resultado;
    //variable para devolucion
    public $salida, $mostrarDoc = false;
    public $certificacion = []; // Variable para almacenar anulaciones


    protected $rules = [
        "tipoMaterial" => "required|numeric|min:1",
        "estado" => "required",
    ];

    public function mount()
    {
        $this->inspector = Auth::id();
        $this->todos = Material::where([
            //FORMATOS EN STOCK
            ['idUsuario', Auth::id()],
        ])->get();
    }

    /*public function mount(){
        $this->todos=Material::where([
             //FORMATOS EN STOCK
            ['idUsuario',Auth::id()],
            ])->get();      
            
            //dd($this->todos);
    }*/

    public function consultar()
    {
        $this->validate();
        $this->resultado = Material::where("idUsuario", $this->inspector)
            ->TipoMaterialInvetariado($this->tipoMaterial)
            ->EstadoInvetariado($this->estado)
            ->get();
    }

    public function updated($nameProperty)
    {
        $this->validateOnly($nameProperty);
        if ($nameProperty) {
            $this->reset(["resultado"]);
        }
    }

    public function render()
    {
        return view('livewire.inventario');
    }

    public function procesarDevolucion()
    {

        DB::beginTransaction(); // Iniciar transacción para asegurar atomicidad

        try {
            $materialesAnulados = Material::where('estado', 5)
                ->whereNull('devuelto')
                ->where('idUsuario', $this->inspector)
                ->get();

            if ($materialesAnulados->isEmpty()) {
                $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "No hay materiales anulados para devolucion.", "icono" => "warning"]);
                return;
            }
            //dd($materialesAnulados);
            $cartId = (string) Str::uuid(); //cart_id único para el grupo
            // Agrupar los materiales por idTipoMaterial y añoActivo
            $agrupadosPorTipoYAnio = $materialesAnulados->groupBy(function ($material) {
                return $material->idTipoMaterial . '-' . $material->añoActivo;
            });

            foreach ($agrupadosPorTipoYAnio as $grupo => $materiales) {
                $numSeries = $materiales->pluck('numSerie')->toArray(); // Agrupar los numSerie en un array

                // Insertar en la tabla Anulacion
                Anulacion::create([
                    'motivo' => 'devolucion',
                    'idUsuario' => $this->inspector,
                    'idTipoMaterial' => $materiales->first()->idTipoMaterial,  // Tipo de material del grupo
                    'anioActivo' => $materiales->first()->añoActivo,  // Año activo del grupo
                    'cart_id' => $cartId,
                    'numSeries' => implode(',', $numSeries),
                ]);
            }

            // Obtener las anulaciones
            $anulaciones = Anulacion::where('cart_id', $cartId)->get();
            $this->certificacion = $anulaciones;
            // Obtener los IDs de los materiales anulados
            $materialesIds = $materialesAnulados->pluck('id');
            // Obtener los materiales relacionados
            $materiales = Material::whereIn('id', $materialesIds)->get();
            //dd($materiales);
            $usuarios = User::role(['administrador'])->get();
            foreach ($usuarios as $usuario) {
                Notification::send($usuario, new NotificationsSolicitudDevolucion($anulaciones, $materiales, Auth::user()));
            }

            DB::commit(); // Confirmar transacción
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Los Formatos se enviaron correctamente.", "icono" => "success"]);
            $this->mostrarDoc = true;

        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();
            $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Hubo un error al procesar los materiales", "icono" => "warning"]) . $e->getMessage();
        }
    }
}
