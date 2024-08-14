<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\Documento;
use App\Models\DocumentoTaller;
use App\Models\Taller;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\DB;

class ReporteDocumentosTaller extends Component
{
    public $fechaInicio, $fechaFin, $talleres, $tipodocumentos;
    public  $documentos, $tallerId, $tipoDocumentoId;
    public $venceHoy;

    //para documentos faltantes
    public $docrestante;

    //para documentos subidos
    public $docSubidos;



    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->talleres = Taller::all()->sortBy('nombre');
        $this->tipodocumentos = TipoDocumento::all()->sortBy('nombreTipo');
        $this->documentos = collect();
        $this->docrestante = collect();
        $this->docSubidos = collect();
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
    }

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
    }*/

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

    public function documentosRestantes()
    {
        // Reseteamos las fechas para que no afecten la consulta
        $this->fechaInicio = null;
        $this->fechaFin = null;
        $this->venceHoy = false;

        // Aplicamos los filtros si están definidos
        $talleres = Taller::when($this->tallerId, function ($query) {
            $query->where('id', $this->tallerId);
        })->get();

        $tiposDocumentos = TipoDocumento::when($this->tipoDocumentoId, function ($query) {
            $query->where('id', $this->tipoDocumentoId);
        })->get();

        // Lista para almacenar los documentos faltantes
        $documentosFaltantes = collect();

        foreach ($talleres as $taller) {
            foreach ($tiposDocumentos as $tipoDocumento) {
                // Verificamos si el taller ya tiene los documentos para GNV y GLP
                $documentosGNV = DocumentoTaller::where('idTaller', $taller->id)
                    ->whereHas('documento', function ($query) use ($tipoDocumento) {
                        $query->where('tipoDocumento', $tipoDocumento->id);
                    })
                    ->where('combustible', 'GNV')
                    ->count();

                $documentosGLP = DocumentoTaller::where('idTaller', $taller->id)
                    ->whereHas('documento', function ($query) use ($tipoDocumento) {
                        $query->where('tipoDocumento', $tipoDocumento->id);
                    })
                    ->where('combustible', 'GLP')
                    ->count();

                // Si falta el documento GNV, lo agregamos a la lista de faltantes
                if ($documentosGNV == 0) {
                    $documentosFaltantes->push([
                        'taller' => $taller->nombre,
                        'tipoDocumento' => $tipoDocumento->nombreTipo,
                        'combustible' => 'GNV',
                    ]);
                }

                // Si falta el documento GLP, lo agregamos a la lista de faltantes
                if ($documentosGLP == 0) {
                    $documentosFaltantes->push([
                        'taller' => $taller->nombre,
                        'tipoDocumento' => $tipoDocumento->nombreTipo,
                        'combustible' => 'GLP',
                    ]);
                }
            }
        }

        // Asignamos los documentos faltantes para mostrarlos en la vista
        $this->docrestante = $documentosFaltantes;
    }

    /*public function documentosRestantes()
    {
        // Reseteamos las fechas para que no afecten la consulta
        $this->fechaInicio = null;
        $this->fechaFin = null;
        $this->venceHoy = false;

        // Aplicamos los filtros si están definidos
        $talleres = Taller::when($this->tallerId, function ($query) {
            $query->where('id', $this->tallerId);
        })->get();

        $tiposDocumentos = TipoDocumento::when($this->tipoDocumentoId, function ($query) {
            $query->where('id', $this->tipoDocumentoId);
        })->get();

        // Lista para almacenar los documentos faltantes agrupados
        $documentosFaltantes = collect();

        foreach ($talleres as $taller) {
            $faltantesGNV = [];
            $faltantesGLP = [];

            foreach ($tiposDocumentos as $tipoDocumento) {
                // Verificamos si el taller ya tiene los documentos para GNV y GLP
                $documentosGNV = DocumentoTaller::where('idTaller', $taller->id)
                    ->whereHas('documento', function ($query) use ($tipoDocumento) {
                        $query->where('tipoDocumento', $tipoDocumento->id);
                    })
                    ->where('combustible', 'GNV')
                    ->count();

                $documentosGLP = DocumentoTaller::where('idTaller', $taller->id)
                    ->whereHas('documento', function ($query) use ($tipoDocumento) {
                        $query->where('tipoDocumento', $tipoDocumento->id);
                    })
                    ->where('combustible', 'GLP')
                    ->count();

                // Si falta el documento GNV, lo agregamos al arreglo de GNV
                if ($documentosGNV == 0) {
                    $faltantesGNV[] = $tipoDocumento->nombreTipo;
                }

                // Si falta el documento GLP, lo agregamos al arreglo de GLP
                if ($documentosGLP == 0) {
                    $faltantesGLP[] = $tipoDocumento->nombreTipo;
                }
            }

            // Si hay documentos faltantes GNV, los agrupamos
            if (!empty($faltantesGNV)) {
                $documentosFaltantes->push([
                    'taller' => $taller->nombre,
                    'documentos' => implode(', ', $faltantesGNV),
                    'combustible' => 'GNV',
                ]);
            }

            // Si hay documentos faltantes GLP, los agrupamos
            if (!empty($faltantesGLP)) {
                $documentosFaltantes->push([
                    'taller' => $taller->nombre,
                    'documentos' => implode(', ', $faltantesGLP),
                    'combustible' => 'GLP',
                ]);
            }
        }

        // Asignamos los documentos faltantes para mostrarlos en la vista
        $this->docrestante = $documentosFaltantes;
    }*/

    public function documentosSubidos()
    {
        // Reseteamos las fechas para que no afecten la consulta
        $this->fechaInicio = null;
        $this->fechaFin = null;
        $this->venceHoy = false;

        // Aplicamos los filtros si están definidos
        $talleres = Taller::when($this->tallerId, function ($query) {
            $query->where('id', $this->tallerId);
        })->get();

        $tiposDocumentos = TipoDocumento::when($this->tipoDocumentoId, function ($query) {
            $query->where('id', $this->tipoDocumentoId);
        })->get();

        // Lista para almacenar los documentos subidos
        $documentosSubidos = collect();

        foreach ($talleres as $taller) {
            foreach ($tiposDocumentos as $tipoDocumento) {
                // Verificamos si el taller ya tiene los documentos para GNV y GLP
                $documentosGNV = DocumentoTaller::where('idTaller', $taller->id)
                    ->whereHas('documento', function ($query) use ($tipoDocumento) {
                        $query->where('tipoDocumento', $tipoDocumento->id);
                    })
                    ->where('combustible', 'GNV')
                    ->get();

                $documentosGLP = DocumentoTaller::where('idTaller', $taller->id)
                    ->whereHas('documento', function ($query) use ($tipoDocumento) {
                        $query->where('tipoDocumento', $tipoDocumento->id);
                    })
                    ->where('combustible', 'GLP')
                    ->get();

                // Si existen documentos GNV, los agregamos a la lista de subidos
                foreach ($documentosGNV as $documento) {
                    $documentosSubidos->push([
                        'taller' => $taller->nombre,
                        'tipoDocumento' => $tipoDocumento->nombreTipo,
                        'combustible' => 'GNV',
                    ]);
                }

                // Si existen documentos GLP, los agregamos a la lista de subidos
                foreach ($documentosGLP as $documento) {
                    $documentosSubidos->push([
                        'taller' => $taller->nombre,
                        'tipoDocumento' => $tipoDocumento->nombreTipo,
                        'combustible' => 'GLP',
                    ]);
                }
            }
        }

        // Asignamos los documentos subidos para mostrarlos en la vista
        $this->docSubidos = $documentosSubidos;
    }
}
