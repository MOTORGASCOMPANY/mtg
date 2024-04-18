<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Certificacion;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Taller;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReporteCalcularChip extends Component
{
    public $chipsConsumidos, $fechaInicio, $fechaFin;
    public $inspectores, $talleres;

    public function mount()
    {
        $this->obtenerChipsConsumidos();
        $this->inspectores = User::role(['inspector', 'supervisor'])->where('id', '!=', Auth::id())->orderBy('name')->get();
        $this->talleres = Taller::all()->sortBy('nombre');
    }

    public function render()
    {
        return view('livewire.reportes.reporte-calcular-chip');
    }

    public function obtenerChipsConsumidos()
    {
        //dd($this->chipsConsumidos);
        $this->chipsConsumidos = DB::table('material')
            ->select(
                'material.id',
                'material.idUsuario',
                'material.estado',
                'material.ubicacion',
                'material.grupo',
                'material.updated_at',
                'users.name as nombreInspector',
                'servicio.precio as precioServicio',
                //DB::raw('SUM(CASE WHEN servicio.tipoServicio_idtipoServicio = 11 THEN 1 ELSE 0 END) as cantidadChipDeterioro'),
                //DB::raw('SUM(servicio.precio) as totalPrecioServicio')
            )
            ->join('users', 'material.idUsuario', '=', 'users.id')
            ->leftJoin('serviciomaterial', 'material.id', '=', 'serviciomaterial.idMaterial')
            ->leftJoin('certificacion', 'serviciomaterial.idCertificacion', '=', 'certificacion.id')
            ->leftJoin('servicio', 'certificacion.idServicio', '=', 'servicio.id')
            ->where(function ($query) {
                $query->where([
                    ['material.estado', '=', 4],
                    ['material.idTipoMaterial', '=', 2],
                ]);
            })
            //->orWhere('servicio.tipoServicio_idtipoServicio', '=', 11)
            ->whereBetween('material.updated_at', [
                $this->fechaInicio . ' 00:00:00',
                $this->fechaFin . ' 23:59:59'
            ])

            ->where(function ($query) {
                $query->where('material.ubicacion', 'like', 'En poder del cliente %');
            })
            //->groupBy('users.name')
            ->get();
    }
}
