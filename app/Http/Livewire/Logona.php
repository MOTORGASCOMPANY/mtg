<?php

namespace App\Http\Livewire;

use App\Models\Anulacion;
use Livewire\Component;
use App\Models\Material;
use App\Models\TipoMaterial;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\SolicitudDevolucion as NotificationsSolicitudDevolucion;

class Logona extends Component
{
    public $inspector, $tipoMaterial;
    public $desde, $hasta, $anioActivo;
    public $resultado;
    public $estado = false;
    public $certificacion;
    public $carrito = [];
    public $cart_id;

    public function mount()
    {
        $this->inspector = Auth::id();
        $this->cart_id = uniqid();
    }

    public function updated($property)
    {
        if ($this->tipoMaterial && $this->anioActivo) {
            $this->estado = true;
        } else {
            $this->estado = false;
        }
    }


    public function agregarAlCarrito()
    {
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required',
            'tipoMaterial' => 'required',
            'anioActivo' => 'required',
        ]);

        $seriesValidas = Material::where('idUsuario', $this->inspector)
            ->where('idTipoMaterial', $this->tipoMaterial)
            ->where('estado', 3)
            ->where('añoActivo', $this->anioActivo)
            ->whereBetween('numSerie', [$this->desde, $this->hasta])
            ->get();
        //dd($seriesValidas);
        $totalSeriesEsperadas = $this->hasta - $this->desde + 1;
        //dd($totalSeriesEsperadas, $seriesValidas);
        if ($seriesValidas->count() !== $totalSeriesEsperadas) { //$seriesValidas !== $totalSeriesEsperadas
            $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Revisa en tu inventario el estado de formatos a devolver, (Menu-Materiales-Inventario).", "icono" => "warning"]);
        } else {
            // Obtener el nombre del tipo de material
            $nombreTipoMaterial = TipoMaterial::find($this->tipoMaterial)->descripcion;
            // Agregar al carrito
            $this->carrito[] = [
                'idTipoMaterial' => $this->tipoMaterial,
                'nombreTipo' => $nombreTipoMaterial,
                'numSerieDesde' => $this->desde,
                'numSerieHasta' => $this->hasta,
                'anioActivo' => $this->anioActivo,
                'motivo' => 'devolucion', // Motivo por defecto
                'cart_id' => $this->cart_id,
            ];
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE!", "mensaje" => "Formatos agregados al carrito.", "icono" => "success"]);
            $this->reset(['desde', 'hasta']);
            //$this->reset(['tipoMaterial', 'anioActivo', 'desde', 'hasta']);
        }
    }

    public function aceptar()
    {
        // Crear registros de anulación
        foreach ($this->carrito as $item) {
            //dd($item);
            Anulacion::create([
                'idUsuario' => $this->inspector,
                'idTipoMaterial' => $item['idTipoMaterial'],
                'numSerieDesde' => $item['numSerieDesde'],
                'numSerieHasta' => $item['numSerieHasta'],
                'anioActivo' => $item['anioActivo'],
                'motivo' => $item['motivo'],
                'cart_id' => $item['cart_id'],
            ]);
        }

        //$this->certificacion = $this->carrito;
        // Obtener certificaciones basadas en el cart_id
        $this->certificacion = Anulacion::where('cart_id', $this->cart_id)->get();
        $this->carrito = []; // Vaciar el carrito después de guardar
        $this->cart_id = uniqid();
        $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Los Formatos fueron guardadas correctamente.", "icono" => "success"]);

        // Obtener las anulaciones
        $anulaciones = Anulacion::where('cart_id', $this->certificacion->first()->cart_id)->get();
        //dd($anulaciones);

        //Obtener los materiales
        /*$materiales = Material::where('idUsuario', $this->inspector)
            ->whereIn('idTipoMaterial', $anulaciones->pluck('idTipoMaterial'))
            ->where('estado', 3)
            ->where('añoActivo', $this->anioActivo)
            ->whereBetween('numSerie', [$anulaciones->min('numSerieDesde'), $anulaciones->max('numSerieHasta')])
            ->get();*/
        $materiales = Material:://where('idUsuario', $this->inspector)
            //->where('estado', 3)
            //->where('añoActivo', $this->anioActivo)
            where(function ($query) use ($anulaciones) {
                foreach ($anulaciones as $anulacion) {
                    $query->orWhere(function ($q) use ($anulacion) {
                        $q->where('idTipoMaterial', $anulacion->idTipoMaterial)
                            ->where('añoActivo', $anulacion->anioActivo)
                            ->whereBetween('numSerie', [$anulacion->numSerieDesde, $anulacion->numSerieHasta]);
                    });
                }
            })
            /*->where(function ($query) use ($anulaciones) {
                foreach ($anulaciones as $anulacion) {
                    $query->orWhereBetween('numSerie', [$anulacion->numSerieDesde, $anulacion->numSerieHasta])
                          ->where('idTipoMaterial', $anulacion->idTipoMaterial);
                }
            })*/
            ->get();
        //dd($materiales);
        $usuarios = User::role(['administrador'])->get();
        foreach ($usuarios as $usuario) {
            Notification::send($usuario, new NotificationsSolicitudDevolucion($anulaciones, $materiales, Auth::user()));
        }
    }

    public function render()
    {
        return view('livewire.logona', [
            'materiales' => $this->resultado,
            'certificacion' => $this->certificacion,
            'carrito' => $this->carrito,
        ]);
    }


    /*public function aceptar()
    {
        $this->validate([
            'desde' => 'required',
            'hasta' => 'required',
            'tipoMaterial' => 'required',
            'anioActivo' => 'required',
        ]);

        $seriesValidas = Material::where('idUsuario', $this->inspector)
            ->where('idTipoMaterial', $this->tipoMaterial)
            ->where('estado', 3)
            ->where('añoActivo', $this->anioActivo)
            ->whereBetween('numSerie', [$this->desde, $this->hasta])
            ->count();

        // Verificamos si el número de registros encontrados es igual al rango de números
        $totalSeriesEsperadas = $this->hasta - $this->desde + 1;

        if ($seriesValidas !== $totalSeriesEsperadas) {
            $this->emit("minAlert", ["titulo" => "ERROR", "mensaje" => "Algunas de las series no cumplen con el estado requerido.", "icono" => "warning"]);
        } else {
            $anulacion = Anulacion::create([
                'idUsuario' => $this->inspector,
                'idTipoMaterial' => $this->tipoMaterial,
                'numSerieDesde' => $this->desde,
                'numSerieHasta' => $this->hasta,
                'motivo' => 'devolucion', // devolucion por defecto

            ]);
            $this->certificacion = $anulacion;
            $this->emit("minAlert", ["titulo" => "¡EXCELENTE TRABAJO!", "mensaje" => "Las series fueron encontradas correctamente.", "icono" => "success"]);
        }
    }*/
}
