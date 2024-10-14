<?php

namespace App\Http\Livewire\Reportes;


use Livewire\Component;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Exports\ReporteCalcularExport2;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Desmontes;
use App\Models\PrecioInspector;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ReporteCalcularGasol extends Component
{

    //VARIABLES PARA REPORTE 1
    public $fechaInicio, $fechaFin, $resultados, $talleres, $inspectores, $certis;
    public $ins = [], $taller = [];
    public $grupoinspectores;
    public $tabla, $diferencias, $importados, $aux, $precios = [];
    public $tabla2;

    //VARIABLES PARA REPORTE 2
    public $servicio;
    public $mtg, $discrepancias, $gasol, $asistir;
    public $mtg2, $mtg3;
    public $semanales, $diarios;
    public $idsTabla1 = ['ARTURO MOTORS S.A.C.',
    'AUTOMOTRIZ D. SALAZAR',
    'AUTOTRONICA JOEL CARS',
    'AUTOTRONICA JOEL CARS E.I.R.L. - II',
    'CITV UNIGAS S.A.C.',
    'FACTORÍA ANGIE S.A.C.',
    'GASCAR CONVERSIONES S.A.C',
    'GEMOL E.I.R.L',
    'GREEN ENERGY PERU S.A.C',
    'INVERSIONES FAGONI S.A.C.',
    'J.R. AUTOMOTRICES S.A.C.',
    'LIFE GAS COMPANY S.A.C.',
    'REYCICAR S.A.C.',
    'REYGAS S.A.C. II',
    'SERVICIOS MULTIPLES DR SRL',
    'UNIGAS HOME S.A.C.',
    'UNIGAS CONVERSIONES S.A.C.'];

    public $idsTabla2 = ['CONVERSIONES SERPEGAS S.A.C. - 2',
    'CORPORACIÓN PERÚ GAS FJA E.I.R.L.',
    'IMPORTACIONES STAR GAS S.A.C',
    'TALLER PRUEBA',
    'MEGA FLASH GNV S.A.C',
    'MEGA FLASH GNV S.A.C. - SANTA ROSA',
    'MISHAEL PERU S.A.C.',
    'PJ CONVERSIONES S.A.C.',
    'WILTON MOTORS E.I.R.L -II'];

    //VARIABLE PARA JUNTAR LOS DOS REPORTES
    public $totalTalleres = 0;
    public $totalExternos = 0;
    public $cierreSemanal;

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



    public function calcularTotales()
    {
        $totalSemanal = collect($this->semanales)->sum('total');
        $totalDiario = collect($this->diarios)->sum('total');
        $this->totalTalleres = $totalSemanal + $totalDiario;
        $this->totalExternos = collect($this->precios)->sum();
        $this->cierreSemanal = $this->totalTalleres + $this->totalExternos;
    }

    //JUNTAR REPORTES
    public function reportes()
    {
        $this->validate();
        $this->procesar();
        $this->procesar2();
        $this->calcularTotales();
    }

    //PROCESAR 1
    public function procesar()
    {
        //$this->validate();
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
            'York Darly Cruz Ampuero',
            'Cristopher Lee Barzola Carhuancho',
            'Erick Daniel Pachas Sanchez',
            'Jhonatan Michael Basilio Soncco'
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

    //PROCESAR 2
    public function procesar2()
    {
        //$this->validate();
        $this->mtg = $this->generaData2();
        $this->gasol = $this->cargaServiciosGasolution2();
        $this->mtg = $this->mtg->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        $this->gasol = $this->gasol->map(function ($item) {
            $item['placa'] = trim($item['placa']);
            $item['inspector'] = trim($item['inspector']);
            $item['taller'] = trim($item['taller']);
            return $item;
        });
        $this->discrepancias = $this->encontrarDiferenciaPorPlaca2($this->gasol, $this->mtg);
        //Merge para combinar mtg y discrepancias -  strtolower para ignorar Mayusculas y Minusculas 
        $this->mtg2 = $this->mtg->merge($this->discrepancias, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });

        // Filtrar excluir externos a gascar
        $this->mtg3 = $this->mtg2->filter(function ($item) {
            return !(
                ($item['tipo_modelo'] == 'App\Models\Certificacion' || $item['tipo_modelo'] == 'App\Models\CertificacionPendiente') &&
                ($item['taller'] == 'GASCAR CONVERSIONES S.A.C' || $item['taller'] == 'REYCICAR S.A.C.') &&
                $item['externo'] == 1
            );
        });

        // Definir relacion entre talleres e inspectores
        $mapaTalleresInspectores = [
            'ARTURO MOTORS S.A.C.' => ['Miguel Alexis Lacerna Aycachi'],
            'LIFE GAS COMPANY S.A.C.' => ['Julio Roger Cabanillas Cornejo'],
            'GREEN ENERGY PERU S.A.C' => ['Gris Yordin Bonifacio Rivera'],
            'WILTON MOTORS E.I.R.L -II' => ['Ricardo Jesus Meza Espinal'],
            'UNIGAS HOME S.A.C.' => ['Ronaldo Piero Navarro Endara'],
            'CITV UNIGAS S.A.C.' => ['Adrian Suarez Perez'],
            'UNIGAS CONVERSIONES S.A.C.' => ['Jhon Antonio Diaz Lobo', 'Ronaldo Piero Navarro Endara'],
            'MISHAEL PERU S.A.C.' => ['Jhonatan Michael Basilio Soncco', 'Jhon Antonio Diaz Lobo', 'Gris Yordin Bonifacio Rivera'],
            'INVERSIONES FAGONI S.A.C.' => ['Elmer Jesus Canares Minaya'],
            'CORPORACIÓN PERÚ GAS FJA E.I.R.L.' => ['Jhunior Meza Arroyo', 'Cristhian Smith Huanay Condor'],
            'IMPORTACIONES STAR GAS S.A.C' => ['Gianella Isabel Sanchez Herrera', 'Cristhian David Saenz Nuñez'],
            'MEGA FLASH GNV S.A.C' => ['Rolly Garcia Barrozo', 'Oscar Enrique Soto Vega'],
            'MEGA FLASH GNV S.A.C. - SANTA ROSA' => ['Rolly Garcia Barrozo', 'Oscar Enrique Soto Vega'],
            'J.R. AUTOMOTRICES S.A.C.' => ['Jaison Aurelio Aquino Antunez', 'Jhon Antonio Diaz Lobo', 'Elmer Jesus Canares Minaya', 'Erick Daniel Pachas Sanchez'],
            'CONVERSIONES SERPEGAS S.A.C. - 2' => ['Emanuel Fernando Salazar Martinez'],
            'REYCICAR S.A.C.' => ['Cristhian David Saenz Nuñez'],
            'REYGAS S.A.C. II' => ['Jennifer Alexandra Villarreal Polo'],
            'AUTOTRONICA JOEL CARS' => ['Luis Alberto Esteban Torres'], 
            'AUTOTRONICA JOEL CARS E.I.R.L. - II' => ['Luis Alberto Esteban Torres']
        ];
        
        $this->asistir = $this->mtg3->groupBy('taller')->map(function ($items) use ($mapaTalleresInspectores) {
            $taller = $items->first()['taller'];
            $inspectoresDesignados = $mapaTalleresInspectores[$taller] ?? null;
            $itemsFiltrados = $items;

            if ($inspectoresDesignados) {
                $itemsFiltrados = $items->filter(function ($item) use ($inspectoresDesignados) {
                    return in_array($item['inspector'], $inspectoresDesignados);
                });
            }

            return [
                'taller' => $taller,
                'encargado' => $itemsFiltrados->first()['representante'] ?? null,
                'total' => $itemsFiltrados->sum('precio'),
            ];
        })->filter(function ($data) { // Filtrar talleres cuyo total sea mayor que 0
            return $data['total'] > 0;
        })->sortBy('taller');

        $this->semanales = $this->asistir->filter(function ($item) {
            return in_array($item['taller'], $this->idsTabla1);
        });

        $this->diarios = $this->asistir->filter(function ($item) {
            return in_array($item['taller'], $this->idsTabla2);
        });
    }


    
    public function exportarExcel($exportData)
    {
        return Excel::download(new ReporteCalcularExport2($exportData), 'reporte_calculo.xlsx');
    }


    //FUNCIONES PARA REPORTE 1
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

    //FUNCIONES PARA REPORTE 2

    public function generaData2()
    {
        $mtg = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            /*->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [117, 37, 201, 59, 55, 61, 78, 176, 98, 122, 116, 120, 62, 166, 124, 52]);
            })*/
            ->where('pagado', 0)
            ->whereNotIn('estado', [2])
            ->get();

        //TODO CER-PENDIENTES:
        $cerPendiente = CertificacionPendiente::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            /*->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [117, 37, 201, 59, 55, 61, 78, 176, 98, 122, 116, 120, 62, 166, 124, 52]);
            })*/
            ->get();

        //TODO DESMONTES:
        $desmontes = Desmontes::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            /*->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [117, 37, 201, 59, 55, 61, 78, 176, 98, 122, 116, 120, 62, 166, 124, 52]);
            })*/
            ->get();

        //unificando certificaciones     
        foreach ($certificaciones as $certi) {
            $data = [
                "id" => $certi->id,
                "placa" => $certi->Vehiculo->placa,
                "taller" => $certi->Taller->nombre,
                "representante" => $certi->Taller->representante,
                "inspector" => $certi->Inspector->name,
                "servicio" => $certi->Servicio->tipoServicio->descripcion,
                "num_hoja" => $certi->NumHoja,
                "ubi_hoja" => $certi->UbicacionHoja,
                "precio" => $certi->precio,
                "pagado" => $certi->pagado,
                "estado" => $certi->estado,
                "externo" => $certi->externo,
                "tipo_modelo" => $certi::class,
                "fecha" => $certi->created_at,

            ];
            $mtg->push($data);
        }

        foreach ($cerPendiente as $cert_pend) {
            //modelo preliminar
            $data = [
                "id" => $cert_pend->id,
                "placa" => $cert_pend->Vehiculo->placa,
                "taller" => $cert_pend->Taller->nombre,
                "representante" => $cert_pend->Taller->representante,
                "inspector" => $cert_pend->Inspector->name,
                "servicio" => 'Activación de chip (Anual)',
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $cert_pend->precio,
                "pagado" => $cert_pend->pagado,
                "estado" => $cert_pend->estado,
                "externo" => $cert_pend->externo,
                "tipo_modelo" => $cert_pend::class,
                "fecha" => $cert_pend->created_at,
            ];
            $mtg->push($data);
        }

        foreach ($desmontes as $des) {
            $data = [
                "id" => $des->id,
                "placa" => $des->placa,
                "taller" => $des->Taller->nombre,
                "representante" => $des->Taller->representante,
                "inspector" => $des->Inspector->name,
                "servicio" => $des->Servicio->tipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $des->precio,
                "pagado" => $des->pagado,
                "estado" => $des->estado,
                "externo" => $des->externo,
                "tipo_modelo" => $des::class,
                "fecha" => $des->created_at,
            ];
            $mtg->push($data);
        }
        return $mtg;
    }

    public function encontrarDiferenciaPorPlaca2($lista1, $lista2)
    {
        $discrepancias = [];

        foreach ($lista1 as $elemento1) {
            $placa1 = $elemento1['placa'];
            $inspector1 = $elemento1['inspector'];
            $servicio1 = $elemento1['servicio'];
            $encontrado = false;
            // Excluir el servicio 'Revisión anual GNV' para que no muestre como discrepancia 'Activación de chip (Anual)'
            foreach ($lista2 as $elemento2) {
                $placa2 = $elemento2['placa'];
                $inspector2 = $elemento2['inspector'];
                $servicio2 = $elemento2['servicio'];

                if ($placa1 === $placa2 && $inspector1 === $inspector2) {
                    if (
                        ($elemento2['tipo_modelo'] == 'App\Models\CertificacionPendiente' && $servicio1 == 'Revisión anual GNV') ||
                        ($servicio2 == 'Conversión a GNV + Chip' && $servicio1 == 'Conversión a GNV')
                    ) {
                        $encontrado = true;
                        break;
                    } else if ($servicio1 === $servicio2) {
                        $encontrado = true;
                        break;
                    }
                }
            }

            if (!$encontrado) {
                $diferencias[] = $elemento1;
            }
        }
        return $discrepancias;
    }

    public function cargaServiciosGasolution2()
    {
        $disc = new Collection();
        // Nombres de los certificadores a excluir
        $certExcluidos = [
            'Inspector Prueba 2',
            'Inspector Prueba',
            'YERSON JAIRO CAICEDO MORI',
            'Beaker Javier Yzaguirre Herrera',
            'Hector Guillermo Burga Cordova',
            'Elvis Obregon Espinoza',
            'Noe Fernandez Salazar',
            'Carlos Julca Pusma',
            'Jose Ricarte Guevara Maluquis',
            'Jose Antonio Quispe De la Cruz',
            'Victor Hugo Quispe Zapana',
            'Raul Llata Pacheco',
            'Elmer Alvarado Ramos',
            'Carlos Rojas Cule',
            'Jhossimar Andrew Apolaya Hong',
            'Jhonatan Isaac Garcia Tavara'
        ];

        $dis = ServiciosImportados::Talleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->whereNotIn('certificador', $certExcluidos)
            ->get();

        foreach ($dis as $registro) {
            $data = [
                "id" => $registro->id,
                "placa" => $registro->placa,
                "taller" => $registro->taller,
                "representante" => $registro->representante,
                "inspector" => $registro->certificador,
                "servicio" => $registro->TipoServicio->descripcion,
                "num_hoja" => Null,
                "ubi_hoja" => Null,
                "precio" => $registro->precio,
                "pagado" => $registro->pagado,
                "estado" => $registro->estado,
                "externo" => Null,
                "tipo_modelo" => $registro::class,
                "fecha" => $registro->fecha,
            ];
            $disc->push($data);
        }
        return $disc;
    }
}
