<?php

namespace App\Http\Livewire;

use App\Exports\ReporteTallerRsmnExport;
use App\Models\Certificacion;
use App\Models\CertificacionPendiente;
use App\Models\Desmontes;
use App\Models\ServiciosImportados;
use App\Models\Taller;
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
    'UNIGAS CONVERSIONES S.A.C.']; 
    
    public $idsTabla2 = ['CONVERSIONES SERPEGAS S.A.C. - 2',
    'CORPORACIÓN PERÚ GAS FJA E.I.R.L.',
    'TALLER PRUEBA',
    'IMPORTACIONES STAR GAS S.A.C',
    'MEGA FLASH GNV S.A.C',
    'MEGA FLASH GNV S.A.C. - SANTA ROSA',
    'MISHAEL PERU S.A.C.',
    'PJ CONVERSIONES S.A.C.',
    'WILTON MOTORS E.I.R.L -II']; 

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
        //$this->diferencias = collect($this->encontrarDiferenciaPorPlaca($this->importados, $this->tabla));
        //Merge para combinar tabla y diferencias -  strtolower para ignorar Mayusculas y Minusculas 
        $this->tabla2 = $this->tabla->merge($this->diferencias, function ($item1, $item2) {
            $inspector1 = strtolower($item1['inspector']);
            $inspector2 = strtolower($item2['inspector']);
            $taller1 = strtolower($item1['taller']);
            $taller2 = strtolower($item2['taller']);
            $comparison = strcasecmp($inspector1 . $taller1, $inspector2 . $taller2);
            return $comparison;
        });

        // Filtrar los registros de tabla2 según los criterios establecidos
        $this->tabla3 = $this->tabla2->filter(function ($item) {
            return !(
                ($item['tipo_modelo'] == 'App\Models\Certificacion' || $item['tipo_modelo'] == 'App\Models\CertificacionPendiente') &&
                $item['taller'] == 'GASCAR CONVERSIONES S.A.C' &&
                $item['externo'] == 1
            );
        });

        // Agrupamos por taller y sumamos los precios
        $this->aux = $this->tabla3->groupBy('taller')->map(function ($items) {
            return [
                'taller' => $items->first()['taller'],
                'encargado' => $items->first()['representante'],
                'total' => $items->sum('precio'),
            ];
        })->filter(function ($data) { // Filtrar talleres cuyo total sea mayor que 0
            return $data['total'] > 0;
        })->sortBy('taller');
        //dd($this->aux);
        //dd($this->tabla3);

        $this->semanales = $this->aux->filter(function ($item) {
            return in_array($item['taller'], $this->idsTabla1);
        });       
        
        $this->diarios = $this->aux->filter(function ($item) {
            return in_array($item['taller'], $this->idsTabla2);
        });

        //dd($this->semanales, $this->diarios);
    }

    public function exportarExcel($data)
    {
        //dd($data);
        return Excel::download(new ReporteTallerRsmnExport($data), 'reporte_TallerResumen.xlsx');
    }

    public function generaData()
    {
        $tabla = new Collection();
        //TODO CERTIFICACIONES:
        $certificaciones = Certificacion::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            //excluir inspectores
            ->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [117, 37, 201, 59, 55, 61, 78, 176, 98, 122, 116, 120, 62, 166, 124]);
            })
            /* Si es el taller de prueba (ID 13 GASCAR), excluye los registros con externo = 1
             ->whereHas('Taller', function ($query) {
                $query->where(function ($query) {
                    $query->where('id', '!=', 13)
                        ->orWhere('externo', '!=', 1);
                });
             })
            */
            ->where('pagado', 0)
            ->whereNotIn('estado', [2])
            ->get();

        //TODO CER-PENDIENTES:
        $cerPendiente = CertificacionPendiente::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [117, 37, 201, 59, 55, 61, 78, 176, 98, 122, 116, 120, 62, 166, 124]);
            })
            //->where('estado', 1)
            //->whereNull('idCertificacion')
            ->get();

        //TODO DESMONTES:
        $desmontes = Desmontes::IdTalleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->whereHas('Inspector', function ($query) {
                $query->whereNotIn('id', [117, 37, 201, 59, 55, 61, 78, 176, 98, 122, 116, 120, 62, 166, 124]);
            })
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
            'Jhossimar Andrew Apolaya Hong'
        ];
        /* Nombres de los certificadores a excluir para tipos de servicio 1 y 2
         $certTipoServicio = [
            'Elvis Alexander Matto Perez',
         ];
        */

        $dis = ServiciosImportados::Talleres($this->taller)
            ->RangoFecha($this->fechaInicio, $this->fechaFin)
            ->whereNotIn('certificador', $certExcluidos)
            /*->where(function($query) use ($certTipoServicio) {
                $query->where(function($subQuery) use ($certTipoServicio) {
                    $subQuery->whereNotIn('certificador', $certTipoServicio)
                             ->orWhereNotIn('tipoServicio', [1, 2]);
                });
             })
            */
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
