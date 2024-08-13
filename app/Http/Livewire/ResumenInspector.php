<?php

namespace App\Http\Livewire;

use App\Models\Certificacion;
use Carbon\Carbon;
use Livewire\Component;

class ResumenInspector extends Component
{
    public $periodo = 'dia'; // Por defecto, se muestra el rendimiento del día actual

    public function render()
    {
        // Obtener la fecha inicial y final basada en el periodo seleccionado
        $fechaInicio = Carbon::now()->startOfDay();
        $fechaFin = Carbon::now()->endOfDay();

        if ($this->periodo == 'semana') {
            $fechaInicio = Carbon::now()->startOfWeek();
            $fechaFin = Carbon::now()->endOfWeek();
        } elseif ($this->periodo == 'mes') {
            $fechaInicio = Carbon::now()->startOfMonth();
            $fechaFin = Carbon::now()->endOfMonth();
        }

        // Consultar las certificaciones dentro del periodo seleccionado usando el scope 'rangoFecha'
        $certificaciones = Certificacion::rangoFecha($fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d'))
            ->with(['Inspector', 'Taller']) // Cargar la relación Inspector
            ->get();

        // Agrupar por idInspector y contar el número de certificaciones por inspector
        $inspectores = $certificaciones->groupBy('idInspector')->map(function ($inspectorCerts, $idInspector) {
            return [
                'name' => $inspectorCerts->first()->Inspector->name, // Obtener el nombre del inspector
                'count' => $inspectorCerts->count(),
            ];
        });

        // Limitar a los 3 mejores inspectores
        $inspectoresTop = $inspectores->sortByDesc('count')->take(3);

        // Agrupar el resto en "Otros"
        $otrosInspectores = $inspectores->sortByDesc('count')->skip(3);
        $otrosTotal = $otrosInspectores->sum('count');

        if ($otrosTotal > 0) {
            $inspectoresTop->put('Otros', ['name' => 'Otros', 'count' => $otrosTotal]);
        }

        // Determinar el mejor inspector
        $mejorInspector = $inspectoresTop->sortByDesc('count')->first();
        $mejorInspectorNombre = $mejorInspector['name'] ?? 'No hay datos';
        $mejorInspectorCertificaciones = $mejorInspector['count'] ?? 0;

        // Preparar datos para el gráfico circular
        $dataInspectores = $inspectoresTop->pluck('name')->toArray(); // Array de nombres de inspectores
        $dataCertificaciones = $inspectoresTop->pluck('count')->toArray(); // Array de número de certificaciones

        // Agrupar por taller y contar el número de certificaciones por taller
        $talleres = $certificaciones->groupBy('idTaller')->map(function ($tallerCerts, $idTaller) {
            return [
                'name' => $tallerCerts->first()->Taller->nombre, // Obtener el nombre del taller
                'count' => $tallerCerts->count(),
            ];
        });

        // Limitar a los 3 mejores talleres
        $talleresTop = $talleres->sortByDesc('count')->take(3);

        // Agrupar el resto en "Otros"
        $otrosTalleres = $talleres->sortByDesc('count')->skip(3);
        $otrosTalleresTotal = $otrosTalleres->sum('count');

        if ($otrosTalleresTotal > 0) {
            $talleresTop->put('Otros', ['name' => 'Otros', 'count' => $otrosTalleresTotal]);
        }

        // Determinar el mejor taller
        $mejorTaller = $talleresTop->sortByDesc('count')->first();
        $mejorTallerNombre = $mejorTaller['name'] ?? 'No hay datos';
        $mejorTallerCertificaciones = $mejorTaller['count'] ?? 0;

        // Preparar datos para el gráfico circular de talleres
        $dataTalleres = $talleresTop->pluck('name')->toArray(); // Array de nombres de talleres
        $dataTallerCertificaciones = $talleresTop->pluck('count')->toArray(); // Array de número de certificaciones por taller

        return view('livewire.resumen-inspector', [
            'dataInspectores' => $dataInspectores,
            'dataCertificaciones' => $dataCertificaciones,
            'mejorInspectorNombre' => $mejorInspectorNombre,
            'mejorInspectorCertificaciones' => $mejorInspectorCertificaciones,
            'dataTalleres' => $dataTalleres,
            'dataTallerCertificaciones' => $dataTallerCertificaciones,
            'mejorTallerNombre' => $mejorTallerNombre,
            'mejorTallerCertificaciones' => $mejorTallerCertificaciones,
        ]);
    }
}
