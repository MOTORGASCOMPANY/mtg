<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\Documento;
use App\Models\Taller;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

class ReporteDocumentosTaller extends Component
{
    public $fechaInicio, $fechaFin, $talleres, $tipodocumentos;
    public  $documentos, $tallerId, $tipoDocumentoId;
    public $venceHoy;

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->talleres = Taller::all()->sortBy('nombre');
        $this->tipodocumentos = TipoDocumento::all()->sortBy('nombreTipo');
        $this->documentos = collect();
    }

    public function render()
    {
        return view('livewire.reportes.reporte-documentos-taller');
    }

    /* public function generarReporte()
    {
        $this->validate();

        // Obtener documentos próximos a vencer
        $this->documentos = Documento::whereBetween('fechaExpiracion', [$this->fechaInicio, $this->fechaFin])
            ->when($this->tallerId, function ($query) {
                $query->whereHas('talleres', function ($subQuery) {
                    $subQuery->where('id', $this->tallerId);
                });
            })
            ->when($this->tipoDocumentoId, function ($query) {
                $query->where('tipoDocumento', $this->tipoDocumentoId);
            })
            ->with(['talleres', 'TipoDocumento'])
            ->get();
    }*/

    public function generarReporte2()
    {
        $this->validate();
        // Obtener documentos próximos a vencer
        $this->documentos = Documento::whereBetween('fechaExpiracion', [$this->fechaInicio, $this->fechaFin])
            ->when($this->tallerId, function ($query) {
                $query->whereHas('talleres', function ($subQuery) {
                    $subQuery->where('taller.id', $this->tallerId);
                });
            })
            ->when($this->tipoDocumentoId, function ($query) {
                $query->where('tipoDocumento', $this->tipoDocumentoId);
            })
            ->with(['talleres', 'tipoDocumento', 'documentostaller'])
            ->get();
    }

    public function venceHoy()
    {
        $this->fechaInicio = null;
        $this->fechaFin = now()->format('Y-m-d');
        $this->venceHoy = true;

        $documentos = Documento::where('fechaExpiracion', '<=', $this->fechaFin)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('documentostaller')
                    ->join('taller', 'taller.id', '=', 'documentostaller.idTaller')
                    ->whereRaw('documento.id = documentostaller.idDocumento')
                    ->when($this->tallerId, function ($query) {
                        $query->where('taller.id', $this->tallerId);
                    })
                    ->when($this->tipoDocumentoId, function ($query) {
                        $query->where('documento.tipoDocumento', $this->tipoDocumentoId);
                    });
            })
            ->get();
        $this->documentos = $documentos;
    }
}
