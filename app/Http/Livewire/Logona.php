<?php

namespace App\Http\Livewire;

use App\Exports\ReporteTallerRsmnExport;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Desmontes;
use App\Models\ServiciosImportados;
use App\Models\Taller;
use App\Models\TallerInspector;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;

class Logona extends Component
{
    public $fechaInicio, $fechaFin, $talleres, $inspectores, $servicio;
    public $ins = [], $taller = [];
    public $tabla, $diferencias, $importados, $aux;
    public $tabla2, $tabla3;
    public $semanales, $diarios;

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
        return view('livewire.logona');
    }

    public function procesar()
    {
        $this->validate();
        $this->tabla = $this->generaData();
        $this->importados = $this->cargaServiciosGasolution();
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
        $this->diferencias = $this->encontrarDiferenciaPorPlaca($this->importados, $this->tabla);
        //Merge para combinar tabla y diferencias -  strtolower para ignorar Mayusculas y Minusculas 
        $this->tabla2 = $this->tabla->merge($this->diferencias, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });

        // Filtrar excluir externos a gascar
        $this->tabla3 = $this->tabla2->filter(function ($item) {
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

        // Agrupamos por taller y sumamos los precios
        /*$this->aux = $this->tabla3->groupBy('taller')->map(function ($items) {
            return [
                'taller' => $items->first()['taller'],
                'encargado' => $items->first()['representante'],
                'total' => $items->sum('precio'),
            ];
         })->filter(function ($data) { // Filtrar talleres cuyo total sea mayor que 0
            return $data['total'] > 0;
         })->sortBy('taller');
        */
        /*$this->aux = $this->tabla3->groupBy('taller')->map(function ($items) use ($mapaTalleresInspectores) {
            $taller = $items->first()['taller'];
            $inspectoresDesignados = $mapaTalleresInspectores[$taller] ?? null;
            $itemsFiltrados = $items;

            if ($inspectoresDesignados) {
                $itemsFiltrados = $items->filter(function ($item) use ($inspectoresDesignados) {
                    return in_array($item['inspector'], $inspectoresDesignados);
                });
            }*/
        $this->aux = $this->tabla3->groupBy('taller')->map(function ($items) {
            $taller = $items->first()['taller'];

            // Obtener los IDs de los inspectores para el taller
            $inspectoresIds = TallerInspector::where('taller_id', Taller::where('nombre', $taller)->value('id'))
                ->pluck('inspector_id')
                ->toArray();

            // Obtener los nombres de los inspectores usando los IDs
            $inspectoresDesignados = User::whereIn('id', $inspectoresIds)
                ->pluck('name')
                ->toArray();

            // Filtrar los ítems según los inspectores designados
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

        // Filtrar los talleres según los nuevos campos es_diario y es_semanal
        $this->semanales = $this->aux->filter(function ($item) {
            return Taller::where('nombre', $item['taller'])->value('es_semanal') == 1;
        });

        $this->diarios = $this->aux->filter(function ($item) {
            return Taller::where('nombre', $item['taller'])->value('es_diario') == 1;
        });
    }

    public function exportarExcel($data)
    {
        return Excel::download(new ReporteTallerRsmnExport($data), 'reporte_TallerResumen.xlsx');
    }

    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            //excluir inspectores
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
            $tabla->push($data);
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
            $tabla->push($data);
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
            $tabla->push($data);
        }
        return $tabla;
    }

    public function encontrarDiferenciaPorPlaca($lista1, $lista2)
    {
        $diferencias = [];

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
        return $diferencias;
    }

    public function cargaServiciosGasolution()
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
            //->whereNotIn('certificador', $certExcluidos)
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
