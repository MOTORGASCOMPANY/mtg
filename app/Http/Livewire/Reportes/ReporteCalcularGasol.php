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
use App\Models\PrecioInspector;
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

        // Lista de inspectores a excluir
        $insExcluir = [
            'Adrian Suarez Perez',
            'Cristhian David Saenz Nuñez',
            'Cristhian Smith Huanay Condor',
            'Elmer Jesus Canares Minaya',
            'Elvis Alexander Matto Perez',
            'Emanuel Fernando Salazar Martinez',
            'Gianella Isabel Sanchez Herrera',
            'Gianfranco Charyv Garcia Camacho',
            'Gris Yordin Bonifacio Rivera',
            'Harrinson Jesus Cordova Vilela',
            'Jaison Aurelio Aquino Antunez',
            'Javier Alfredo Chevez Parcano',
            'Jennifer Alexandra Villarreal Polo',
            'Jhon Antonio Diaz Lobo',
            'Jhunior Meza Arroyo',
            'Julio Roger Cabanillas Cornejo',
            'Luis Alberto Esteban Torres',
            'Luis Amorr Huacho Cruz',
            'Miguel Alexis Lacerna Aycachi',
            'Oscar Enrique Soto Vega',
            'Raul Llata Pacheco',
            'Ricardo Jesus Meza Espinal',
            'Ronaldo Piero Navarro Endara',
            'York Darly Cruz Ampuero'
        ];

        // Excluir inspectores del reporte
        $this->tabla2 = $this->tabla2->reject(function ($item) use ($insExcluir) {
            return in_array($item['inspector'], $insExcluir);
        });

        $this->aux = $this->tabla2->groupBy('inspector')->sortBy(function ($item, $key) {
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
        foreach ($dis as $registro) {
            // Buscar el inspector en precios_inspector basado en el name del certificador (inspector)
            $inspector = User::where('name', $registro->certificador)->first();            
            $precio = 0; // Inicializar el precio en 0
            // Verificar si existe el inspector
            if ($inspector) {
                // Buscar el servicio en precios_inspector comparando por idServicio
                $precioInspector = PrecioInspector::where('idUsers', $inspector->id)
                    ->whereHas('tipoServicio', function ($query) use ($registro) {
                        // Comparar la descripción del servicio
                        $query->where('descripcion', $registro->TipoServicio->descripcion);
                    })
                    ->first();
                // Si se encuentra un precio en precios_inspector, asignarlo
                if ($precioInspector) {
                    $precio = $precioInspector->precio;
                }
            }
            $data = [
                "id" => $registro->id,
                "placa" => $registro->placa,
                "taller" => $registro->taller,
                "inspector" => $registro->certificador,
                "servicio" => $registro->TipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $precio,
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
        return Excel::download(new ReporteCalcularExport2($data), 'reporte_calculo.xlsx');
    }
}
