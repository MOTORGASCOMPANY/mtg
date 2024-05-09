<?php

namespace App\Http\Livewire\Reportes;


use Livewire\Component;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\TipoServicio;
use App\Exports\ReporteCalcularExport;
use App\Exports\ReporteCalcularExport2;
use App\Exports\ReporteCalcularSimpleExport;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteCalcularGasol extends Component
{

    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores, $certis;
    public $ins = [], $taller = [];
    public $grupoinspectores;
    public $tabla, $diferencias, $importados, $aux, $precios = [];
    public $tabla2;

    protected $listeners = ['exportarExcel'];

    protected $rules = [
        "fechaInicio" => 'required|date',
        "fechaFin" => 'required|date',
    ];

    public function mount()
    {
        $this->inspectores = User::role(['inspector', 'supervisor'])->orderBy('name')->get();
        $this->talleres = Taller::orderBy('nombre')->get();
    }
    public function render()
    {
        return view('livewire.reportes.reporte-calcular-gasol');
    }

    public function procesar()
    {
        $this->validate();
        //Carga datos de certificacion
        $this->tabla = $this->generaData();
        //Carga datos de Servicios Importados
        $this->importados = $this->cargaServiciosGasolution();
        //dd($this->importados);
        //Trim para eliminar espacios por inspector y taller
        $this->tabla = $this->tabla->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        $this->importados = $this->importados->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        //Diferencias entre tabla e importados
        $this->diferencias = $this->encontrarDiferenciaPorPlaca($this->tabla, $this->importados);
        //$this->tabla2 = $this->tabla->merge($this->diferencias);

        // Filtrar las diferencias que tienen 'servicio' = 'Duplicado GNV'
        $duplicadosGNV = $this->diferencias->filter(function ($item) {
            return $item['servicio'] === 'Duplicado GNV';
        });

        //Merge para combinar importados y diferencias -  strtolower para ignorar Mayusculas y Minusculas 
        $this->tabla2 = $this->importados->merge($duplicadosGNV, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });

        //$this->aux = $this->tabla2->groupBy('inspector')->sortBy();
        $this->aux = $this->tabla2->groupBy('inspector')->sortBy(function ($item, $key) { //para ordenar 
            return $key;
        });
        $this->sumaPrecios();
    }

    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::idTalleres($this->taller)
            ->IdInspectores($this->ins)
            ->rangoFecha($this->fechaInicio, $this->fechaFin)
            ->where('pagado', 0)
            ->whereIn('estado', [3, 1])
            ->get();

        //Lista2
        foreach ($certificaciones as $certi) {
            $data = [
                "id" => $certi->id,
                "placa" => $certi->Vehiculo->placa,
                "taller" => $certi->Taller->nombre,
                "inspector" => $certi->Inspector->name,
                "servicio" => $certi->Servicio->tipoServicio->descripcion,
                "num_hoja" => $certi->NumHoja,
                "ubi_hoja" => $certi->UbicacionHoja,
                "precio" => $certi->precio,
                "pagado" => $certi->pagado,
                "estado" => $certi->estado,
                "tipo_modelo" => $certi::class,
                "fecha" => $certi->created_at,

            ];
            $tabla->push($data);
        }
        return $tabla;
    }

    /*public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        $diferencias = [];

        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $encontrado = false;

            foreach ($lista2 as $elemento2) {
                $placa2 = $elemento2['placa'];

                if ($placa1 === $placa2) {
                    $encontrado = true;
                    break;
                }
            }

            if (!$encontrado) {
                $diferencias[] = $elemento1;
            }
        }

        return $diferencias;
    }*/

    public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        //$diferencias = [];
        $diferencias = collect();

        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $inspector1 = $elemento1['inspector'];
            $servicio1 = $elemento1['servicio'];
            $encontrado = false;

            foreach ($lista2 as $elemento2) {
                $placa2 = $elemento2['placa'];
                $inspector2 = $elemento2['inspector'];
                $servicio2 = $elemento2['servicio'];

                // Verificar si la placa, el inspector y el servicio son iguales
                if ($placa1 === $placa2 && $inspector1 === $inspector2 && $servicio1 === $servicio2) {
                    $encontrado = true;
                    break;
                }
            }

            if (!$encontrado) {
                //$diferencias[] = $elemento1;
                // Convertir el elemento actual en un objeto Collection y agregarlo a $diferencias
                $diferencias->push(collect($elemento1));
            }
        }

        return $diferencias;
    }


    public function cargaServiciosGasolution()
    {
        $disc = new Collection();
        $dis = ServiciosImportados::Talleres($this->taller)
            ->Inspectores($this->ins)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->get();

        //Lista 1
        foreach ($dis as $registro) {
            $data = [
                "id" => $registro->id,
                "placa" => $registro->placa,
                "taller" => $registro->taller,
                "inspector" => $registro->certificador,
                "servicio" => $registro->TipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $registro->precio,
                "pagado" => $registro->pagado,
                "estado" => $registro->estado,
                "tipo_modelo" => $registro::class,
                "fecha" => $registro->fecha,
            ];
            $disc->push($data);
        }
        return $disc;
    }


    public function cuentaServicios($data)
    {
        $cantidades = [];
        //$todo = $data->groupBy('servicio')->sortBy('servicio');
        $todo = collect($data)->groupBy('servicio')->sortBy('servicio');
        foreach ($todo as $servicio => $item) {
            $cantidades[$servicio] = $item->count();
        }
        return $cantidades;
    }

    public function sumaPrecios()
    {
        //$precios = [];
        $servicios = ['Revisión anual GNV', 'Conversión a GNV', 'Desmonte de Cilindro', 'Duplicado GNV'];
        $todo = $this->aux;
        //dd($todo);
        foreach ($todo as $servicio => $item) {
            $precio = 0;
            foreach ($item as $target) {
                if (in_array($target['servicio'], $servicios)) {
                    $precio += $target['precio'];
                }
            }
            $this->precios[$servicio] = $precio;
        }
        // return $precios;
    }


    public function exportarExcel($data)
    {
        // Convertir la tabla HTML en un objeto de colección
        //$tabla = collect([$data]);
        //dd($tabla);
        // Generar el archivo de Excel usando la librería Maatwebsite/Excel
        return Excel::download(new ReporteCalcularExport2($data), 'reporte_calculo.xlsx');
    }
}
